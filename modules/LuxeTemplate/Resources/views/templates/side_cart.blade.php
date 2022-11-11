<div class='info' id="order-summary">
    <div class='box-info bg-white'>
        <div class="box-order">
            <div class='head align-center'>
                <h6>{{ __('Order Summary') }} <br><small>{{ __('Minimum order for delivery') }}  @money($restorant->minimum, config('settings.cashier_currency'),config('settings.do_convertion'))</small></h6>
            </div>
        </div>
        <div class='content' id="{{$id}}">
            <ul class="clearfix mb-0 w-100">
                <li v-for="item in items" class="items col-12 clearfix">
                    <div class=" clearfix" v-cloak>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <button type="button" v-on:click="remove(item.id)"  :value="item.id" class="btn btn-outline-primary btn-icon btn-sm page-link btn-cart-radius mr-2">
                                    <span class="btn-inner--icon btn-cart-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" fill="#777" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><path d="M256,90c44.3,0,86,17.3,117.4,48.6C404.7,170,422,211.7,422,256s-17.3,86-48.6,117.4C342,404.7,300.3,422,256,422   s-86-17.3-117.4-48.6C107.3,342,90,300.3,90,256s17.3-86,48.6-117.4C170,107.3,211.7,90,256,90 M256,48C141.1,48,48,141.1,48,256   s93.1,208,208,208s208-93.1,208-208S370.9,48,256,48L256,48z"></path></g><polygon points="360,330.9 330.9,360 256,285.1 181.1,360 152,330.9 226.9,256 152,181.1 181.1,152 256,226.9 330.9,152 360,181.1   285.1,256 "></polygon></svg>
                                    </span>
                                </button>

                                <a href="javascript:;" v-on:click="remove(item.id)"  :value="item.id" class="product-item_title text-truncate mb-0" ><span class="product-item_quantity">@{{ item.quantity }} x </span>@{{ item.name }}</a>
                            </div>
                            <p class="product-item_price mb-0">@{{ item.attributes.friendly_price }}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div id="{{ $idtotal }}">
            <div  v-if="totalPrice==0" class='empty-cart'>
                <p><small>{{ __('Add something to order') }}!</small></p>
            </div>
            <div  v-if="totalPrice" class='actionsCart'>
                <a href="javascript:void(0);" class='button full-button button-to-cart' onclick="checkPrice()" :data-price="totalPrice" data-min-price="{{ $restorant->minimum }}">
                    <span class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="#FFF" id="BeBold" viewBox="0 0 14 14"><path d="M7.179,11.128,10.26,8.083,1.066,8.041A1.07,1.07,0,0,1,0,6.965H0A1.07,1.07,0,0,1,1.076,5.9l9.192.041L7.228,2.865a1.07,1.07,0,0,1,.006-1.514h0a1.072,1.072,0,0,1,1.515.007l5,5.049a.879.879,0,0,1-.007,1.243l-5.053,5a1.071,1.071,0,0,1-1.514-.007h0A1.071,1.071,0,0,1,7.179,11.128Z"></path></svg>
                        &nbsp; {{ __('Checkout') }}
                    </span>
                    <span class="ammount">@{{ totalPriceFormat }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
