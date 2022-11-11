
<!-- head -->
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
    <meta property="og:title"  name="og:title" content="{{ $restorant->name }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff"  >

    <link rel="icon" type="image/png" href="{{ asset('argonfront') }}/img/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('argonfront') }}/img/apple-icon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    @include('googletagmanager::head')
    @yield('head')
    @laravelPWA
    @notifyCss

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap"> 
    <link rel="stylesheet" href="{{ asset('custom') }}/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('luxe') }}/bootstrap_customized.min.css">
    <link rel="stylesheet" href="{{ asset('luxe') }}/main.css">
    
    @if (isset($showGoogleTranslate)&&$showGoogleTranslate&&!$showLanguagesSelector)
    <link rel="stylesheet" href="{{ asset('luxe') }}/gt.css">
    @endif
    <link rel="stylesheet" href="{{ asset('byadmin') }}/front.css">

    <script src="{{ asset('vendor') }}/vue/vue.js"></script>
    <script src="{{ asset('vendor') }}/axios/axios.min.js"></script>

    @if (\Akaunting\Module\Facade::has('googleanalytics'))
        @include('googleanalytics::index') 
    @endif
</head>