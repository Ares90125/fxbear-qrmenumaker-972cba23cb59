<?php

namespace Modules\Detrack\Listeners;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SubmitOnOrder
{
    public function handleOrderAcceptedByVendor($event){

        $order = $event->data['order'];
        $vendor = $order->restorant;
        $key = $vendor->getConfig('dertack_app_id', '');
        $enabled = $vendor->getConfig('detrack_enable', false);
        $openToMarket = $vendor->getConfig('detrack_public', true);


     
        if($enabled && strlen($key)>5 && $order->delivery_method . "" == "1"){
            //We have the key and detrack is enabled
            //Crete the endpoint
            $endpoint="https://app.detrack.com/api/v2/dn/jobs";

            $client = new \GuzzleHttp\Client();

            $data=[
                  'type' => 'Delivery',
                  'items_count' => $order->items->count(),
                  'primary_job_status' => 'dispatched',
                  'open_to_marketplace' => $openToMarket,
                  'marketplace_offer' => NULL,
                  'do_number' => 'DO '.$order->id,
                  'order_number' => '#'.$order->id,
                  'tracking_number' => 'T0'.$order->id,
                  'date' => date("Y-m-d"),
                  'start_date' => date("Y-m-d"),
                  'time_window' => $order->getTimeFormatedAttribute(),
                  'payment_mode' => $order->payment_method,
                  'payment_amount' => $order->order_price-$order->discount,
                  'total_price' => $order->delivery_price+$order->order_price-$order->discount,
                  'address' => $order->whatsapp_address,
                  'geocoded_lat' => NULL,
                  'geocoded_lng' => NULL,
                  'deliver_to_collect_from' => $order->getConfig('client_name'),
                  'last_name' => NULL,
                  'phone_number' => $order->getConfig('client_phone'),
                  'sender_phone_number' => NULL,
                  'fax_number' => NULL,
                  'instructions' => $order->getTimeFormatedAttribute()." ".$order->comment,
                  'note' => NULL,
                  'assign_to' => NULL,
                  'notify_email' => NULL,
                  'status' => 'dispatched',
                  'tracking_status' => 'Info received',
                  'job_age' => 1,
                  'job_release_time' => NULL,
                  'job_time' => NULL,
                  'job_received_date' => NULL,
                  'job_type' => NULL,
                  'job_sequence' => NULL,
                  'job_fee' => NULL,
                  'address_lat' => '',
                  'address_lng' => '',
                  'company_name' => NULL,
                  'address_1' => NULL,
                  'address_2' => NULL,
                  'address_3' => NULL,
                  'postal_code' => NULL,
                  'city' => NULL,
                  'state' => NULL,
                  'country' => NULL,
                  'billing_address' => NULL,
                  'webhook_url' => NULL,
                  'zone' => NULL,
                  'customer' => NULL,
                  'account_number' => NULL,
                  'job_owner' => NULL,
                  'invoice_number' => NULL,
                  'invoice_amount' => NULL,
                  'group_name' => NULL,
                  'vendor_name' => NULL,
                  'shipper_name' => NULL,
                  'source' => NULL,
                  'weight' => NULL,
                  'parcel_width' => NULL,
                  'parcel_length' => NULL,
                  'parcel_height' => NULL,
                  'cubic_meter' => NULL,
                  'boxes' => NULL,
                  'cartons' => NULL,
                  'pieces' => NULL,
                  'envelopes' => NULL,
                  'pallets' => NULL,
                  'bins' => NULL,
                  'trays' => NULL,
                  'bundles' => NULL,
                  'rolls' => NULL,
                  'number_of_shipping_labels' => NULL,
                  'attachment_url' => NULL,
                  'detrack_number' => NULL,
                  'reason' => NULL,
                  'last_reason' => NULL,
                  'received_by_sent_by' => NULL,
                  'carrier' => NULL,
                  'pod_lat' => '',
                  'pod_lng' => '',
                  'pod_address' => '',
                  'address_tracked_at' => NULL,
                  'arrived_lat' => NULL,
                  'arrived_lng' => NULL,
                  'arrived_address' => NULL,
                  'arrived_at' => NULL,
                  'texted_at' => NULL,
                  'called_at' => NULL,
                  'serial_number' => NULL,
                  'signed_at' => NULL,
                  'photo_1_at' => NULL,
                  'photo_2_at' => NULL,
                  'photo_3_at' => NULL,
                  'photo_4_at' => NULL,
                  'photo_5_at' => NULL,
                  'signature_file_url' => NULL,
                  'photo_1_file_url' => NULL,
                  'photo_2_file_url' => NULL,
                  'photo_3_file_url' => NULL,
                  'photo_4_file_url' => NULL,
                  'photo_5_file_url' => NULL,
                  'actual_weight' => NULL,
                  'temperature' => NULL,
                  'hold_time' => NULL,
                  'payment_collected' => NULL,
                  'auto_reschedule' => NULL,
                  'actual_crates' => NULL,
                  'actual_pallets' => NULL,
                  'actual_utilization' => NULL,
                  'goods_service_rating' => NULL,
                  'driver_rating' => NULL,
                  'customer_feedback' => NULL,
                  'eta_time' => NULL,
                  'live_eta' => NULL,
                  'depot' => NULL,
                  'depot_contact' => NULL,
                  'department' => NULL,
                  'sales_person' => NULL,
                  'identification_number' => NULL,
                  'bank_prefix' => NULL,
                  'run_number' => NULL,
                  'pick_up_from' => NULL,
                  'pick_up_time' => NULL,
                  'pick_up_lat' => NULL,
                  'pick_up_lng' => NULL,
                  'pick_up_address' => NULL,
                  'pick_up_address_1' => NULL,
                  'pick_up_address_2' => NULL,
                  'pick_up_address_3' => NULL,
                  'pick_up_city' => NULL,
                  'pick_up_state' => NULL,
                  'pick_up_country' => NULL,
                  'pick_up_postal_code' => NULL,
                  'pick_up_zone' => NULL,
                  'pick_up_assign_to' => NULL,
                  'pick_up_reason' => NULL,
                  'info_received_at' => NULL,
                  'pick_up_at' => NULL,
                  'scheduled_at' => NULL,
                  'at_warehouse_at' => NULL,
                  'out_for_delivery_at' => NULL,
                  'head_to_pick_up_at' => NULL,
                  'head_to_delivery_at' => NULL,
                  'cancelled_at' => NULL,
                  'pod_at' => NULL,
                  'pick_up_failed_count' => NULL,
                  'deliver_failed_count' => NULL,
                  'job_price' => NULL,
                  'insurance_price' => NULL,
                  'insurance_coverage' => false,
                  'payer_type' => NULL,
                  'remarks' => NULL,
                  'service_type' => NULL,
                  'warehouse_address' => NULL,
                  'destination_time_window' => NULL,
                  'door' => NULL,
                  'time_zone' => NULL,
                  'vehicle_type' => NULL,
                  'created_at' => NULL,
                  'items' => [],

                
            ];

            $items=[];
            foreach ($order->items as $keyi => $item) {
                array_push($items,
                [
                    'sku' =>$item->id,
                    'quantity' => $item->pivot->qty,
                    'comments' => $item->name,
                    'purchase_order_number' => NULL,
                    'batch_number' => NULL,
                    'expiry_date' => NULL,
                    'description' => NULL,
                    'unit_of_measure' => NULL,
                    'checked' => false,
                    'actual_quantity' => NULL,
                    'inbound_quantity' => NULL,
                    'unload_time_estimate' => NULL,
                    'unload_time_actual' => NULL,
                    'follow_up_quantity' => NULL,
                    'follow_up_reason' => NULL,
                    'rework_quantity' => NULL,
                    'rework_reason' => NULL,
                    'reject_quantity' => 0,
                    'reject_reason' => NULL,
                    'weight' => NULL,
                    'photo_url' => NULL
                
                ]);
            }

            $data['items']=$items;

            $payload = [
                'json' => ['data'=>$data],
            ];



            $options = [
                'headers' => [
                    'X-API-KEY' => $key,
                    'Content-Type'     => 'application/json',
                ],
                'body'    => json_encode(['data'=>$data])
            ];

            try {
                $response = $client->post($endpoint,$options);
            } catch (\Throwable $th) {
                //dd($payload);
                dd($th);
            }
           

            if ($response->getStatusCode() !== 200) {
                
                //return response()->json(['results'=>[]]);
            }
            $responseDecoded = json_decode($response->getBody(),true);
        }

        
    }


    public function subscribe($events)
    {
        
        $events->listen(
            'App\Events\OrderAcceptedByVendor',
            [SubmitOnOrder::class, 'handleOrderAcceptedByVendor']
        );
    }

}
