<!-- QRSAAS -->
<!-- DINE IN OR TAKEAWAY -->
@if (config('settings.enable_pickup'))
  <div class="row">
    <div class="col-12 col-md-3">
      <h5 class="text-muted">01</h5>
      <h4 class="uppercase">{{ __('Service Type') }}</h4>
    </div>
    <div class="col-12 col-md-9">
      <!-- We have POS in QR -->
      @if (in_array("poscloud", config('global.modules',[])) || in_array("deliveryqr", config('global.modules',[])) )
        @include('cart.luxe.localorder.dineiintakeawaydeliver')
      @else
        @include('cart.luxe.localorder.dineiintakeaway')
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
      <!-- Name -->
      <div id="clientBox">
      @include('cart.luxe.client')
      </div>
      <!-- Local Order Phone -->
      @include('cart.luxe.localorder.phone')

      <!-- Email -->
       @include('partials.email')

      <!-- LOCAL ORDERING -->
      @include('cart.luxe.localorder.table')
      <!-- Takeaway time slot -->
      <div class="takeaway_picker" style="display: none">
          @include('cart.luxe.time')
      </div>
      <!-- Delivery adress -->
      @if (in_array("poscloud", config('global.modules',[])) || in_array("deliveryqr", config('global.modules',[])) )
        <div class="qraddressBox" style="display: none">
        @include('cart.luxe.newaddress')
        </div>
      @endif
      <!-- Custom Fields -->
      @include('cart.luxe.customfields')
      <!-- Comment -->
      @include('cart.luxe.comment')
    </div>
  </div>
@else
<!-- Simple QR -->
  <div class="row">
    <div class="col-12 col-md-3">
      <h5 class="text-muted">01</h5>
      <h4 class="uppercase">{{ __('Order Details') }}</h4>
    </div>
    <div class="col-12 col-md-9">
      <!-- LOCAL ORDERING -->
      @include('cart.luxe.localorder.table')

      <!-- Custom Fields -->
      @include('cart.luxe.customfields')

      <!-- Comment -->
      @include('cart.luxe.comment')
    </div>
  </div>
@endif
