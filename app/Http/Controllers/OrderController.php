<?php

namespace App\Http\Controllers;

use App\Mail\RestaurantCallbackMail;
use App\Repositories\Orders\OrderRepoGenerator;
use App\Exports\OrdersExport;
use App\Notifications\OrderNotification;
use App\Order;
use App\Restorant;
use App\Services\SmsService;
use App\Status;
use App\User;
use Carbon\Carbon;
use Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SmsAlert\SmsClient;
use willvincent\Rateable\Rating;
use App\Services\ConfChanger;
use Akaunting\Module\Facade as Module;
use App\Coupons;
use App\Events\OrderAcceptedByAdmin;
use App\Events\OrderAcceptedByVendor;
use App\Models\Orderitems;
use App\Models\SimpleDelivery;

class OrderController extends Controller
{


    public function migrateStatuses()
    {
        if (Status::count() < 13) {
            $statuses = ['Just created', 'Accepted by admin', 'Accepted by restaurant', 'Assigned to driver', 'Prepared', 'Picked up', 'Delivered', 'Rejected by admin', 'Rejected by restaurant', 'Updated', 'Closed', 'Rejected by driver', 'Accepted by driver'];
            foreach ($statuses as $key => $status) {
                Status::updateOrCreate(['name' => $status], ['alias' =>  str_replace(' ', '_', strtolower($status))]);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->migrateStatuses();

        $restorants = Restorant::where(['active'=>1])->get();
        $drivers = auth()->user()->myDrivers();
        $clients = User::role('client')->where(['active'=>1])->get();

        $driversData = [];
        foreach ($drivers as $key => $driver) {
            $driversData[$driver->id] = $driver->name;
        }

        $orders = Order::orderBy('created_at', 'desc')->whereNotNull('restorant_id');

        //Get client's orders
        if (auth()->user()->hasRole('client')) {
            $orders = $orders->where(['client_id'=>auth()->user()->id]);
        } elseif (auth()->user()->hasRole('driver')) {
            $orders = $orders->where(['driver_id'=>auth()->user()->id]);
        } elseif (auth()->user()->hasRole('owner')) {

            //Change currency
            ConfChanger::switchCurrency(auth()->user()->restorant);

            $orders = $orders->where(['restorant_id'=>auth()->user()->restorant->id]);
        }elseif (auth()->user()->hasRole('staff')) {

            //Change currency
            ConfChanger::switchCurrency(auth()->user()->restaurant);

            $orders = $orders->where(['restorant_id'=>auth()->user()->restaurant_id]);
        }

        //FILTER BT RESTORANT
        if (isset($_GET['restorant_id'])) {
            $orders = $orders->where(['restorant_id'=>$_GET['restorant_id']]);
        }
        //If restorant owner, get his restorant orders only
        if (auth()->user()->hasRole('owner')) {
            //Current restorant id
            $restorant_id = auth()->user()->restorant->id;
            $orders = $orders->where(['restorant_id'=>$restorant_id]);
        }

        //BY CLIENT
        if (isset($_GET['client_id'])) {
            $orders = $orders->where(['client_id'=>$_GET['client_id']]);
        }

        //BY DRIVER
        if (isset($_GET['driver_id'])) {
            $orders = $orders->where(['driver_id'=>$_GET['driver_id']]);
        }

        //BY DATE FROM
        if (isset($_GET['fromDate']) && strlen($_GET['fromDate']) > 3) {
            $orders = $orders->whereDate('created_at', '>=', $_GET['fromDate']);
        }

        //BY DATE TO
        if (isset($_GET['toDate']) && strlen($_GET['toDate']) > 3) {
            $orders = $orders->whereDate('created_at', '<=', $_GET['toDate']);
        }

        //FILTER BT status
        if (isset($_GET['status_id'])) {
            $orders = $orders->whereHas('laststatus', function($q){
                $q->where('status_id', $_GET['status_id']);
            });
        }else{
            $orders = $orders->whereHas('laststatus', function($q){
                $q->whereNotIn('status_id', [8,9]);
            });
        }

         //FILTER BT payment status
         if (isset($_GET['payment_status'])&&strlen($_GET['payment_status'])>2) {
            $orders = $orders->where('payment_status', $_GET['payment_status']);
        }

        //With downloaod
        if (isset($_GET['report'])) {
            $items = [];
            foreach ($orders->get() as $key => $order) {
                $item = [
                    'order_id'=>$order->id,
                    'restaurant_name'=>$order->restorant->name,
                    'restaurant_id'=>$order->restorant_id,
                    'created'=>$order->created_at,
                    'last_status'=>$order->status->pluck('alias')->last(),
                    'client_name'=>$order->client ? $order->client->name : '',
                    'client_id'=>$order->client ? $order->client_id : null,
                    'table_name'=>$order->table ? $order->table->name : '',
                    'table_id'=>$order->table ? $order->table_id : null,
                    'area_name'=>$order->table && $order->table->restoarea ? $order->table->restoarea->name : '',
                    'area_id'=>$order->table && $order->table->restoarea ? $order->table->restoarea->id : null,
                    'address'=>$order->address ? $order->address->address : '',
                    'address_id'=>$order->address_id,
                    'driver_name'=>$order->driver ? $order->driver->name : '',
                    'driver_id'=>$order->driver_id,
                    'order_value'=>$order->order_price_with_discount,
                    'order_delivery'=>$order->delivery_price,
                    'order_total'=>$order->delivery_price + $order->order_price_with_discount,
                    'payment_method'=>$order->payment_method,
                    'srtipe_payment_id'=>$order->srtipe_payment_id,
                    'order_fee'=>$order->fee_value,
                    'restaurant_fee'=>$order->fee,
                    'restaurant_static_fee'=>$order->static_fee,
                    'vat'=>$order->vatvalue,
                  ];
                array_push($items, $item);
            }

            return Excel::download(new OrdersExport($items), 'orders_'.time().'.xlsx');
        }

        $orders = $orders->paginate(10);

        return view('orders.index', [
            'statuses'=>Status::pluck('name','id')->toArray(),
            'orders' => $orders,
            'restorants'=>$restorants,
            'drivers'=>$drivers,
            'fields'=>[['class'=>'col-12', 'classselect'=>'noselecttwo', 'ftype'=>'select', 'name'=>'Driver', 'id'=>'driver', 'placeholder'=>'Assign Driver', 'data'=>$driversData, 'required'=>true]],
            'clients'=>$clients,
            'parameters'=>count($_GET) != 0,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    private function toRideMobileLike(Request $request){
        //Data
        $driver=User::findOrFail($request->driver_id);
        $vendor_id = $driver->restaurant_id;

       $requestData=[
           'issd'=>true,
           'vendor_id'   => $vendor_id,
           'driver_id' => $request->driver_id,
           'delivery_method'=> "delivery",
           'payment_method'=> "cod",
           'address_id'=>null,
           'pickup_address'=>$request->pickup_address,
           'pickup_lat'=>$request->pickup_lat,
           'pickup_lng'=>$request->pickup_lng,
           'delivery_address'=>$request->delivery_address,
           'delivery_lat'=>$request->delivery_lat,
           'delivery_lng'=>$request->delivery_lng,
           "timeslot"=>"",
           "items"=>[],
           "comment"=>$request->comment,
           "phone"=>$request->phoneclient,
       ];
       return new Request($requestData);

    }

    private function toMobileLike(Request $request){

        //Find vendor id
        $vendor_id = null;
        foreach (Cart::getContent() as $key => $item) {
            $vendor_id = $item->attributes->restorant_id;
        }
        $restorant = Restorant::findOrFail($vendor_id);

        //Organize the item
        $items=[];
        foreach (Cart::getContent() as $key => $item) {
            $extras=[];
            foreach ($item->attributes->extras as $keyExtra => $extra_id) {
                array_push($extras,array('id'=>$extra_id));
            }
            array_push($items,array(
                "id"=>$item->attributes->id,
                "qty"=>$item->quantity,
                "variant"=>$item->attributes->variant,
                "extrasSelected"=>$extras,
                "comment" => $item->attributes->comment
            ));
        }


        //stripe token
        $stripe_token=null;
        if($request->has('stripePaymentId')){
            $stripe_token=$request->stripePaymentId;
        }

        //Custom fields
        $customFields=[];
        if($request->has('custom')){
            $customFields=$request->custom;
        }


        if($request->has('customFields_client_name')) {
            $customFields['client_name'] = $request->customFields_client_name;
        }

        if($request->has('customFields_email')) {
            $customFields['email'] = $request->customFields_email;
        }



        //DELIVERY METHOD
        //Default - pickup - since available everywhere
        $delivery_method="pickup";

        //Delivery method - deliveryType - ft
        if($request->has('deliveryType')){
            $delivery_method=$request->deliveryType;
        }else if($restorant->can_pickup == 0 && $restorant->can_deliver == 1){
            $delivery_method="delivery";
        }

        //Delivery method  - dineType - qr
        if($request->has('dineType')){
            $delivery_method=$request->dineType;
        }



        //In case it is QR, and there is no dineInType, and pickup is diabled, it is dine in
        if(config('app.isqrsaas')&&!$request->has('dineType')&&!(config('settings.is_whatsapp_ordering_mode')||config('settings.is_agris_mode'))){
            $delivery_method='dinein';
        }
        //takeaway is pickup
        if($delivery_method=="takeaway"){
            $delivery_method="pickup";
        }

        //Table id
        $table_id=null;
        if($request->has('table_id')){
            $table_id=$request->table_id;
        }

         //Phone
         $phone=null;
         if($request->has('phone_user')){
             $phone=\Str::replace(' ', '', $request->phone_user);
         }


        //Delivery area
        $deliveryAreaId=$request->has('delivery_area')?$request->delivery_area:null;
        if($deliveryAreaId){
            //Set this in custom field
            $deliveryAreaName="";
            $deliveryAreaElement=SimpleDelivery::find($request->delivery_area);
            if($deliveryAreaElement){
                $deliveryAreaName=$deliveryAreaElement->name;
            }
            $customFields['delivery_area_name']=$deliveryAreaName;
        }


        $requestData=[
            'vendor_id'   => $vendor_id,
            'delivery_method'=> $delivery_method,
            'payment_method'=> $request->paymentType ? $request->paymentType:"cod",
            'address_id'=>$request->addressId,
            "timeslot"=>$request->timeslot,
            "items"=>$items,
            "comment"=>$request->comment,
            "stripe_token"=>$stripe_token,
            "dinein_table_id"=>$table_id,
            "phone"=>$phone,
            "customFields"=>$customFields,
            "deliveryAreaId"=> $deliveryAreaId,
            "coupon_code"=> $request->has('coupon_code')&&strlen($request->coupon_code)>3?$request->coupon_code:null
        ];



        return new Request($requestData);
    }

    public function store(Request $request){


        //Convert web request to mobile like request
        if(config('app.issd',false)||$request->has('issd')){
            //Web ride
            $mobileLikeRequest=$this->toRideMobileLike($request);
        }else{
            //Web order
            $mobileLikeRequest=$this->toMobileLike($request);
        }


        //Data
        $vendor_id =  $mobileLikeRequest->vendor_id;
        $expedition= $mobileLikeRequest->delivery_method;
        $hasPayment= $mobileLikeRequest->payment_method!="cod";
        $isStripe= $mobileLikeRequest->payment_method=="stripe";

        $vendorHasOwnPayment=null;
        if(config('settings.social_mode')||config('app.issd',false)){
            //Find the vendor, and check if he has payment

            $vendor=Restorant::findOrFail($mobileLikeRequest->vendor_id);

            //Payment methods
            foreach (Module::all() as $key => $module) {
                if($module->get('isPaymentModule')){
                    if($vendor->getConfig($module->get('alias')."_enable","false")=="true"){
                        $vendorHasOwnPayment=$module->get('alias');
                    }
                }
            }

            if($vendorHasOwnPayment==null){
                $hasPayment=false;
            }else{
                //Since v3, don't auto select payment model, show all the  options to  user
                $vendorHasOwnPayment="all";
            }
        }

        //Repo Holder
        $orderRepo=OrderRepoGenerator::makeOrderRepo($vendor_id,$mobileLikeRequest,$expedition,$hasPayment,$isStripe,false,$vendorHasOwnPayment);

        //Proceed with validating the data
        $validator=$orderRepo->validateData();


        if($request->ajax()) {
            if ($validator->fails()) {
                return $validator->errors();
            }

            return [];
        }

        if ($validator->fails()) {
            notify()->error($validator->errors()->first());
            return $orderRepo->redirectOrInform($validator->errors());
        }

        //Proceed with making the order
        $validatorOnMaking=$orderRepo->makeOrder();
        if ($validatorOnMaking->fails()) {
            notify()->error($validatorOnMaking->errors()->first());
            return $orderRepo->redirectOrInform();
        }

        $data = [
            'payload' => [
                'shopname'    => $orderRepo->order->restorant->shop_id ? $orderRepo->order->restorant->shop_id : $orderRepo->order->restorant->name,
//                'shopname' => 'test9898',
                'orderString' => $this->getOrderAsFormatedString($orderRepo->order),
            ],

            'order' => $orderRepo->order,
        ];


        $url = config('settings.nodejs_server_order');
        $ch = curl_init( $url );
        $payload = json_encode( $data['payload'] );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);

        $orderRepo->order->request_query_log = json_encode($data['payload']);
        $orderRepo->order->save();

        curl_close($ch);
        OrderAcceptedByVendor::dispatch($data);

        return $orderRepo->redirectOrInform();
    }


    private function getOrderAsFormatedString($order) {

        $p_rest_id            = '#RestID*';
        $p_delivery_or_pickup = strtoupper($order->getExpeditionType()) . '*';
        //var_dump($p_delivery_or_pickup);exit;
        $p_order_number       = $order->id.'*';
        //$p_items='|1|Sliced beef sliced very very long title |7.10|>SIZE:Large(+10.00)>NO:Capsicum>EXTRA:Basil(+1.50)>Comments:Extra crispy please and easy on cheese;|2|Pork|5.50|*';
        $p_items = substr($this->getTextFileItemsDescription($order), 0, -1); //remove last ";"

        $p_items = $p_items . '*';
        $p_discount = $order->discount . ';';

        $p_total_amount = '$' . number_format($order->order_price+($order->delivery_price + $order->fee), 2, '.', '') . ';;';

        $name = request()->customFields_client_name. '\\';
        $address = request()->addressId;

        $deliveryArea = false;

        if(request()->delivery_area) {
            $deliveryArea = $order->restorant->deliveryareas->where('id', request()->delivery_area)->first()->name;

        }

        $stringInfo = $name. ($address ? $address.'\\': '') . ($deliveryArea ? $deliveryArea .'\\' : '');
        $p_total_amount .= $stringInfo. ';';


        if($p_delivery_or_pickup == 'DELIVERY*') {
            $p_cust_name = $order->client->name . '\n' . $order->wahtsapp_address . ';';
        }
        else {
            $p_cust_name = $order->client != null ? $order->client->name.';' : 'No Customer' . ';';
        }


        if($order->delivery_pickup_interval == 'asap') {
            $p_asap_or_later = 'ASAP'. ';';
        }
        else {
            $p_asap_or_later = $order->created_at . ';';
        }

        $p_deliver_and_other_fees = '$' . number_format($order->delivery_price + $order->fee, 2) . ';';
//        $p_paid_or_not = $order->payment_status;

//        if($p_paid_or_not == 'unpaid') {
//            $p_paid_or_not = 'NOT PAID';
//        }
//        else {
//            $p_paid_or_not = 'PAID';
//        }

        $p_payment_method = $order->payment_method . ';';

        if($p_payment_method == 'cod;') {
            $p_payment_method = 'Cash on Delivery;';
            $p_paid_or_not = 'NOT PAID';
        }
        else {
            $p_payment_method = 'Credit card online;';
            $p_paid_or_not = 'PAID';
        }


        $p_cust_mobile = $order->phone != null ? $order->phone . '*' : '';
        $p_order_comment = strip_tags($order->comment);

        $p_order_comment = trim(str_replace('ORDER COMMENTS: :', '' , $p_order_comment));

        $p_order_comment = str_replace('&nbsp;', '' , $p_order_comment).'*';
        if ($p_order_comment == '*') {
            $p_order_comment == '';
        }

        $p_order_received_at = 'ORDER RECEIVED: ' . date("H:i m-d") . '*';
        $p_part_order = '#'; //add "PART1/2 if neccessary - TO DO LATER"
        $p_printer_data = $p_rest_id . $p_delivery_or_pickup . $p_order_number . $p_items . $p_discount . $p_total_amount . $p_asap_or_later . $p_deliver_and_other_fees . $p_paid_or_not . ' - ' . $p_payment_method . $p_cust_mobile . $p_order_comment . $p_order_received_at . $p_part_order;
        $p_printer_data = strip_tags($p_printer_data);
        $p_printer_data = trim(preg_replace('/\s+/', ' ', $p_printer_data)); //remove line breaks*/


        return $p_printer_data;
    }

    private function getTextFileItemsDescription($order)
    {
        $order_txt = '';
        foreach ($order->items as $key => $item) {
            $price = $item->price;
            $remove          = '';
            $extra           = '';
            $comment         = !empty($item->pivot->comment) ? '>COMMENTS:'. $item->pivot->comment : '';
            $variation_group = '';

            if($item->pivot->variant_name) {
                $price = $item->pivot->variant_price;
                $options = $item->options->toArray();
                $vat_name_arr = explode(',' , $item->pivot->variant_name);
                foreach ($vat_name_arr as $key => $vat_value) {
                    if(ucwords(strtoupper($options[$key]['name'])) == "SIZE") {
                        $variation_group .= '>' . ucwords(strtoupper($options[$key]['name'])) . ': ' . ucwords($vat_value);
                    }
                    else {
                        $variation_group .= '>' . ucwords(strtoupper($options[$key]['name'])) . ': ' . ucwords($vat_value) . '(+' . number_format($item->pivot->vatvalue, 2) . ')';
                    }
                }

            }

            /*if($item->description != null) {
                $comment = '>COMMENTS: ' . $item->description;
            }*/


            if($item->pivot->extras !=  null) {
                $extra_arr = json_decode($item->pivot->extras, true);

                foreach ($extra_arr as $extra_val) {

                    $extra_words = explode('+', $extra_val);
                    if(!isset($extra_words[1])) {
                        continue;
                    }
//                    $price += (float)str_replace('$', '', $extra_words[1]);
                    $extra .= '>EXTRA: ' . ucwords($extra_words[0]) . '(+' . number_format((float)str_replace('$', '', $extra_words[1]), 2).')';
                }
            }

            $price = $price * $item->pivot->qty;

            $order_txt .= '|' . $item->pivot->qty . '|' . ucwords($item->name) . '|' . number_format($price, 2) . '|' . $variation_group . $remove . $extra . $comment. ';';
        }

        return $order_txt;
    }


    public function orderLocationAPI(Order $order)
    {
        if ($order->status->pluck('alias')->last() == 'picked_up') {
            return response()->json(
                [
                    'status'=>'tracing',
                    'lat'=>$order->lat,
                    'lng'=>$order->lng,
                    ]
            );
        } else {
            return response()->json(['status'=>'not_tracing']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //Do we have pdf invoice
        $pdFInvoice=Module::has('pdf-invoice');

        //Change currency
        ConfChanger::switchCurrency($order->restorant);

        //Change language
        ConfChanger::switchLanguage($order->restorant);

        if($order->restorant){
             //Set config based on restaurant
            config(['app.timezone' => $order->restorant->getConfig('time_zone',config('app.timezone'))]);
        }


        $drivers =auth()->user()->myDrivers();

        $driversData = [];
        foreach ($drivers as $key => $driver) {
            $driversData[$driver->id] = $driver->name;
        }

        if (auth()->user()->hasRole('client') && auth()->user()->id == $order->client_id ||
            auth()->user()->hasRole('owner') && auth()->user()->id == $order->restorant->user->id ||
            auth()->user()->hasRole('staff') && auth()->user()->restaurant_id == $order->restorant->id ||
                auth()->user()->hasRole('driver') && auth()->user()->id == $order->driver_id || auth()->user()->hasRole('admin')
            ) {


                $orderModules=[];
                foreach (Module::all() as $key => $module) {
                    if($module->get('isOrderModule')){
                        array_push($orderModules,$module->get('alias'));
                    }
                }

            return view('orders.show', [
                'order'=>$order,
                'pdFInvoice'=>$pdFInvoice,
                'custom_data'=>$order->getAllConfigs(),
                'statuses'=>Status::pluck('name', 'id'),
                'drivers'=>$drivers,
                'orderModules'=>$orderModules,
                'fields'=>[['class'=>'col-12', 'classselect'=>'noselecttwo', 'ftype'=>'select', 'name'=>'Driver', 'id'=>'driver', 'placeholder'=>'Assign Driver', 'data'=>$driversData, 'required'=>true]],
            ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the order item count
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Order $order)
    {
        if (auth()->user()->hasRole('owner') && auth()->user()->id == $order->restorant->user->id ||
            auth()->user()->hasRole('staff') && auth()->user()->restaurant_id == $order->restorant->id ||
            auth()->user()->hasRole('admin')
            ) {



                //Don't allow all 0 qty
                $zeroQty=0;
                foreach ($order->items()->get() as $key => $item) {
                    if($item->pivot->id==$request->pivot_id){

                        if($request->item_qty.""=="0"){
                            $zeroQty++;
                        }
                    }else{
                        if($item->pivot->qty==0){
                            $zeroQty++;
                        }
                    }
                }
                if($zeroQty==$order->items()->count()){
                    return redirect()->route('orders.show',$order->id)->withStatus(__('Can not set all qty to 0. You can reject order instead'));
                }

                //Directly find the pivot
                foreach ($order->items()->get() as $key => $item) {
                    if($item->pivot->id==$request->pivot_id){
                        $oi=Orderitems::findOrFail($item->pivot->id);
                        $oi->qty=$request->item_qty;
                        $oi->update();

                        //$order->items()->updateExistingPivot($item, array('qty' => $request->item_qty), false);
                        $totalRecaluclatedVAT = $request->item_qty * ($item->vat > 0?$item->pivot->variant_price * ($item->vat / 100):0);

                        $oi->vatvalue=$request->$totalRecaluclatedVAT;
                        $oi->update();
                        //$order->items()->updateExistingPivot($item, array('vatvalue' => $totalRecaluclatedVAT), false);
                    }
                }

                 //After we have updated the list of items, we need to update the order price
                $order_price=0;
                $total_order_vat=0;
                foreach ($order->items()->get() as $key => $item) {
                    $order_price+=$item->pivot->qty*$item->pivot->variant_price;
                    $total_order_vat+=$item->pivot->vatvalue;
                }
                $order->order_price=$order_price;
                $order->vatvalue=$total_order_vat;
                $order->update();

                //If this order have discount, recaluclate deduct, it can be percentage based
                if(strlen($order->coupon)>0){
                    $coupon = Coupons::where(['code' => $order->coupon])->get()->first();
                    if($coupon){
                        $deduct=$coupon->calculateDeduct($order->order_price);
                        if($deduct){
                            $order->discount=$deduct;
                        }
                    }
                }
                $order->update();

                return redirect()->route('orders.show',$order->id)->withStatus(__('Order updated.'));
                //You can update the order
            }else{
                return redirect()->route('orders.show',$order->id)->withStatus(__('No Access.'));
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function liveapi()
    {

        if (auth()->user()->hasRole('client')) {
            abort(404,'Not allowed as client');
        }

        //Today only
        $orders = Order::where('created_at', '>=', Carbon::today())->orderBy('created_at', 'desc');

        //If owner, only from his restorant
        if (auth()->user()->hasRole('owner')||auth()->user()->hasRole('staff')) {
            $resto=auth()->user()->restorant;

            $orders = $orders->where(['restorant_id'=>$resto->id]);

            //Change currency
            ConfChanger::switchCurrency($resto);

            //Set config based on restaurant
            config(['app.timezone' => $resto->getConfig('time_zone',config('app.timezone'))]);

            //Change language
            //ConfChanger::switchLanguage($order->restorant);
        }
        $orders = $orders->with(['status', 'client', 'restorant', 'table.restoarea'])->get()->toArray();


        $newOrders = [];
        $acceptedOrders = [];
        $doneOrders = [];

        $items = [];
        foreach ($orders as $key => $order) {
            $client="";
            if(config('app.isft')){
                $client=$order['client']['name'];

                if($order['table']&&$order['table']['restoarea']&&$order['table']['restoarea']['name']&&$order['table']['name']){
                    $client=$order['table']['restoarea']['name'].' - '.$order['table']['name'];
                }else if($order['table']&&$order['table']['name']){
                    $client=$order['table']['name'];
                }else{
                    //If the order was made by a registered user, returns his name
                    $client=$order['client']['name'];
                }
            }else{
                if(!config('settings.is_whatsapp_ordering_mode')){
                    //QR
                    if($order['table']&&$order['table']['restoarea']&&$order['table']['restoarea']['name']&&$order['table']['name']){
                        $client=$order['table']['restoarea']['name'].' - '.$order['table']['name'];
                    }else if($order['table']&&$order['table']['name']){
                        $client=$order['table']['name'];
                    }
                }else{
                    //WhatsApp
                    $client=$order['phone'];
                }
            }
            array_push($items, [
                'id'=>$order['id'],
                'restaurant_name'=>$order['restorant']['name'],
                'last_status'=>count($order['status']) > 0 ? __($order['status'][count($order['status']) - 1]['name']) : 'Just created',
                'last_status_id'=>count($order['status']) > 0 ? $order['status'][count($order['status']) - 1]['pivot']['status_id'] : 1,
                'time'=>Carbon::create($order['updated_at'])->locale(config('app.locale'))->isoFormat('LLLL'),
                'client'=>$client,
                'link'=>'/orders/'.$order['id'],
                'price'=>money($order['order_price'], config('settings.cashier_currency'), config('settings.do_convertion')).'',
            ]);
        }

        //----- ADMIN ------
        if (auth()->user()->hasRole('admin')) {
            foreach ($items as $key => $item) {
                //Box 1 - New Orders
                //Today orders that are just created ( Needs approvment or rejection )
                //Box 2 - Accepted
                //Today orders approved by Restaurant , or by admin( Needs assign to driver )
                //Box 3 - Done
                //Today orders assigned with driver, or rejected
                if ($item['last_status_id'] == 1) {
                    $item['pulse'] = 'blob green';
                    array_push($newOrders, $item);
                } elseif ($item['last_status_id'] == 2 || $item['last_status_id'] == 3) {
                    $item['pulse'] = 'blob orangestatic';
                    if ($item['last_status_id'] == 3) {
                        $item['pulse'] = 'blob orange';
                    }
                    array_push($acceptedOrders, $item);
                } elseif ($item['last_status_id'] > 3) {
                    $item['pulse'] = 'blob greenstatic';
                    if ($item['last_status_id'] == 9 || $item['last_status_id'] == 8) {
                        $item['pulse'] = 'blob redstatic';
                    }
                    array_push($doneOrders, $item);
                }
            }
        }

        //----- Restaurant ------
        if (auth()->user()->hasRole('owner')||auth()->user()->hasRole('staff')) {
            foreach ($items as $key => $item) {


                //Box 1 - New Orders
                //Today orders that are approved by admin ( Needs approvment or rejection )
                //Box 2 - Accepted
                //Today orders approved by Restaurant ( Needs change of status to done )
                //Box 3 - Done
                //Today completed or rejected
                $last_status = $item['last_status_id'];
                if ($last_status == 2 || $last_status == 10 || ($item['last_status_id'] == 1)) {
                    $item['pulse'] = 'blob green';
                    array_push($newOrders, $item);
                } elseif ($last_status == 3 || $last_status == 4 || $last_status == 5) {
                    $item['pulse'] = 'blob orangestatic';
                    if ($last_status == 3) {
                        $item['pulse'] = 'blob orange';
                    }
                    array_push($acceptedOrders, $item);
                } elseif ($last_status > 5 && $last_status != 8) {
                    $item['pulse'] = 'blob greenstatic';
                    if ($last_status == 9 || $last_status == 8) {
                        $item['pulse'] = 'blob redstatic';
                    }
                    array_push($doneOrders, $item);
                }
            }
        }

        $toRespond = [
                'neworders'=>$newOrders,
                'accepted'=>$acceptedOrders,
                'done'=>$doneOrders,
            ];

        return response()->json($toRespond);
    }

    public function live()
    {
        return view('orders.live');
    }

    public function autoAssignToDriver(Order $order)
    {
        //The restaurant id
        $restaurant_id = $order->restorant_id;
        if($order->restorant->self_deliver.""=="1"){
            //Don't use self assign when restaurant deliver on their own
            return null;
        }

        //1. Get all the working drivers, where active and working
        $theQuery = User::role('driver')->where(['active'=>1, 'working'=>1])->whereNull('restaurant_id');

        //2. Get Drivers with their assigned order, where payment_status is unpaid yet, this order is still not delivered and not more than 1
        $theQuery = $theQuery->whereHas('driverorders', function (Builder $query) {
            $query->where('payment_status', '!=', 'paid')->where('created_at', '>=', Carbon::today());
        }, '<=', 1);

        //Get Restaurant lat / lng
        $restaurant = Restorant::findOrFail($restaurant_id);
        $lat = $restaurant->lat;
        $lng = $restaurant->lng;

        //3. Sort drivers by distance from the restaurant
        $driversWithGeoIDS = $this->scopeIsWithinMaxDistance($theQuery, $lat, $lng, config('settings.driver_search_radius'), 'users')->pluck('id')->toArray();

        //4. The top driver gets the order
        if (count($driversWithGeoIDS) == 0) {
            //No driver found -- this will appear in  the admin list also in the list of free order so driver can get an order
        } else {
            //Driver found
            $order->driver_id = $driversWithGeoIDS[0];
            $order->update();
            $order->status()->attach([4 => ['comment'=>'System', 'user_id' => $driversWithGeoIDS[0]]]);

            //Now increment the driver orders
            $theDriver = User::findOrFail($order->driver_id);
            $theDriver->numorders = $theDriver->numorders + 1;
            $theDriver->update();
        }
    }

    public function updateStatus($alias, Order $order)
    {
        if (isset($_GET['driver'])) {
            $order->driver_id = $_GET['driver'];
            $order->update();

            //Now increment the driver orders
            $theDriver = User::findOrFail($order->driver_id);
            $theDriver->numorders = $theDriver->numorders + 1;
            $theDriver->update();
        }

        if (isset($_GET['time_to_prepare'])) {
            $order->time_to_prepare = $_GET['time_to_prepare'];
            $order->update();
        }

        $status_id_to_attach = Status::where('alias', $alias)->value('id');

        //Check access before updating
        /**
         * 1 - Super Admin
         * accepted_by_admin
         * assigned_to_driver
         * rejected_by_admin.
         *
         * 2 - Restaurant
         * accepted_by_restaurant - 3
         * prepared
         * rejected_by_restaurant
         * picked_up
         * delivered
         *
         * 3 - Driver
         * picked_up
         * delivered
         */
        //

        $rolesNeeded = [
            'accepted_by_admin'=>'admin',
            'assigned_to_driver'=>['admin','owner'],
            'rejected_by_admin'=>'admin',
            'accepted_by_restaurant'=>['owner', 'staff'],
            'prepared'=>['owner', 'staff'],
            'rejected_by_restaurant'=>['owner', 'staff'],
            'picked_up'=>['driver', 'owner', 'staff'],
            'delivered'=>['driver', 'owner', 'staff'],
            'closed'=>['owner', 'staff'],
            'accepted_by_driver'=>['driver'],
            'rejected_by_driver'=>['driver']
        ];

        if (! auth()->user()->hasRole($rolesNeeded[$alias])) {
            abort(403, 'Unauthorized action. You do not have the appropriate role');
        }

        //For owner - make sure this is his order
        if (auth()->user()->hasRole('owner')) {
            //This user is owner, but we must check if this is order from his restaurant
            if (auth()->user()->id != $order->restorant->user_id) {
                abort(403, 'Unauthorized action. You are not owner of this order restaurant');
            }
        }

        if (auth()->user()->hasRole('sstaff')) {
            //This user is owner, but we must check if this is order from his restaurant
            if (auth()->user()->restaurant_id != $order->restorant->id) {
                abort(403, 'Unauthorized action. You are not owner of this order restaurant');
            }
        }

        //For driver - make sure he is assigned to this order
        if (auth()->user()->hasRole('driver')) {
            //This user is owner, but we must check if this is order from his restaurant
            if (auth()->user()->id != $order->driver->id) {
                abort(403, 'Unauthorized action. You are not driver of this order');
            }
        }

        /**
         * IF status
         * Accept  - 3
         * Prepared  - 5
         * Rejected - 9.
         */

        if (config('app.isft')&&$order->client) {
            if ($status_id_to_attach.'' == '3' || $status_id_to_attach.'' == '5' || $status_id_to_attach.'' == '9') {
                $order->client->notify(new OrderNotification($order, $status_id_to_attach));
            }

            if ($status_id_to_attach.'' == '4') {
                $order->driver->notify(new OrderNotification($order, $status_id_to_attach));
            }
        }

        //Picked up - start tracing
        if ($status_id_to_attach.'' == '6') {
            $order->lat = $order->restorant->lat;
            $order->lng = $order->restorant->lng;
            $order->update();
        }

        if (config('app.isft') && $alias.'' == 'delivered') {
            $order->payment_status = 'paid';
            $order->update();
        }

        if (config('app.isqrsaas') && $alias.'' == 'closed') {
            $order->payment_status = 'paid';
            $order->update();
        }

        if (config('app.isft')) {
            //When orders is accepted by restaurant, auto assign to driver
            if ($status_id_to_attach.'' == '3') {
                if (config('settings.allow_automated_assign_to_driver')) {
                    $this->autoAssignToDriver($order);
                }
            }
        }

        $order->status()->attach([$status_id_to_attach => ['comment'=>'', 'user_id' => auth()->user()->id]]);


        //Dispatch event
        if($alias=="accepted_by_restaurant"){
            OrderAcceptedByVendor::dispatch($order);
        }
        if($alias=="accepted_by_admin"){
            //IN FT send email
            if (config('app.isft')) {
                $order->restorant->user->notify((new OrderNotification($order))->locale(strtolower(config('settings.app_locale'))));
            }

            OrderAcceptedByAdmin::dispatch($order);
        }


        return redirect()->route('orders.index')->withStatus(__('Order status succesfully changed.'));
    }

    public function rateOrder(Request $request, Order $order)
    {
        $restorant = $order->restorant;

        $rating = new Rating;
        $rating->rating = $request->ratingValue;
        $rating->user_id = auth()->user()->id;
        $rating->order_id = $order->id;
        $rating->comment = $request->comment;

        $restorant->ratings()->save($rating);

        return redirect()->route('orders.show', ['order'=>$order])->withStatus(__('Order succesfully rated!'));
    }

    public function checkOrderRating(Order $order)
    {
        $rating = DB::table('ratings')->select('rating')->where(['order_id' => $order->id])->get()->first();
        $is_rated = false;

        if (! empty($rating)) {
            $is_rated = true;
        }

        return response()->json(
            [
                'rating' => $rating->rating,
                'is_rated' => $is_rated,
                ]
        );
    }

    public function guestOrders()
    {
        $previousOrders = Cookie::get('orders') ? Cookie::get('orders') : '';
        $previousOrderArray = array_filter(explode(',', $previousOrders));

        //Find the orders
        $orders = Order::whereIn('id', $previousOrderArray)->orderBy('id', 'desc')->get();
        $backUrl = url()->previous();
        foreach ($orders as $key => $order) {
            $backUrl = route('vendor', $order->restorant->subdomain);
        }

        return view('orders.luxe.guestorders', ['backUrl'=>$backUrl, 'orders'=>$orders, 'statuses'=>Status::pluck('name', 'id')]);
    }


    public function generateOrderMsg($address, $comment, $price)
    {
        $title = 'New order #'.strtoupper(Str::random(5))."\n\n";

        $price = '*Price*: '.$price.' '.config('settings.cashier_currency')."\n\n";

        $items = '*Order:*'."\n";
        foreach (Cart::getContent() as $key => $item) {
            $items .= strval($item->quantity).' x '.$item->name."\n";
        }
        $items .= "\n";
        $final = $title.$price.$items;

        if ($address != null) {
            $final .= '*Address*:'."\n".$address."\n\n";
        }

        if ($comment != null) {
            $final .= '*Comment:*'."\n".$comment."\n\n";
        }

        return urlencode($final);
    }

    public function fbOrderMsg(Request $request)
    {
        $orderPrice = Cart::getSubTotal();

        $title = 'New order #'.strtoupper(Str::random(5))."\n\n";

        $price = '*Price*: '.$orderPrice.' '.config('settings.cashier_currency')."\n\n";

        $items = '*Order:*'."\n";
        foreach (Cart::getContent() as $key => $item) {
            $items .= strval($item->quantity).' x '.$item->name."\n";
        }
        $items .= "\n";
        $final = $title.$price.$items;

        if ($request->address != null) {
            $final .= '*Address*:'."\n".$request->address."\n\n";
        }

        if ($request->comment != null) {
            $final .= '*Comment:*'."\n".$request->comment."\n\n";
        }

        return response()->json(
            [
                'status' => true,
                'msg' => $final,
            ]
        );
    }

    public function storeWhatsappOrder(Request $request)
    {
        $restorant_id = null;
        foreach (Cart::getContent() as $key => $item) {
            $restorant_id = $item->attributes->restorant_id;
        }

        $restorant = Restorant::findOrFail($restorant_id);

        $orderPrice = Cart::getSubTotal();

        if ($request->exists('deliveryType')) {
            $isDelivery = $request->deliveryType == 'delivery';
        }

        $text = $this->generateWhatsappOrder($request->exists('addressID') ? $request->addressID : null, $request->exists('comment') ? $request->comment : null, $orderPrice);

        $url = 'https://wa.me/'.$restorant->whatsapp_phone.'?text='.$text;

        Cart::clear();

        return Redirect::to($url);
    }

    public function cancel(Request $request)
    {
        $order = Order::findOrFail($request->order);
        return view('orders.cancel', ['order' => $order]);
    }

    public function  silentWhatsAppRedirect(Request $request){
        $order = Order::findOrFail($request->order);
        $message=$order->getSocialMessageAttribute(true);
        $url = 'https://api.whatsapp.com/send?phone='.$order->restorant->whatsapp_phone.'&text='.$message;
        return view('orders.luxe.success', ['order' => $order,'showWhatsApp'=>false,'whatsappurl'=>$url]);
    }

    public function success(Request $request)
    {
        $order = Order::findOrFail($request->order);
        //If order is not paid - redirect to payment
        if($request->redirectToPayment.""=="1"&&$order->payment_status != 'paid'&&strlen($order->payment_link)>5){
            //Redirect to payment
            return redirect($order->payment_link);
        }

        //If we have whatsapp send
        if($request->has('whatsapp')){
            $message=$order->getSocialMessageAttribute(true);
            $url = 'https://api.whatsapp.com/send?phone='.$order->restorant->whatsapp_phone.'&text='.$message;
            return Redirect::to($url);
        }

        //Should we show whatsapp send order
        $showWhatsApp=config('settings.whatsapp_ordering_enabled');

        if($showWhatsApp){
            //Disable when WhatsApp Mode
            if(config('settings.is_whatsapp_ordering_mode')){
                $showWhatsApp=false;
            }

            //In QR, if owner phone is not set, hide the button
            //In FT, we use owner phone to have the number
            if(strlen($order->restorant->whatsapp_phone)<3){
                $showWhatsApp=false;
            }
        }

        // A success page accordign to Luxe Theme Checkout
        return view('orders.luxe.success', ['order' => $order,'showWhatsApp'=>$showWhatsApp]);
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    function callback(Request $request) {
        /*
         * Copied from old repo
         */

        $real_id = $request->get("o");
        $restaurant_answer = $request->get("ak");
        $deliver_in = strtolower($request->get("dt"));

        if(strpos($deliver_in, 'as_requested') !== false) {
            $deliver_in= ' as requested';
        }

        if(strpos($deliver_in, '_minutes')!==false) {
            $deliver_in=' within '.str_replace("_", " ", $deliver_in); // remove _
        }

        $why_rejected = $request->get("m");

        /*
         * Mix new and old code
         */

        /** @var Order $order */
        $order = Order::find($real_id);

        if (null === $order) {
            return response('Order is not found');
        }

        /** @var Restorant $restaurant */
        $restaurant = $order->restorant;

        if (null === $restaurant) {
            throw new \Exception('Restourant is not found');
        }

        $rest_name = $restaurant->name;
        $rest_www = $request->subdomain;

        switch($order->delivery_method) {
            case 1:
                $pickup_or_delivery = 'D';
                break;

            default:
                $pickup_or_delivery = 'P';
        }

        if(strtolower($restaurant_answer) == 'accepted') {
            $why_rejected = 'na';
            $email_subject = ("$rest_name - The chef has accepted your order");

            if ($pickup_or_delivery == 'P') {
                $_email_content = 'Good news! The chef has accepted your order. It will be ready for pickup' . $deliver_in .'. ' . "$rest_name, $rest_www. Auto SMS; please don't reply";
                $email_subject = ("Pickup $deliver_in accepted");
            } else {
                $_email_content = 'Good news! The chef has accepted your order. It will be delivered' . $deliver_in .'. ' . "$rest_name, $rest_www. Auto SMS; please don't reply";
                $email_subject = ("Delivery $deliver_in accepted");
            }

            $answer_to_restaurant = 'ACCEPTED';
        } else {
            $email_subject=("ORDER REJECTED!!!");
            $why_rejected=strtolower(str_replace('_', ' ' , $why_rejected));
            $_email_content ="Unfortunately we can't fulfil your order at this moment. Reason: $why_rejected. If you have paid by card your payment will be refunded within one day. $rest_name";
            $answer_to_restaurant='REJECTED';
        }

        $order->restaurantCallbacks()
            ->create([
                'restaurant_answer' => $answer_to_restaurant,
                'deliver_in' => $deliver_in,
                'why_rejected' => $why_rejected,
            ]);

        // SEND SMS TO THE CUSTOMER
        if(env('SEND_SMS_TO_CUSTOMER', true) === true) {
            $this->sendSmsToCustomer($order, $email_subject, $_email_content);
        }

        // SEND SMS TO THE CUSTOMER SPARE
        if(env('SEND_SMS_TO_CUSTOMER_ALERT', true) === true) {
            $this->sendSmsToCustomerSmsAlert($order, $email_subject, $_email_content);
        }

        // SENDING EMAIL
        if(env('SEND_EMAIL_TO_CUSTOMER', true) === true) {
            $this->sendEmailToCustomer($order, $email_subject, $_email_content);
        }

        return response($answer_to_restaurant);
    }

    /**
     * @param Order $order
     * @param $email_subject
     * @param $_email_content
     * @return false|void
     */
    protected function sendSmsToCustomer(Order $order, $email_subject, $_email_content)
    {
        $client = $order->client;

        if (empty($client->phone)) {
            return;
        }

        return SmsService::sendSms($client->phone, htmlspecialchars_decode(($_email_content)));
    }

    protected function sendSmsToCustomerSmsAlert(Order $order, $email_subject, $_email_content) {
        $client = $order->client;

        return SmsService::sendSmsAlert($client->phone, htmlspecialchars_decode(($_email_content)));


    }

    /**
     * @param Order $order
     * @param $email_subject
     * @param $_email_content
     */
    protected function sendEmailToCustomer(Order $order, $email_subject, $_email_content)
    {
        if (empty(config('mail.vendor_email'))) {
            return;
        }

        Mail::to(config('mail.vendor_email'))
            ->send(new RestaurantCallbackMail($order, $email_subject, $_email_content));
    }
}