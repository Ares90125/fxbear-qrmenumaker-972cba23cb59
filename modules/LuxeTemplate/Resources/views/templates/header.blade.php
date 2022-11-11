  <!-- header -->
  <section id='header' class='header section-header bg-white'>
      <div class='packer'>
          <div class='package'>
              <div class='left'>
                        <!-- Project branding -->
                <a href='/' class='logo'>
                    <picture>
                        <source srcset="{{ config('global.site_logo') }}" media="(min-width: 569px)" />
                        <img loading="lazy" src="{{ config('global.site_logo') }}" />
                    </picture>
                </a>
              </div>
              <div class='right'>
                  <nav id='menu'>
                    @if(config('app.isft'))
                        @auth()
                            <a href='/home' class='featured'>{{ __('Dashboard') }}</a>
                        @endauth
                        @guest()
                            <a href='/login' class='featured'>{{ __('Login') }}</a>
                        @endguest
                    @endif
                  </nav>
              </div>
          </div>
      </div>
  </section>