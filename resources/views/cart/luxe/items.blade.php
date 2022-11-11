
<!-- List of items -->
<div  id="cartList" class="border-top">
    <div  v-for="item in items" class="items clearfix">
        <picture>
            <img :src="item.attributes.image" :data-src="item.attributes.image"  class="productImage" alt="">
        </picture>
        <div class="info" v-cloak>
            <h6 class="title mb-1">@{{ item.name }}</h6>
            <div class="extras d-flex justify-content-between align-items-center">
                <div class="price">
                    <h5 class="mb-0">@{{ item.attributes.friendly_price }}</h5>
                </div>
                <div class="qty d-flex justify-content-around align-items-center">
                    <button type="button" id="decQuantity" v-on:click="decQuantity(item.id);" :value="item.id" class="btn btn-icon btn-sm page-link btn-cart-radius">-</button>
                    <h5 class="product-item_quantity mx-3">@{{ item.quantity }}</h5>
                    <button type="button" id="incQuantity" v-on:click="incQuantity(item.id); " :value="item.id" class="btn btn-icon btn-sm page-link btn-cart-radius mr-0">+</button>
                </div>
            </div>
        </div>
        <button type="button" v-on:click="remove(item.id)"  :value="item.id" class="absolute close">
            <svg width="14" fill="#878787" viewBox="0.218749 -25.5937 13.5625 13.5625" xmlns="http://www.w3.org/2000/svg"><path d="M6.99-25.6c-1.88 0-3.48.66-4.8 1.98C.86-22.3.2-20.7.2-18.83c0 1.87.66 3.47 1.98 4.79 1.32 1.32 2.92 1.98 4.79 1.98s3.47-.67 4.79-1.99c1.32-1.33 1.98-2.93 1.98-4.8 0-1.88-.67-3.48-1.99-4.8 -1.33-1.33-2.93-1.99-4.8-1.99Zm3.33 8.55c.14.16.14.31 0 .46l-1.1 1.09c-.15.14-.31.14-.47 0l-1.78-1.81 -1.78 1.8c-.17.14-.32.14-.47 0l-1.1-1.1c-.15-.15-.15-.31 0-.47l1.8-1.78 -1.81-1.78c-.15-.17-.15-.32 0-.47l1.09-1.1c.14-.15.3-.15.46 0l1.77 1.8 1.77-1.81c.16-.15.31-.15.46 0l1.09 1.09c.14.14.14.3 0 .46L8.44-18.9Z"/></svg>
        </button>
    </div>
</div>
<!-- End List of items -->

