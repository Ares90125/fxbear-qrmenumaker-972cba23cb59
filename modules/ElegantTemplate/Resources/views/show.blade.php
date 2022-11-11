<!DOCTYPE html>
<html>
 @include('elegant-template::templates.head')
<body>
    <?php
        function clean($string) {
            $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }
    ?>
    @include('elegant-template::templates.mobile-menu')
    <div id='wrapper'>
         @include('elegant-template::templates.logo_and_menu')
         @include('restorants.partials.modals')
         @include('elegant-template::templates.call_waiter')
         @include('elegant-template::templates.place-header')
         @include('elegant-template::templates.place-content')
         @if (isset($doWeHaveImpressumApp)&&$doWeHaveImpressumApp&&strlen($restorant->getConfig('impressum_value',''))>5)
            @include('elegant-template::templates.impressum')
        @endif
        @include('elegant-template::templates.footer')
         
    </div>
   
 
    @include('elegant-template::templates.scripts')
    
    
</body>

</html>