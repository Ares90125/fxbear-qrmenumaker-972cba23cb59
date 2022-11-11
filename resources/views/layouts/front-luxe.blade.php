<!--
=========================================================
* Luxe Checkout Theme- v0.2
=========================================================
Author: Aleks Iralda
Author Site: https://www.twitter.com/aleksiralda
Theme: Luxe Theme
Theme site: https://aleksiralda.github.io/luxe-theme/
Support: https://www.reddit.com/user/aleksiralda

=========================================================
 -->
<!DOCTYPE html>
<html lang="<?php echo  App::getLocale() ?>">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $restorant->description }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $restorant->name }}</title>
    
    <meta property="og:image" content="{{ $restorant->logom }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="590">
    <meta property="og:image:height" content="400">
    
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @yield('extrameta')
    @if (\Akaunting\Module\Facade::has('googleanalytics'))
        @include('googleanalytics::index') 
    @endif

    @include('googletagmanager::head')
    @yield('head')
    @laravelPWA
    @notifyCss

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap"> 
    <link rel="stylesheet" href="{{ asset('custom') }}/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('custom') }}/css/custom.css">
    <link rel="stylesheet" href="{{ asset('luxe') }}/bootstrap_customized.min.css">
    <link rel="stylesheet" href="{{ asset('luxe') }}/main.css">
    
    @include('layouts.rtl')
  
    <!-- Custom CSS defined by admin -->
    @if(\Request::route()->getName() != "vendor")
    <link type="text/css" href="{{ asset('byadmin') }}/front.css" rel="stylesheet">
    @else
    <link type="text/css" href="{{ asset('byadmin') }}/frontmenu.css" rel="stylesheet">
    @endif
   <script src="{{ asset('vendor') }}/vue/vue.js"></script>
   <script src="{{ asset('vendor') }}/axios/axios.min.js"></script>

</head>

<body class="checkout">
    @include('googletagmanager::body')
    @auth()
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

    <!-- Navbar -->
    @include('layouts.luxe.top')


    <!-- End Navbar -->
    <div class="wrapper">
        @yield('content')
        @include('layouts.luxe.cartSideMenu')
        @if(request()->get('location') )
            @include('layouts.luxe.modallocation')
        @endif
    </div>

    <script src="{{ asset('luxe') }}/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>
    <script src="{{ asset('vendor') }}/select2/select2.min.js"></script>
    <script src="{{ asset('luxe') }}/select2.js"></script>

    <script src="{{ asset('luxe') }}/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('luxe') }}/cartFunctions.js"></script>
    <script src="{{ asset('custom') }}/js/cartSideMenu.js"></script>
    <script src="{{ asset('custom') }}/js/notify.min.js"></script>

    <!-- Add to Cart   -->
    <script>
        var LOCALE="<?php echo  App::getLocale() ?>";
        var CASHIER_CURRENCY = "<?php echo  config('settings.cashier_currency') ?>";
        var USER_ID = '{{  auth()->user()&&auth()->user()?auth()->user()->id:"" }}';
        var PUSHER_APP_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
        var PUSHER_APP_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
    </script>

    <script src="{{ asset('luxe') }}/js.js"></script>


     <!-- Google Map -->
     <script async defer src="https://maps.googleapis.com/maps/api/js?libraries=geometry,drawing&key=<?php echo config('settings.google_maps_api_key'); ?>&libraries=places&callback=js.initializeGoogle"></script>

    @if(strlen( config('broadcasting.connections.pusher.app_id'))>2)
        <!-- Pusher -->
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script src="{{ asset('custom') }}/js/pusher.js"></script>
    @endif
    @yield('js')

    @notifyJs
    @if(\Request::route()->getName() != "vendor")
        <?php echo file_get_contents(base_path('public/byadmin/front.js')) ?>
    @else
        <?php echo file_get_contents(base_path('public/byadmin/frontmenu.js')) ?>
    @endif

    <script>
        window.translations = {!! Cache::get('translations'.App::getLocale()) !!};
    </script>

    <script>
        //VUE COMPLETE ORDER TOTAL PRICE
    total = new Vue({
        el: '#totalSubmit',
        data: {
            totalPrice: 0
        }
    })
    </script>

</body>

</html>
