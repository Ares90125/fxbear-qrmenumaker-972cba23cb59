
    @if(config('app.isft'))
        <a href='/' class='logo'>
            <picture style="filter: brightness(0) invert(1);">
                <source srcset="{{ config('global.site_logo') }}" media="(min-width: 569px)" />
                <img loading="lazy" src='{{ config('global.site_logo') }}' />
            </picture>
        </a>
    @else
        @if(!config('settings.hide_project_branding')||(!isset($restorant)))
            <!-- Project branding -->
            <a href='/' class='logo'>
                <picture>
                    <source srcset="{{ config('global.site_logo') }}" media="(min-width: 569px)" />
                    <img loading="lazy" src='{{ config('global.site_logo') }}' />
                </picture>
            </a>
        @else
            <a class="logo" id="topLightLogo" href="#">
                <picture>
                    <source srcset="{{$restorant->logowide }}" media="(min-width: 569px)" />
                    <img loading="lazy" src='{{$restorant->logowide }}' />
                </picture>
            </a>
        @endif
        @endif
