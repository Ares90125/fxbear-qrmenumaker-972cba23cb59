
@extends('layouts.empty-luxe')
@section('page_title')
    {{__('Guest Orders')}}
@endsection
@section('content')
  <section id='header' class='header section-header'>
      <div class='packer'>
          <div class='package'>
              <div class='left'>
                <a href='{{ $backUrl }}'  type="button" class='d-flex align-items-center btn btn-link back-button'><svg width="12" fill="currentColor" viewBox="0 -23.1328 12.25 11.9218" xmlns="http://www.w3.org/2000/svg"><path d="M7.05-12.01c.12-.13.18-.29.17-.47 -.01-.19-.08-.34-.21-.47L3.72-16.1h7.84c.18 0 .33-.07.46-.2 .12-.13.19-.29.19-.47v-.88c0-.19-.07-.34-.2-.47 -.13-.13-.29-.2-.47-.2H3.69l3.28-3.15c.12-.13.19-.29.2-.47 0-.19-.06-.34-.18-.47l-.63-.61c-.13-.13-.29-.2-.47-.2 -.19 0-.34.06-.47.19l-5.31 5.3c-.13.12-.2.28-.2.46s.06.33.19.46l5.3 5.3c.12.12.28.19.46.19s.33-.07.46-.2Z"/></svg>&nbsp;&nbsp;{{ __('Back')}}</a>
              </div>
              <div class='right'>
                <a  href="{{ url()->current() }}" type="button" class='d-flex align-items-center btn btn-link refresh-button'><svg  width="18" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" fill-rule="evenodd" d="M4 2c.55 0 1 .44 1 1v2.1c1.27-1.3 3.04-2.11 5-2.11 3.04 0 5.64 1.94 6.6 4.66 .18.52-.09 1.09-.61 1.27 -.53.18-1.1-.09-1.28-.61 -.69-1.95-2.55-3.34-4.72-3.34 -1.64 0-3.09.78-4.01 2h3c.55 0 1 .44 1 1 0 .55-.45 1-1 1h-5c-.56 0-1-.45-1-1v-5c0-.56.44-1 1-1Zm0 9.05c.52-.19 1.09.08 1.27.6 .68 1.94 2.54 3.33 4.71 3.33 1.63 0 3.08-.79 4-2h-3.01c-.56 0-1-.45-1-1 0-.56.44-1 1-1h5c.26 0 .51.1.7.29 .18.18.29.44.29.7v5c0 .55-.45 1-1 1 -.56 0-1-.45-1-1v-2.11c-1.28 1.29-3.05 2.1-5 2.1 -3.05 0-5.65-1.95-6.61-4.67 -.19-.53.08-1.1.6-1.28Z"/></svg>&nbsp;&nbsp;{{ __('Refresh')}}</a>
                  
              </div>
          </div>
      </div>
  </section>
<section class="section-place-content">
    <div class="container-sm bg-secondary">  
        @include('partials.flash')
        <div class="row justify-content-center">
            <div class="col-12">
                @foreach ($orders as $order)         
                <div class="card relative bg-secondary p-5">
                    <div class="card-header border-bottom d-flex flex-column w-100 bg-white mb-4">
                        @include('orders.luxe.restaurant')        
                        <h6 class="text-muted mb-0">{{ __('Dear Customer')}}</h6>
                        <h2 class="mb-0">{{ __('Your order')}} <span class="text-highlighted">#{{ $order->id }}</span> {{ __('has been')}}
                        <span class="text-highlighted">
                        @foreach($order->stakeholders as $key=>$stakeholder)
                        @if ($loop->first)
                            {{ __($statuses[$stakeholder->pivot->status_id]) }}!
                        @endif
                        @endforeach
                        </span>
                        </h2>
                        <div class="order-item-date mb-3 d-flex"><svg width="14" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M16 2a14 14 0 1 0 0 28 14 14 0 1 0 0-28Z"/><path d="M16 8v8l4 4"/></g></svg><small>&nbsp;{{ $stakeholder->pivot->created_at->locale(Config::get('app.locale'))->isoFormat('LT') }}</small></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @include('orders.luxe.orderstatus')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <!-- @include('orders.luxe.paymentstatus') -->
                        </div>
                    </div>
                    <?php 
                        $currency=config('settings.cashier_currency');
                        $convert=config('settings.do_convertion');
                    ?>
                    @include('orders.luxe.ordersummary')
                </div>
                <br />
                @endforeach
            </div>
        </div>
        
        


    </div>
</section>
@endsection
