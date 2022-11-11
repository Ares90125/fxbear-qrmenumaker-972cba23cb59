<div class="text-center payment_form_submiter" id="stripelinks-payment-form" style="display: {{ config('settings.default_payment')=="stripelinks"?"block":"none"}};" >
    <button
        @if(isset($disabled) && $disabled) disabled @endif
        v-if="totalPrice"
        type="submit"
        class="btn btn-success mt-4 paymentbutton"
    >{{ __('Pay Online') }}</button>
</div>

<style>
    #stripelinks-payment-form button {
        margin: 0 auto;
    }

    #stripelinks-payment-form button[disabled] {
        background: #ccc;
    }
</style>


