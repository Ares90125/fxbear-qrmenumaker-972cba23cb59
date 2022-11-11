<!-- STRIPE -->
@if (config('settings.stripe_key')&&config('settings.enable_stripe'))
  <div class="text-center" style="display: none" id="totalSubmitStripe">
    <i id="indicatorStripe" style="display: none" class="fa fa-spinner fa-spin"></i>
    <button
        v-if="totalPrice"
        type="submit"
        id="stripeSend"
        class="button full-button d-flex align-items-center justify-content-center uppercase paymentbutton"
        onclick="document.getElementById('stripe-payment-form').submit();"
        >{{ __('Place an order') }}</button>
  </div>
@endif
