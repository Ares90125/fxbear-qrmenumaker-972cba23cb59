@extends('layouts.front-luxe', ['class' => ''])
@section('content')
<section class="relative hero-background">
  <picture data-background=true >
      <div class="opacity-mask"></div>
      <source  srcset="{{ $restorant->coverm }}" media="(min-width: 569px)" />
      <img src='{{ $restorant->coverm }}' />        
  </picture>
  <div class="d-flex align-items-center justify-content-center hero-title">
  <div class="hero-container text-center">
  <h5 class="mb-1">{{ $restorant->name }}</h5>
  <h1 class="mb-4">{{ __('Checkout') }}</h1>
  <div class="inline-links justify-content-center align-items-center">
    <!-- @include('cart/luxe/herobuttons') -->
  </div>
  </div>
  </div>
</section>
<section class="section section-place-content py-5">
  <div class="container">
    <x:notify-messages />
      <form id="order-form" role="form" method="post" action="{{route('order.store')}}" autocomplete="off" enctype="multipart/form-data">
        @csrf
      <div class="row justify-content-center">
        <!-- Left part -->
          <div class="col-md-7 mb-4">
            <div class="card card-checkout">
              @if(!config('settings.social_mode'))
                @if (config('app.isft')&&count($timeSlots)>0)
                  <!-- FOOD TIGER -->
                  @include('cart.luxe.product.foodtiger')
                @elseif(config('app.isag')&&count($timeSlots)>0))
                  <!-- Agris Mode -->
                  @include('cart.luxe.product.agris')
                @elseif(config('app.isqrsaas')&&count($timeSlots)>0)
                  <!-- QR Saas Mode -->
                  @include('cart.luxe.product.qrsaas')
                @endif
                <hr class="dashed">
                @if (count($timeSlots)>0)
                  <!-- Payment Methods-->
                  <div class="row">
                    <div class="col-12 col-md-3">
                      <h5 class="text-muted">03</h5>
                      <h4 class="uppercase">{{ __('Payment Method') }}</h4>
                    </div>
                    <div class="col-12 col-md-9">
                      @include('cart.luxe.paymentmethod')
                    </div>
                  </div>
                @endif
              @else
                <!-- Social MODE -->
                @if(count($timeSlots)>0)
                  @include('cart.luxe.product.social')
                @endif
              @endif
          </div><!-- end card -->
        </div>
        <!-- Right Part -->
        <div class="col-md-5">
          @if (count($timeSlots)>0)
              <!-- Payment -->
              @include('cart.luxe.payment')
          @else
              <!-- Closed restaurant -->
              @include('cart.luxe.closed')
          @endif
        </div>
          <div class="my-3 text-center">
            <h6 class="text-center text-muted"><small>{{ __('Powered by') }} <a href="/" target="_blank" rel="noopener noreferrer">{{ config('global.site_name') }}</a> – &copy; {{ date('Y') }}</small></h6>
          </div>
      </div><!-- end row -->
    </div><!-- end container -->
    @include('cart.luxe.modals')
  </section>
@endsection
@section('js')

  <script async defer src= "https://maps.googleapis.com/maps/api/js?key=<?php echo config('settings.google_maps_api_key'); ?>&callback=initAddressMap"></script>
  <!-- Stripe -->
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    "use strict";
    var RESTORANT = <?php echo json_encode($restorant) ?>;
    var STRIPE_KEY="{{ config('settings.stripe_key') }}";
    var ENABLE_STRIPE="{{ config('settings.enable_stripe') }}";
    var SYSTEM_IS_QR="{{ config('app.isqrexact') }}";
    var SYSTEM_IS_WP="{{ config('app.iswp') }}";
    var initialOrderType = 'delivery';
    if(RESTORANT.can_deliver == 1 && RESTORANT.can_pickup == 0){
        initialOrderType = 'delivery';
    }else if(RESTORANT.can_deliver == 0 && RESTORANT.can_pickup == 1){
        initialOrderType = 'pickup';
    }
  </script>
  <script src="{{ asset('custom') }}/js/checkout.js"></script>
@endsection


