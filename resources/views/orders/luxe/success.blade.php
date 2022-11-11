@extends('layouts.empty-luxe')
@section('page_title')
    {{__('Success Payment')}}
@endsection
@section('content')
<section class="section-place-content">
<div class="container bg-secondary">
    <div class="row h-100vh align-items-center justify-content-center">
        <div class="card border-0">
            <div class="card-body  p-4 text-center">
                <div class="justify-content-center text-center">
                    <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_ya4ycrti.json"  background="transparent"  speed="1"  style=" height: 200px;"    autoplay></lottie-player>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h3 class="mb-2">{{ __("Your order has been placed!") }}</h3>
                        <p class="text-muted">{{ __("Thanks for choose") }} {{ $order->restorant->name }}<br>{{ __('You can track you order number')}} <a href="/guest-orders" class="btn-link"><strong>#{{ $order->id }}</strong></a></p>
                        <div class="mt-5 row">
                            <div class="col-12 @if ($showWhatsApp) col-md-6 @endif">
                                @if (config('settings.wildcard_domain_ready'))
                                    <a href="{{ $order->restorant->getLinkAttribute() }}" class="button full-button btn btn-secondary text-left justify-content-center">
                                     <span class="d-flex align-items-center"><svg width="28" class="mr-2" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><path fill="#FFF" fill-rule="evenodd" d="M6.821 2.87l-3.09 3.04 9.19.04v0c.59 0 1.06.48 1.06 1.07 -.01 0-.01 0-.01 0v0h0c-.01.59-.49 1.06-1.08 1.06 -.01-.01-.01-.01-.01-.01l-9.2-.05 3.04 3.07h0c.41.41.41 1.09-.01 1.51 -.01 0-.01 0-.01 0v0 0c-.43.41-1.1.41-1.52-.01l-5-5.049H.18c-.35-.35-.34-.91.01-1.25l5.053-5v0c.42-.42 1.09-.42 1.51 0v0 0c.41.42.41 1.09-.01 1.51 -.01 0-.01 0-.01 0Z"/></svg>{{ __('Go back to Menu')}}</span>
                                    </a>
                                @else
                                    <a href="{{ route('vendor',$order->restorant->subdomain) }}" class="button full-button btn btn-secondary text-left justify-content-center">
                                     <span class="d-flex align-items-center"><svg width="28" class="mr-2" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><path fill="#FFF" fill-rule="evenodd" d="M6.821 2.87l-3.09 3.04 9.19.04v0c.59 0 1.06.48 1.06 1.07 -.01 0-.01 0-.01 0v0h0c-.01.59-.49 1.06-1.08 1.06 -.01-.01-.01-.01-.01-.01l-9.2-.05 3.04 3.07h0c.41.41.41 1.09-.01 1.51 -.01 0-.01 0-.01 0v0 0c-.43.41-1.1.41-1.52-.01l-5-5.049H.18c-.35-.35-.34-.91.01-1.25l5.053-5v0c.42-.42 1.09-.42 1.51 0v0 0c.41.42.41 1.09-.01 1.51 -.01 0-.01 0-.01 0Z"/></svg>{{ __('Go back to Menu')}}</span>
                                    </a>
                                @endif
                            </div>
                            @if ($showWhatsApp)
                            <div class="col-12 col-md-6">
                                <!-- WHATS APP Buttton -->
                                <a target="_blank" href="?order={{$_GET['order']}}&whatsapp=yes"  class="button full-button btn-success text-left justify-content-center paymentbutton">
                                    <span class="d-flex align-items-center"><svg width="28" fill="#FFF" class="mr-2" viewBox="0 -23.6249 12.25 12.25" xmlns="http://www.w3.org/2000/svg"><path d="M10.41-21.85c-1.15-1.15-2.68-1.79-4.3-1.79 -3.35 0-6.08 2.72-6.08 6.07 0 1.06.27 2.11.8 3.03l-.87 3.14 3.21-.85c.88.48 1.88.73 2.9.73h0c3.34 0 6.12-2.73 6.12-6.08 0-1.63-.69-3.15-1.84-4.3Zm-4.3 9.34c-.91 0-1.8-.25-2.58-.71l-.19-.11 -1.91.5 .5-1.87 -.13-.2c-.51-.81-.78-1.74-.78-2.69 0-2.79 2.26-5.05 5.04-5.05 1.34 0 2.61.52 3.56 1.47 .95.95 1.53 2.22 1.53 3.56 0 2.78-2.33 5.04-5.11 5.04Zm2.76-3.78c-.16-.08-.9-.45-1.04-.5 -.14-.06-.25-.08-.35.07 -.11.15-.4.49-.49.59 -.09.1-.18.11-.33.03 -.9-.45-1.48-.8-2.07-1.81 -.16-.27.15-.25.44-.83 .04-.11.02-.19-.02-.27 -.04-.08-.35-.83-.47-1.13 -.13-.3-.25-.26-.35-.26 -.09-.01-.19-.01-.29-.01 -.11 0-.27.03-.41.18 -.14.15-.54.51-.54 1.26 0 .74.54 1.46.61 1.56 .07.1 1.06 1.63 2.59 2.29 .96.41 1.33.45 1.82.38 .29-.05.89-.37 1.02-.73 .12-.36.12-.66.08-.73 -.04-.07-.14-.11-.29-.19Z"/></svg> {{ __('Send via WhatsApp')}}</span>
                                </a>
                                <!-- End WhattsApp Button -->
                                <!-- Whats App  Redirect -->
                                @isset($whatsappurl)
                                <script type="text/javascript">

                                        var redirectDone=false;
                                        if(!redirectDone){
                                            redirectDone=true;

                                            var redirectWindow = window.open('{{ $whatsappurl }}', '_blank');
                                            redirectWindow.location;
                                        }
                                    </script>
                                @endisset
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection





