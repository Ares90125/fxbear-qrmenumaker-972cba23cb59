
<div class="card-body">
     @if (config('app.isft')&&$order->client)
         <h6 class="heading-small text-muted mb-4">{{ __('Client Information') }}</h6>
         <div class="pl-lg-4">
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
         <hr class="my-4" />
     @endif 
 
    
     @if(!empty($order->whatsapp_address))
        <br/>
        <h4>{{ __('Address') }}: {{ $order->whatsapp_address }}</h4>
     @endif




     @if(isset($custom_data)&&count($custom_data)>0)
        <hr />
        <h3>{{ __(config('settings.label_on_custom_fields')) }}</h3>
        @foreach ($custom_data as $keyCutom => $itemValue)
            <h4>{{ __("custom.".$keyCutom) }}: {{ $itemValue }}</h4>
        @endforeach
     @endif

     
 
 
 </div>