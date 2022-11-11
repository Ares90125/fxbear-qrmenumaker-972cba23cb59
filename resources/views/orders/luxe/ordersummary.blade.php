
    <?php 
        $currency=config('settings.cashier_currency');
        $convert=config('settings.do_convertion');
    ?>
     @if(count($order->items)>0)
    <!-- <div class="table-header w-100 text-center border-bottom text-muted">
        <h6 class="uppercase">{{ __('Order Summary')}}</h6>
    </div>   -->
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('Item') }}</th>
                    <th class="col-1 text-center">{{ __('Qty') }}</th>
                    <th class="col-2 text-center">{{ __('Price') }}</th>
                    <th class="col-2 text-center">{{ __('Total') }}</th>
                    
                </tr>
            </thead>
            <tbody id="order-items">
                @foreach($order->items as $item)
                <?php $theItemPrice= ($item->pivot->variant_price?$item->pivot->variant_price:$item->price); ?>
                @if ( $item->pivot->qty>0)
                <tr>
                    <!-- Name + Variants + Extras -->
                    <td>
                        <div class="d-flex">
                            <picture>
                                <source srcset="{{ $item->logom }}" media="(min-width: 569px)" />
                                <img loading="lazy" src='{{ $item->logom }}' />
                            </picture>
                            <div class="relative">
                            <h5 class="text-dark font-weight-bold">{{$item->name}}</h5> 
                                @if (strlen($item->pivot->variant_name)>2)
                                <div class="d-flex">
                                    <div class="d-flex flex-column mr-2">
                                    @foreach ($item->options as $option)
                                        <small class="text-muted">{{ $option->name }}:</small>
                                    @endforeach
                                    </div>
                                    <div class="d-flex flex-column">
                                    @foreach (explode(",",$item->pivot->variant_name) as $optionValue)
                                        <small class="text-muted"><strong>{{ $optionValue }}</strong></small>
                                    @endforeach
                                    </div>
                                </div>
                                @endif

                                @if (strlen($item->pivot->extras)>2)
                                <div class="d-flex flex-column mb-2">
                                    @foreach(json_decode($item->pivot->extras) as $extra)
                                        <small class="text-muted">{{ __('Extras') }}: <strong>{{ $extra }}</strong></small>
                                    @endforeach
                                </div>
                                @endif
                                @if (!empty( $item->vat ))
                                    <small class="text-muted" style="font-style:italic">{{ __('Includes VAT')}} ( {{ $item->vat }}% )</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <!-- Qty -->
                    <td class="text-center font-weight-bold">{{$item->pivot->qty}}</td>
                    <!-- Price -->
                    <td class="font-weight-bold text-center">@money($theItemPrice, $currency,$convert)</td>
                    <!-- Total -->
                    <td class="font-weight-bold text-center">@money( $item->pivot->qty*$theItemPrice, $currency,true)</td>
                    
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
     @endif
    <div class="row">
        <div class="col-md-6">
            @if(!empty($order->comment))
            <div class="d-flex flex-column mb-3">
                <div class="order-comment">
                    <h5>{{ __('Note') }} / {{ __('Comment') }}:</h5>
                    <p class="mb-0">{{ $order->comment }}</p>
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-5 offset-md-1">
            <div class="order-summary">
                <h4 class="order-section-heading">{{ __('Order Summary')}}</h4>
                <div class="d-flex align-items-center justify-content-between order-summary-money">
                    <h6 class="text-muted mb-0">{{ __("Subtotal") }}: </h6>
                    <h6 class="mb-0">@money( $order->order_price-$order->vatvalue, $currency ,true)</h6>
                </div>
                <div class="d-flex align-items-center justify-content-between order-summary-money">
                    <h6 class="text-muted mb-0">{{ __("VAT") }} ({{ $item->vat }}%):</h6>
                    <h6 class="mb-0">@money( $order->vatvalue, $currency,$convert)</h6>
                </div>
                @if($order->delivery_method==1)
                <div class="d-flex align-items-center justify-content-between order-summary-money">
                    <h6 class="text-muted mb-0">{{ __("Delivery") }}:</h6>
                    <h6 class="mb-0">@money( $order->delivery_price, $currency,$convert)</h6>
                </div>
                @endif
                @if ($order->discount>0)
                    <div class="d-flex align-items-center justify-content-between order-summary-money">
                        <h6 class="text-muted mb-0">{{ __("Discount") }} ( {{$order->coupon}} ):</h6>
                        <h6 class="mb-0">- @money( $order->discount, $currency,$convert)</h6>
                    </div>
                @endif
                <div class="d-flex justify-content-between order-summary-total">
                    <h4>{{ __("Total") }}:</h4>
                    <h4>@money( $order->delivery_price+$order->order_price_with_discount, $currency,true)</h4>
                </div>
            </div>
        </div>
    </div>
     

     