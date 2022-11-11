
<div class="card-body payment-select service-method">

    @if($restorant->can_dinein)
  <div class="custom-control custom-radio mb-3">
    <input name="dineType" class="custom-control-input" id="deliveryTypeDinein" type="radio" value="dinein" checked>
    <label class="custom-control-label d-flex justify-content-start align-items-center" for="deliveryTypeDinein"><svg width="17" viewBox="0 0 21 28" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M7 1v8 0c0 1.1-.9 2-2 2H3v0c-1.11 0-2-.9-2-2V1"/><path d="M4 1l0 26"/><path d="M16 1a4 5 0 1 0 0 10 4 5 0 1 0 0-10Z"/><path d="M16 27l0-16"/></g></svg>&nbsp;&nbsp;{{ __('Dine In') }}</label>
    <span class="checkmark"></span>
  </div>
    @endif

        <div class="custom-control custom-radio mb-3">
            <input name="dineType" class="custom-control-input" id="deliveryTypeTakeAway" type="radio" value="takeaway">
            <label class="custom-control-label d-flex justify-content-start align-items-center" for="deliveryTypeTakeAway"><svg width="17" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="3" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M26 29H4h-.001c-1.62.03-2.97-1.25-3-2.86 -.01-.01-.01-.01-.01-.01l3-18.14h22l3 18.14v0c-.04 1.61-1.39 2.89-3 2.86 -.01-.01-.01-.01-.01-.01Z"/><path d="M10 6v0c0-2.77 2.23-5 5-5 2.76 0 5 2.23 5 5"/><path d="M10 6l0 2"/><path d="M20 6l0 2"/></g></svg>&nbsp;&nbsp;{{ __('Pickup') }}</label>
            <span class="checkmark"></span>
        </div>

  <div class="custom-control custom-radio mb-3">
    <input name="dineType" class="custom-control-input" id="deliveryTypeDerlivery" type="radio" value="delivery">
    <label class="custom-control-label d-flex justify-content-start align-items-center" for="deliveryTypeDerlivery"><svg width="17" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="3" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M25 21.35c2.47.81 4 1.92 4 3.15C29 27 22.73 29 15 29c-7.73 0-14-2-14-4.5 0-1.23 1.53-2.34 4-3.15"/><path d="M15 1v0c-4.74 0-8.57 3.83-8.57 8.57C6.43 18.14 15 25 15 25s8.57-6.86 8.57-15.43v0C23.57 4.83 19.73 1 15 1Z"/><path d="M15 6a3 3 0 1 0 0 6 3 3 0 1 0 0-6Z"/></g></svg>&nbsp;&nbsp;{{ __('Delivery') }}</label>
    <span class="checkmark"></span>
  </div>

</div>


