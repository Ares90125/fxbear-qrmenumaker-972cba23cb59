
<div class="card-body tablepicker">
  <div class="tablepicker">
    <input type="hidden" value="{{$restorant->id}}" id="restaurant_id"/>
    @if ($tid==null)
      <label class="form-control-label mb-2">{{ __('Select Table') }}</label>
      @include('cart.luxe.select',$tables)
    @else            
      <h4>{{$tableName}}</h4>
      <input type="hidden" value="{{$tid}}" name="table_id"  id="table_id"/>
    @endif
  </div>
</div>

