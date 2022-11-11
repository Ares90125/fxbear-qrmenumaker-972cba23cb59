<div id="addressBox">

  <div class="card-body">
    @include('partials.fields',
      ['fields'=>[
        ['ftype'=>'input','name'=>"Your Address*",'id'=>"addressId",'placeholder'=>"Your delivery address here ...",'required'=>true],
        ]])
  </div>
  <div class="card-body">
    <label class="form-control-label mb-2">{{ __('Delivery Area') }}*</label>
    <select name="delivery_area" id="delivery_area" class="form-control{{ $errors->has('delivery_area') ? ' is-invalid' : '' }}" >
      <option  value="0">{{ __('Select delivery area') }}</option>
      @foreach ($restorant->deliveryAreas()->get() as $simplearea)
          <option data-cost="{{ $simplearea->cost }}" value="{{ $simplearea->id }}">{{$simplearea->getPriceFormated()}}</option>
      @endforeach
    </select>

      @if ($errors->has('delivery_area'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('delivery_area') }}</strong>
        </span>
      @endif
  </div>
</div>
