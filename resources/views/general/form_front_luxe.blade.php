
@extends('layouts.empty-luxe', ['title' => __('User Profile')])
@if (strlen(config('settings.recaptcha_site_key'))>2)
    @section('head')
    {!! htmlScriptTagJsApi([]) !!}
    @endsection
@endif

@section('content')

    <section class="section-place-content">
        <div class="container-sm">
            <div class="row h-100vh align-items-center justify-content-center">
                <div class="card p-4 border-0">
                    <form id="{{ getFormId() }}" action="{{ $setup['action'] }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header p-5 bg-white border-0">
                            <div class="row align-items-center text-center">
                                <h2 class="col-12 mb-0">{{ __('Thanks for visit') }} {{ ($setup['restaurant_name']) }}</h2>
                                <h6 class="text-center w-100 text-muted">{{ __('To receive a personalized atention, please register your visit here')}}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                                @isset($setup['isupdate'])
                                    @method('PUT')
                                @endisset
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @isset($setup['inrow'])
                                    <div class="row">
                                @endisset
                                    @include('partials.fields',['fields'=>$fields])
                                @isset($setup['inrow'])
                                    </div>
                                @endisset
                                

                        </div>
                        <div class="card-footer p-5 d-flex justify-content-center align-items-center">
                                @isset($setup['action_link'])
                                    <a href="{{ $setup['action_link'] }}"  type="button" class='d-flex align-items-center btn btn-link back-button mr-3'><svg width="12" fill="currentColor" viewBox="0 -23.1328 12.25 11.9218" xmlns="http://www.w3.org/2000/svg"><path d="M7.05-12.01c.12-.13.18-.29.17-.47 -.01-.19-.08-.34-.21-.47L3.72-16.1h7.84c.18 0 .33-.07.46-.2 .12-.13.19-.29.19-.47v-.88c0-.19-.07-.34-.2-.47 -.13-.13-.29-.2-.47-.2H3.69l3.28-3.15c.12-.13.19-.29.2-.47 0-.19-.06-.34-.18-.47l-.63-.61c-.13-.13-.29-.2-.47-.2 -.19 0-.34.06-.47.19l-5.31 5.3c-.13.12-.2.28-.2.46s.06.33.19.46l5.3 5.3c.12.12.28.19.46.19s.33-.07.46-.2Z"/></svg>&nbsp;&nbsp;{{ __($setup['action_name']) }}</a>
                                @endisset
                            

                                @if (strlen(config('settings.recaptcha_site_key'))>2)
                            
                                    @if ($errors->has('g-recaptcha-response'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                    @endif

                                    {!! htmlFormButton(__('Save'), ['id'=>'thesubmitbtn','class' => 'btn btn-success mt-4']) !!}
                                @else
                        
                                    <button type="submit"  id="thesubmitbtn" class='d-flex align-items-center btn btn-link refresh-button'><svg width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path opacity="0" fill="#FFF" d="M0 0h24v24H0Z"/><g fill="currentColor"><path d="M12.71 11.29v0c-.39-.39-1.02-.39-1.4 0l-3 2.9 0 0c-.43.35-.49.98-.14 1.4 .35.42.98.48 1.4.13 .03-.04.07-.07.1-.11l1.31-1.27v5.64 0c0 .55.44 1 1 1 .55 0 1-.45 1-1v-5.59l1.29 1.3v0c.38.39 1.02.39 1.41 0 0-.01 0-.01 0-.01v0c.39-.39.39-1.03 0-1.42 -.01-.01-.01-.01-.01-.01Z"/><path d="M17.67 7v0c-1.09-3.14-4.51-4.8-7.64-3.71 -1.74.6-3.11 1.96-3.71 3.7v0c-2.74.36-4.66 2.88-4.3 5.61 .13.98.55 1.9 1.21 2.65v0c.27.48.88.64 1.36.37 .48-.28.64-.89.37-1.37 -.07-.11-.15-.21-.24-.29H4.71c-1.11-1.24-1-3.14.23-4.24 .55-.5 1.27-.77 2.01-.77h.1v0c.48 0 .9-.33 1-.8v0c.43-2.17 2.55-3.57 4.71-3.13 1.57.31 2.8 1.54 3.12 3.12v0c.09.47.51.8 1 .8h.06 -.001c1.65-.01 3 1.32 3.01 2.98 0 .74-.27 1.46-.77 2.01v0c-.37.41-.34 1.04.08 1.41 0 0 0 0 0 0v-.001c.18.16.41.24.66.25v0c.28-.01.56-.13.75-.34v0c1.86-2.05 1.71-5.21-.33-7.07 -.77-.7-1.73-1.14-2.76-1.27Z"/></g></svg>&nbsp;&nbsp;{{ __('Save')}}</a>
                                @endif
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@if (isset($_GET['name'])&&$errors->isEmpty())
<script>
    "use strict";
    document.getElementById("thesubmitbtn").click();
</script>
@endif
@endsection

