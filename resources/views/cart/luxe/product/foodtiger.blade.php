<div class="row">
  <div class="col-12 col-md-3">
    <h5 class="text-muted">01</h5>
    <h4 class="uppercase">{{ __('Service Type') }}</h4>
  </div>
  <div class="col-12 col-md-9">
    @if($restorant->can_pickup == 1)
      @if($restorant->can_deliver == 1)
        @include('cart.luxe.delivery')
      @endif
    @endif
  </div>
</div>
<hr class="dashed">
<div class="row">
  <div class="col-12 col-md-3">
    <h5 class="text-muted">02</h5>
    <h4 class="uppercase">{{ __('Order Details') }}</h4>
  </div>
  <div class="col-12 col-md-9">
    <!-- Delivery time slot -->
    @include('cart.luxe.time')
    <!-- Delivery address -->
    @include('cart.luxe.address')
    <!-- Custom Fields -->
    @include('cart.luxe.customfields')
    <!-- Comment -->
    @include('cart.luxe.comment')
  </div>
</div>
