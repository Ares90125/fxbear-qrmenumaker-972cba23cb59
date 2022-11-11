    <script src="{{ asset('luxe') }}/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>
    <script src="{{ asset('custom') }}/js/select2.js"></script>
    <script src="{{ asset('vendor') }}/select2/select2.min.js"></script>
    <!-- cartFunctions.js and order.js was modified by @aleksiralda using V3.1.3 -->
    <script src="{{ asset('luxe') }}/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('custom') }}/js/notify.min.js"></script>
    <script src="{{ asset('luxe') }}/cartFunctions.js"></script>
    <script src="{{ asset('luxe') }}/order.js"></script>

    <script src="{{ asset('custom') }}/js/js.js"></script>

    <script>
        var CASHIER_CURRENCY = "<?php echo  config('settings.cashier_currency') ?>";
        var LOCALE="<?php echo  App::getLocale() ?>";
        var IS_POS=false;
    </script>

    @if (isset($showGoogleTranslate)&&$showGoogleTranslate&&!$showLanguagesSelector)
        @include('googletranslate::scripts')
    @endif
    <!-- Interface from PHP items to JS Array -->
    @include('restorants.phporderinterface')
    <script src="{{ asset('luxe') }}/LuxeTemplate.js"></script>

