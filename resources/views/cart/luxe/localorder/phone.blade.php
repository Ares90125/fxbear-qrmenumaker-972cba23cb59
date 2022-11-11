<div id="localorder_phone">
  <label class="form-control-label mb-2">{{ __('Phone')}}*</label>
  <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
    <input type="text" name="phone_user" id="phoneStandart" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __( 'Your phone here' ) }} ..." required></input>
    @if ($errors->has('phone'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('phone') }}</strong>
    </span>
    @endif
  </div>
</div>
