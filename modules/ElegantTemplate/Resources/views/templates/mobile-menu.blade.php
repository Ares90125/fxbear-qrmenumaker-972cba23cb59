  <!-- mobile-menu -->
  <section id='mobile-menu'>
      <a class='close-mobile-menu' href='javascript:;'>
          <i class="las la-times"></i>
      </a>
      <div class='content'>
          
        

          <!-- <div class='login'>
              <a class='button full-button' href='javascript:;'>Login/Sign up</a>
          </div> -->
          <nav>
            <!-- Buttons -->
            @isset($restorant)
                @if(config('app.isqrsaas'))
                    @if(!config('settings.is_whatsapp_ordering_mode') && !$restorant->getConfig('disable_callwaiter', 0) && strlen(config('broadcasting.connections.pusher.app_id')) > 2 && strlen(config('broadcasting.connections.pusher.key')) > 2 && strlen(config('broadcasting.connections.pusher.secret')) > 2)
                        <div class='item'><a data-toggle="modal" data-target="#modal-form" href='javascript:;' class='toggle-pre-wrapper'>{{ __('Call Waiter') }}</a></div>
                    @endif
                    @if(config('settings.enable_guest_log'))
                        <div class='item'><a href='{{ route('register.visit',['restaurant_id'=>$restorant->id])}}' class='toggle-pre-wrapper'>{{ __('Register visit') }}</a></div>
                    @endif
                    @if(isset($hasGuestOrders)&&$hasGuestOrders)
                        <div class='item'><a href='{{ route('guest.orders')}}' class='featured'>{{ __('My Orders') }}</a></div>
                    @endif
                @else
                    @if(auth()->user()&&auth()->user()->hasRole('client'))
                        <div class='item'><a href="/orders" class="toggle-pre-wrapper">{{ __('My Orders') }}</a></div>
                        <div class='item'><a href="/addresses" class="toggle-pre-wrapper">{{ __('My Addresses') }}</a></div>
                    @endif
                @endif

            @endisset
            <!--- End buttons -->

            <!--- Languaages -->
            @if (isset($showGoogleTranslate)&&$showGoogleTranslate&&!$showLanguagesSelector)
                @include('googletranslate::buttons')
            @endif
            @if ($showLanguagesSelector)
                <div class='item has-submenu'>
                    <a href='javascript:;'>{{ $currentLanguage }}<span class='toggle-submenu'><i class="las la-angle-down"></i></span></a>
                    <div class='submenu'>
                        @foreach ($restorant->localmenus()->get() as $language)
                                @if ($language->language!=config('app.locale'))
                                    <div class='item'><a href='?lang={{ $language->language }}'>{{$language->languageName}}</a></div>
                                @endif
                        @endforeach
                    </div>
                </div>
            @endif
            <!-- End Languages -->
          </nav>

          
          @include('elegant-template::templates.side_cart',['id'=>'cartListMobile','idtotal'=>"totalPricesMobile"])
      </div>
  </section>