  <!-- header -->
  <section id='header' class='header section-header bg-transparent border-0'>
      <div class='packer'>
          <div class='package'>
              <div class='left'>
                <a href='/{{ $restorant->subdomain }}' class='d-flex align-items-center btn btn-link back-button'><svg width="12" fill="currentColor" viewBox="0 -23.1328 12.25 11.9218" xmlns="http://www.w3.org/2000/svg"><path d="M7.05-12.01c.12-.13.18-.29.17-.47 -.01-.19-.08-.34-.21-.47L3.72-16.1h7.84c.18 0 .33-.07.46-.2 .12-.13.19-.29.19-.47v-.88c0-.19-.07-.34-.2-.47 -.13-.13-.29-.2-.47-.2H3.69l3.28-3.15c.12-.13.19-.29.2-.47 0-.19-.06-.34-.18-.47l-.63-.61c-.13-.13-.29-.2-.47-.2 -.19 0-.34.06-.47.19l-5.31 5.3c-.13.12-.2.28-.2.46s.06.33.19.46l5.3 5.3c.12.12.28.19.46.19s.33-.07.46-.2Z"/></svg>&nbsp;&nbsp;{{ __('Back')}}</a>
              </div>
              <div class='right'>
                  <nav id='menu'>
                    @if(!config('settings.is_whatsapp_ordering_mode') && !$restorant->getConfig('disable_callwaiter', 0) && strlen(config('broadcasting.connections.pusher.app_id')) > 2 && strlen(config('broadcasting.connections.pusher.key')) > 2 && strlen(config('broadcasting.connections.pusher.secret')) > 2)
                      <a data-toggle="modal" data-target="#modal-form" href='javascript:;' class='d-flex btn_hero'><svg width="16" fill="#444" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21 15c0-4.625-3.51-8.45-8-8.95V3.99h-2v2.05c-4.493.5-8 4.31-8 8.941v2h18v-2ZM5 15c0-3.859 3.141-7 7-7s7 3.141 7 7H5Zm-3 3h20v2H2Z"/></svg>&nbsp;{{ __('Call Waiter') }}</a> 
                    @endif
                  </nav>
              </div>
          </div>
      </div>
  </section>