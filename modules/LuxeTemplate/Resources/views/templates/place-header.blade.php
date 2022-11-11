
<!-- place-header -->
<section class='section section-place-header grayscale-05'>
    <div class='packer h-100 d-flex flex-column justify-content-end'>
        <!--- Languaages -->
        @if (isset($showGoogleTranslate)&&$showGoogleTranslate&&!$showLanguagesSelector)
        <div class="select-lang">
        <!-- NEED TO ADD COMPATIBILITY WITH GOOGLE TRANSLATE BUTTONS -->
            @yield('addiitional_button_1')
        </div>
        @endif
        @if ($showLanguagesSelector)
        <div class="select-lang">
            <div class='dropdown'>
                <a class='dropdown-toggle' href='javascript:;'>{{ $currentLanguage }}</a>
                <div class='dropdown-menu'>
                    <div class='dropdown-menu-title'>{{ __('Select Language') }}</div>
                    @foreach ($restorant->localmenus()->get() as $language)
                        @if ($language->language!=config('app.locale'))
                            <a href='?lang={{ $language->language }}'>{{$language->languageName}}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <!-- End Languages -->
        <div class='package d-flex justify-content-between align-items-end hero-header'>
            <div class='text-left text-center-sm header-align'>
                <picture class='avatar'><img loading="lazy" src='{{ $restorant->icon }}' /></picture>
                <div class='info '>
                    <h1 class="text-white">{{ $restorant->name }}</h1>
                    @php
                        $cityId = $restorant->city_id;
                        $city = DB::table('cities')->select('name')->where(['id' => $cityId])->value('name');
                    @endphp
                    <p class="opacity-9 text-white title_small mb-0">{{ $restorant->description }}</p>
                    <p class="text-white mt-0">
                        @if ($city != ''){{ $city }} –@endif <a href="https://maps.google.com/maps?q={{ $restorant->address }}" class="text-white header-link" target="_blank" rel="noopener noreferrer">{{ __('Get Directions') }}</a>
                    </p>
                    @if(config('app.isft'))
                        @if(count($restorant->ratings))
                    <div class="ratings ">
                        <span class="d-flex font-medium text-white"><svg width="16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0.552342 -26.2649 14.6453 14.0149"><path d="M7.08201-25.7727l-1.77734 3.60937 -3.99218.601561c-.364582.0364581-.601561.227864-.710936.574217 -.109375.346353-.0364581.647134.218749.902342l2.89843 2.8164 -.683592 3.99218c-.0546874.346353.0638018.628905.355468.847654 .291666.218749.592447.236979.902342.0546874l3.58202-1.85937 3.58202 1.85937c.309895.164062.610675.141276.902342-.0683592 .291666-.209635.410155-.487629.355468-.833982l-.683592-3.99218 2.89843-2.8164c.255208-.255208.328124-.555988.218749-.902342 -.109375-.346353-.346353-.537759-.710936-.574217l-3.99218-.601561 -1.77734-3.60937c-.164062-.328124-.428385-.492186-.792967-.492186 -.364582 0-.628905.164062-.792967.492186Z" fill="#fbb851"></path></svg>&nbsp;<strong>{{ number_format($restorant->averageRating, 1, '.', ',') }} <span class="small">/ 5 ({{ count($restorant->ratings) }})</strong></span></span>
                    </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="header-buttons">                
                <!-- Buttons -->
                @isset($restorant)
                    @if(config('app.isqrsaas'))
                        @if(config('settings.enable_guest_log'))
                            <a href="{{ route('register.visit',['restaurant_id'=>$restorant->id])}}" class="d-flex btn_hero"> <svg width="16" fill="#444" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 2.01H6c-1.21 0-3 .79-3 3v3 6 3 2c0 2.2 1.79 3 3 3h15v-2H6.01c-.47-.02-1.02-.2-1.02-1 0-.11 0-.2.02-.28 .11-.58.58-.72.98-.73h13.989c.01 0 .03-.01.04-.01h.95V17v-2.01V4c0-1.11-.9-2-2-2Zm0 14H5v-2 -6 -3c0-.806.55-.99 1-1h7v7l2-1 2 1v-7h2V15v1.01Z"/></svg>&nbsp;{{ __('Register visit') }}</a>
                        @endif
                        @if(!config('settings.is_whatsapp_ordering_mode') && !$restorant->getConfig('disable_callwaiter', 0) && strlen(config('broadcasting.connections.pusher.app_id')) > 2 && strlen(config('broadcasting.connections.pusher.key')) > 2 && strlen(config('broadcasting.connections.pusher.secret')) > 2)
                            <a data-toggle="modal" data-target="#modal-form" href='javascript:;' class='d-flex btn_hero'><svg width="16" fill="#444" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21 15c0-4.625-3.51-8.45-8-8.95V3.99h-2v2.05c-4.493.5-8 4.31-8 8.941v2h18v-2ZM5 15c0-3.859 3.141-7 7-7s7 3.141 7 7H5Zm-3 3h20v2H2Z"/></svg>&nbsp;{{ __('Call Waiter') }}</a> 
                        @endif
                        @if(isset($hasGuestOrders) && $hasGuestOrders)
                            <a href="{{ route('guest.orders') }}" class='d-flex btn_hero'><svg width="16" fill="#444" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M21 5c0-1.11-.9-2-2-2H5c-1.11 0-2 .89-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5ZM5 19V5h14l0 14H4.99Z"/><path d="M7 7h1.99v2h-2Zm4 0h6v2h-6Zm-4 4h1.99v2h-2Zm4 0h6v2h-6Zm-4 4h1.99v2h-2Zm4 0h6v2h-6Z"/></g></svg>&nbsp;{{ __('My Orders') }}</a>
                        @endif
                    @endif                    
                @endisset
                <!--- End buttons -->
            </div>
        </div>
    </div>
    <picture data-background=true >
        <source  srcset="{{ $restorant->coverm }}" media="(min-width: 569px)" />
        <img class="grayscale-05" loading="lazy" src='{{ $restorant->coverm }}' />        
    </picture>
</section>
