<div class="card-body">
    <div class="row mb-4">
        <div class="col-6">
            <h6 class="heading-small text-muted mb-2">{{ __('Payment Method') }}</h6>
            <h5>{{ __(strtoupper($order->payment_method)) }}</h5>
        </div>
        <div class="col-6">
            <h6 class="heading-small text-muted mb-2">{{ __('Payment Status') }}</h6>
            <h5><span class="
            @if ($order->payment_status == 'unpaid')
                text-danger
            @else
                text-success
            @endif
            ">
            {{ __(ucfirst($order->payment_status)) }}
            </span>
            </h5>
        </div>
    </div>
        @if(config('app.isft') || config('app.iswp'))
            <div class="row mb-4">
                <div class="col-6">
                    <h6 class="heading-small text-muted mb-2">{{ __('Delivery Method') }}</h6>
                    <h5>{{ $order->getExpeditionType() }}</h5>
                </div>
                <div class="col-6">
                    <h6 class="heading-small text-muted mb-2">{{ __('Time slot') }}</h6>
                    <h5>@include('orders.partials.time', ['time'=>$order->time_formated])</h5>
                </div>
            </div>
            @else
            <div class="row mb-4">
                <div class="col-6">
                    <h6 class="heading-small text-muted mb-2">{{ __('Dine Method') }}</h6>
                    <h5>{{ $order->getExpeditionType() }}</h5>
                </div>
                @if ($order->delivery_method!=3)
                <div class="col-6">
                    <h6 class="heading-small text-muted mb-2">{{ __('Time slot') }}</h6>
                    <h5>@include('orders.partials.time', ['time'=>$order->time_formated])</h5>
                </div>
                @endif
            </div>
        @endif
</div>