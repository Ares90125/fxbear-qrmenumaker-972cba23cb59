<!-- Add Address -->
<div class="modal fade bd-example-moda" id="modal-order-new-address" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered " role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="mb-0">{{ __('Add New Address') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="new_address_checkout_body">
                <form role="form">
                    @csrf
                    <div class="form-group" id="new_address_checkout_holder">
                        <label class="form-control-label" for="new_address_checkout">{{ __('Address') }}</label>
                        <select class=" form-control" id="new_address_checkout">
                        </select>
                    </div>

                    <div class="form-group">
                        <div id="new_address_map" class="form-control"></div>
                    </div>

                    <div id="address-info">
                        <div class="row no-gutters">
                            <div class="col">
                                <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                    <input name="address" id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Address')}}">
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('address_number') ? ' has-danger' : '' }}">
                                    <input name="address_number" id="address_number" type="text" class="form-control{{ $errors->has('address_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Address number')}}">
                                    @if ($errors->has('address_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('number_apartment') ? ' has-danger' : '' }}">
                                    <input name="number_apartment" id="number_apartment" type="text" class="form-control{{ $errors->has('number_apartment') ? ' is-invalid' : '' }}" placeholder="{{ __('Apartment number')}}">
                                    @if ($errors->has('number_apartment'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('number_apartment') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <input type="hidden" id="lat" name="lat" />

                            </div>
                            <div class="col">
                                <div class="form-group{{ $errors->has('number_intercom') ? ' has-danger' : '' }}">
                                    <input name="number_intercom" id="number_intercom" type="text" class="form-control{{ $errors->has('number_intercom') ? ' is-invalid' : '' }}" placeholder="{{ __('Intercom')}}">
                                    @if ($errors->has('number_intercom'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('number_intercom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('floor') ? ' has-danger' : '' }}">
                                    <input name="floor" id="floor" type="text" class="form-control{{ $errors->has('floor') ? ' is-invalid' : '' }}" placeholder="{{ __('Floor')}}">
                                    @if ($errors->has('floor'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('floor') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('entry') ? ' has-danger' : '' }}">
                                    <input name="entry" id="entry" type="text" class="form-control{{ $errors->has('entry') ? ' is-invalid' : '' }}" placeholder="{{ __('Entry number')}}">
                                    @if ($errors->has('entry'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('entry') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <input type="hidden" id="lng" name="lng" />
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col"><button type="button" class="btn mb-0 bg-transparent rounded-sm d-flex justify-content-center align-items-center border w-100 bg-transparent text-center text-muted text-sm " data-dismiss="modal" aria-label="Close">{{ __('Cancel')}}</button></div>
                        <div class="col"><button iid="submitNewAddress" type="button" class="btn w-100 d-flex justify-content-center align-items-center rounded-sm btn-outline-primary text-sm">{{ __('Save') }}</button></div>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</div>
<!-- Add Coupon -->
<div class="modal fade bd-example-moda" id="applyCoupon" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered " role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="mb-0">{{ __('Apply Coupon') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <input  id="coupon_code" name="coupon_code" type="text" class="form-control form-control-alternative mb-4" placeholder="{{ __('Discount coupon')}}">
                <div class="row no-gutters">
                    <div class="col"><button type="button" class="btn mb-0 bg-transparent rounded-sm d-flex justify-content-center align-items-center border w-100 bg-transparent text-center text-muted text-sm " data-dismiss="modal" aria-label="Close">{{ __('Cancel')}}</button></div>
                    <div class="col"><button id="promo_code_btn" type="button" class="btn w-100 d-flex justify-content-center align-items-center rounded-sm btn-outline-primary text-sm">{{ __('Apply') }}</button></div>
                </div>
                <span><i id="promo_code_succ" class="ni ni-check-bold text-success"></i></span>
                <span><i id="promo_code_war" class="ni ni-fat-remove text-danger"></i></span>
            </div>
        </div>
    </div>
</div>

