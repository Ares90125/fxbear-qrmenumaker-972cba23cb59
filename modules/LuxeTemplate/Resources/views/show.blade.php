<!DOCTYPE html>
<html lang="<?php echo  App::getLocale() ?>">
    @include('luxe-template::templates.head')
    <body data-spy="scroll" data-target="#secondary_nav" data-offset="75">
        <?php function clean($string) {
            $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
            }
        ?>
        <div id='wrapper'>
            @include('partials.flash')
            @include('luxe-template::templates.availability')
            @include('luxe-template::templates.mobile-menu')
            @if(config('app.isft'))
            @include('luxe-template::templates.header')
            @endif
            @include('luxe-template::templates.modals')
            @include('luxe-template::templates.call_waiter')
            @include('luxe-template::templates.place-header')
            @include('luxe-template::templates.place-content')
        </div>
        <div id="toTop"></div><!-- Back to top button --> 
        @include('luxe-template::templates.scripts')
    </body>
</html>