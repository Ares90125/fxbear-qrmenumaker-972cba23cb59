<div class="row">
  <div class="col-12 col-md-3">
    <h5 class="text-muted">01</h5>
    <h4 class="uppercase">{{ __('Service Type') }}</h4>
  </div>
  <div class="col-12 col-md-9">
    @include('cart.luxe.delivery')
  </div>
</div>
<hr class="dashed">
<div class="row">
  <div class="col-12 col-md-3">
    <h5 class="text-muted">02</h5>
    <h4 class="uppercase">{{ __('Order Details') }}</h4>
  </div>
  <div class="col-12 col-md-9">
    <!-- Name -->
    @include('cart.luxe.newclient')
    <!-- Local Order Phone -->
    @include('cart.luxe.localorder.phone')
    <!-- Time slot -->
    @include('cart.luxe.time')
    <!-- Delivery adress -->
    @include('cart.luxe.newaddress')
    <!-- Custom Fields -->
    @include('cart.luxe.customfields')
    <!-- Comment -->
    @include('cart.luxe.comment')
  </div>
</div>