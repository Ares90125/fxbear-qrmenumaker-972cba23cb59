@if(count($fieldsToRender)>0)
  <div class="card-body">
    <label class="form-control-label mb-2">{{ __(config('settings.label_on_custom_fields')) }}</label>
    @include('partials.fields',['fields'=>$fieldsToRender])
  </div>
@endif



