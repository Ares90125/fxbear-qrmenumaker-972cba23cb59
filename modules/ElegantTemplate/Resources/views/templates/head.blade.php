
<!-- head -->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('argonfront') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('argonfront') }}/img/favicon.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $restorant->name }}</title>
    <meta property="og:image" content="{{ $restorant->logom }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="590">
    <meta property="og:image:height" content="400">
    <meta name="og:title" property="og:title" content="{{ $restorant->name }}">
    <meta name="description" content="{{ $restorant->description }}">



    @notifyCss

    

    <!-- Select2 -->
    <link type="text/css" href="{{ asset('custom') }}/css/select2.min.css" rel="stylesheet">

   

    <!-- Global site tag (gtag.js) - Google Analytics -->
    @if (config('settings.google_analytics'))
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo config('settings.google_analytics'); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '<?php echo config('settings.google_analytics'); ?>');
        </script>
    @endif

    @include('googletagmanager::head')
    @yield('head')
    @laravelPWA
    @include('layouts.rtl')
  

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff"  >

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <link type="text/css" rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <!-- Custom CSS defined by admin -->
    <link type="text/css" href="{{ asset('byadmin') }}/front.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <link type="text/css" rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link type="text/css" href="{{ asset('css') }}/elegant.css" rel="stylesheet">
    

     <!-- Custom CSS -->
     <link type="text/css" href="{{ asset('custom') }}/css/custom.css" rel="stylesheet">
      
     <!-- Import Vue -->
    <script src="{{ asset('vendor') }}/vue/vue.js"></script>
    <!-- Import AXIOS --->
    <script src="{{ asset('vendor') }}/axios/axios.min.js"></script>

    @if (isset($showGoogleTranslate)&&$showGoogleTranslate&&!$showLanguagesSelector)
        <!-- Style  Google Translate -->
        <link type="text/css" href="{{ asset('custom') }}/css/gt.css" rel="stylesheet">
    @endif

</head>