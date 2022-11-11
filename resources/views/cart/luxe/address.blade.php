
<div class="card-body" id="addressBox">
    <input type="hidden" value="{{$restorant->id}}" id="restaurant_id"/>
    <div class="form-group{{ $errors->has('addressID') ? ' has-danger' : '' }}">
        <label class="custom-control-label d-flex justify-content-between align-items-center"><span>{{ __('Address')}}</span><span><a href="javascript:;"  data-toggle="modal" data-target="#modal-order-new-address">+ {{ __('Add new') }}</a></span></label>
        @if(count($addresses))
            <select name="addressID" id="addressID" class="form-control{{ $errors->has('addressID') ? ' is-invalid' : '' }} " required>
                <option disabled selected value> {{__('-- select an option -- ')}}</option>
                @foreach ($addresses as $key => $address)
                    @if(config('settings.enable_cost_per_distance'))
                        <option data-cost={{ $address->cost_per_km}} id="{{ 'address'.$address->id }}"  <?php if(!$address->inRadius){echo "disabled";} ?> value={{ $address->id }}>{{$address->address." - ".money( $address->cost_per_km, config('settings.cashier_currency'),config('settings.do_convertion')) }} </option>
                    @else
                <option data-cost={{ config('global.delivery')}} id="{{ 'address'.$address->id }}"  <?php if(!$address->inRadius){echo "disabled";} ?> value={{ $address->id }}>{{$address->address}} </option>
                    @endif
                @endforeach
            </select>
            @if ($errors->has('addressID'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('addressID') }}</strong>
                </span>
            @endif
        @else
            <p id="address-complete-order" class="d-flex justify-content-start align-items-center text-truncate"><svg width="16" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M21 3v0C16.58-.32 10.31.58 7 5c-1.3 1.73-2 3.83-2 6v0c.03 2.37.54 4.71 1.5 6.89"/><path d="M10.42 24.28l-.001-.001c1.36 1.72 2.89 3.3 4.58 4.72 0 0 10-8 10-18 0-.35 0-.7-.05-1.05"/><path d="M12.06 13.72h-.001c-1.55-1.59-1.52-4.12.07-5.66 1.58-1.55 4.11-1.52 5.66.07"/><path d="M29 1L1 29"/></g></svg>&nbsp;&nbsp;{{ __('You don`t have any address. Please add new one') }}.</p>
        @endif
    </div>
    <input type="hidden" name="deliveryCost" id="deliveryCost" value="0" />
</div>