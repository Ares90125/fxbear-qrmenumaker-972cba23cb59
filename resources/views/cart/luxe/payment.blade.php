<div class="card">
    <div class="card-header text-center">
        <h4 class="uppercase">{{ __('Order Summary') }}</h4>
    </div>
    <div class="card-body">
        @include('cart.luxe.items')
        <hr class="dashed">

        <!-- Price overview -->
        <div id="totalPrices" v-cloak>
            <div class="d-flex justify-content-center align-items-center" v-if="totalPrice==0">{{ __('Cart is empty') }}!</div>
            <ul class="clearfix">
                <li v-if="totalPrice">{{ __('Subtotal') }}:<span class="text-dark">@{{ totalPriceFormat }}</span></li>
                <li v-if="deduct">{{ __('Coupon discount') }}:<span v-if="deduct" class="ammount">@{{ deductFormat }}</span></li>
                @if(config('app.isft')||config('settings.is_whatsapp_ordering_mode')|| in_array("poscloud", config('global.modules',[])) || in_array("deliveryqr", config('global.modules',[])) )
                <li v-if="totalPrice&&deliveryPrice>0">{{ __('Delivery') }}:<span id="deliveryPriceFormated">@{{ deliveryPriceFormated }}</span></li>
                @endif
                <li v-if="totalPrice" class="total text-dark">{{ __('Total') }}:<span class="text-lg text-dark">@{{ withDeliveryFormat }}</span></li>
                <input v-if="totalPrice" type="hidden" id="tootalPricewithDeliveryRaw"
                       :value="withDelivery"
                       data-min-price="{{ $restorant->minimum }}" />
            </ul>
        </div>
        <!-- End price overview -->
        @if(in_array("coupons", config('global.modules',[])))
            <!-- Coupons -->
            @include('cart.luxe.coupons')
            <!-- End coupons -->
        @endif
        <div class="terms-checkbox rounded-sm d-flex justify-content-center align-items-center p-3 mb-3 border text-center text-muted text-sm">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" id="privacypolicy" checked type="checkbox">
                <label class="custom-control-label text-sm" for="privacypolicy">
                    &nbsp;&nbsp;{{__('I agree to the')}}
                    <a href="{{config('settings.link_to_ts')}}" target="_blank" style="text-decoration: underline;">{{__('Terms of Service')}}</a>
                </label>
            </div>
        </div>



        <!-- Payment Actions -->
        @if(!config('settings.social_mode'))

            <!-- COD -->
            @include('cart.luxe.payments.cod')

            <!-- Extra Payments ( Via module ) -->
            @foreach ($extraPayments as $extraPayment)
                @include($extraPayment.'::button', ['disabled' => true])
            @endforeach

            </form>

            <!-- Stripe -->
            @include('cart.luxe.payments.submitstripe')



        @elseif(config('settings.is_whatsapp_ordering_mode'))
            @include('cart.luxe.payments.whatsapp')
        @elseif(config('settings.is_facebook_ordering_mode'))
            @include('cart.luxe.payments.facebook')
        @endif
        <!-- END Payment Actions -->
    </div>

