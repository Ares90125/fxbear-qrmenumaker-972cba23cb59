<div class="card-body">
    <div id="status-history" class="flex-column">    
        <div class="row w-100 mb-3">
            <div class="col">
                <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('Placed on') }}</h6>
                <h6 class="m-0">{{ $order->created_at->locale(Config::get('app.locale'))->isoFormat('LLL') }}</h6>
            </div>        
            <div class="col">
                <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('Service Type') }}</h6>
                <h5>{{ $order->getExpeditionType() }}</h5>
            </div>        
            <div class="col">
                <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('Payment Method') }}</h6>
                <h5>{{ __(strtoupper($order->payment_method)) }}</h5>
            </div>        
            <div class="col">
                <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('Payment Status') }}</h6>
                <div class="d-flex align-items-center">
                <h6 class="m-0 
                    @if ($order->payment_status == 'unpaid')
                        text-danger
                    @else
                        text-success
                    @endif
                    ">
                    {{ __(ucfirst($order->payment_status)) }}
                </h6>
                &nbsp;&nbsp;
                @if ($order->payment_status=="unpaid"&&strlen($order->payment_link)>5)
                    <button onclick="location.href='{{$order->payment_link}}'" class="btn btn-sm btn-success">{{ __('Pay now') }}</button>
                @endif
                </div>
            </div>
        </div>
        <div class="row w-100 mb-3">
            @if ($order->table)
            <div class="col-12 col-md-6">
                <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('Table') }}</h6>
                <h5>{{ $order->table->name }}  @if ($order->table->restoarea) / {{ $order->table->restoarea->name }}@endif</h5>
            </div>
            @endif
            @if ($order->driver)
                @hasrole('admin|owner|staff')
                    <div class="col-12 col-md-6">
                        <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('Driver') }}</h6>
                        <h5><a href="/drivers/{{ $order->driver->id}}/edit">{{ $order->driver->name }}</a></h5>
                    </div>
                @endhasanyrole
            @endif
            @if(!empty($order->time_to_prepare))        
            <div class="col-12 col-md-6">
                <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('Time to prepare') }}</h6>
                <h5>{{ $order->time_to_prepare ." " .__('minutes')}}</h5>
            </div>
            @endif
        </div>
        @if(isset($custom_data)&&count($custom_data)>0)
        <div class="row w-100 mb-3">
            @foreach ($custom_data as $keyCutom => $itemValue)            
                <div class="col">
                    <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __("custom.".$keyCutom) }}</h6>
                    <h5>{{ $itemValue }}</h5>
                </div>
            @endforeach
        </div>
        @endif
        
        @if(!empty($order->whatsapp_address))
        <div class="row w-100 mb-3">
            <div class="col-12">
                <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('Delivery Address') }}</h6>
                <h5>{{ $order->whatsapp_address }}</h5>
            </div>
        </div>
        @endif
        @if (config('app.isft')&&$order->client)
        <div class="row w-100 mb-3">
            <div class="col-12">
                <h6 class="order-item-title text-muted font-weight-light mb-0">{{ __('My Address') }}</h6>
                <div class="d-flex align-items-center">
                <h5>{{ $order->address?$order->address->address:"" }} </h5>&nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#modal-order-my-address"  class="btn btn-link">{{ __('Show details') }}</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Add Address -->
<div class="modal fade bd-example-moda" id="modal-order-my-address" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered " role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="mb-0">{{ __('My Address') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <h3>{{ $order->client?$order->client->name:"" }}</h3>
                <h4>{{ $order->client?$order->client->email:"" }}</h4>
                <h4>{{ $order->address?$order->address->address:"" }}</h4>

                @if(!empty($order->address->apartment))
                    <h4>{{ __("Apartment number") }}: {{ $order->address->apartment }}</h4>
                @endif
                @if(!empty($order->address->entry))
                    <h4>{{ __("Entry number") }}: {{ $order->address->entry }}</h4>
                @endif
                @if(!empty($order->address->floor))
                    <h4>{{ __("Floor") }}: {{ $order->address->floor }}</h4>
                @endif
                @if(!empty($order->address->intercom))
                    <h4>{{ __("Intercom") }}: {{ $order->address->intercom }}</h4>
                @endif
                @if($order->client&&!empty($order->client->phone))
                <br/>
                    <h4>{{ __('Contact')}}: {{ $order->client->phone }}</h4>
                @endif
            </div>            
        </div>
    </div>
</div>