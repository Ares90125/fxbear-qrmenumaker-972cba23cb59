<!-- section-place-content -->
<section class='section section-place-content'>
    <div class='bg-white nav-menu sticky_horizontal'>
        <div class='packer'>
            <div class="package">
                <nav id='place-menu' class=" content-tab expanded">
                    @foreach ( $restorant->categories as $key => $category)
                        @if(!$category->items->isEmpty())
                            <div class='item'>
                                <a class="" href='#subsection-<?php echo $category->id; ?>'><?php echo $category->name ?></a>
                            </div>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
    <div class='packer'>
        <div class='package'>
            <div class='content'>
                <div class="row">
                    <div class="col-xl-9">
                        <!-- tab menu -->
                        <div class='holder-left content-tab expanded'>
                            <div class='content-center'>
                                @if(!$restorant->categories->isEmpty())
                                    @foreach ( $restorant->categories as $key => $category)

                                    <div id='subsection-<?php echo $category->id; ?>' class='box-info'>
                                        <div class='head'>
                                            <h3 class="mb-0"><?php echo $category->name; ?></h3>
                                        </div>
                                        <div class='content grid'>
                                            @foreach ($category->aitems as $item)
                                                <a href=#modal onClick="setCurrentItem({{ $item->id }});" class='item-offer-horizontal'>
                                                    <div class='info'>
                                                        <h6 class="title">{{ $loop->iteration }}. {{ $item->name }}</h6>
                                                        <p class="text-truncate">{{ $item->short_description}}</p>
                                                        <div class='extras'>
                                                            <div class='price'>
                                                                @money($item->price, config('settings.cashier_currency'),config('settings.do_convertion'))
                                                                @if ($item->discounted_price>0)
                                                                    <span>@money($item->discounted_price, config('settings.cashier_currency'),config('settings.do_convertion'))</span>
                                                                @endif
                                                            </div>
                                                            <div class="allergens">
                                                                @foreach ($item->allergens as $allergen)
                                                                    <div class='allergen' data-toggle="tooltip" data-placement="bottom" title="{{$allergen->title}}" >
                                                                        <img  src="{{$allergen->image_link}}" />
                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <picture>
                                                        <source srcset="{{ $item->logom }}" media="(min-width: 569px)" />
                                                        <img loading="lazy" src='{{ $item->logom }}' />
                                                    </picture>
                                                    @if ($item->discounted_price>0)
                                                    <div class="absolute offer-label">
                                                        <svg viewBox="0 0 24 24" fill="#ffb232" width="42" xmlns="http://www.w3.org/2000/svg"><path fill="#FFF" d="M12 11.222l2.667 1.77 -.89-3.12 2.22-1.89 -2.667-.34 -1.34-2.67 -1.34 2.66 -2.667.33 2.22 1.88 -.89 3.11Z"/><path d="M19 21.723V9.99v-1 -5c0-1.104-.9-2-2-2H7c-1.104 0-2 .89-2 2v5 1 11.72l7-4.58 7 4.57ZM8 7.99l2.667-.34 1.33-2.667 1.33 2.667 2.667.33 -2.23 1.88 .89 3.11 -2.667-1.78 -2.667 1.77 .89-3.12 -2.23-1.89Z"/></svg>
                                                    </div>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        @if ($canDoOrdering)
                        <div class="btn_reserve_fixed"><a href="#0" class="btn_1 gradient full-width" id="theCartBottomButton" onClick="openNav()" >{{ __('Order Summary') }} </a></div>
                        @endif
                        <div class='holder-right mb-3'>
                            @if ($canDoOrdering)
                                @include('luxe-template::templates.side_cart',['id'=>'cartList','idtotal'=>'totalPrices'])
                            @endif
                            @include('luxe-template::templates.hours')
                            <div class="about-us text-center">
                                @if (isset($doWeHaveImpressumApp)&&$doWeHaveImpressumApp&&strlen($restorant->getConfig('impressum_value',''))>5)
                                    <div class="impressum">
                                        <h6>{{$restorant->getConfig('impressum_title','')}}</h6>
                                        <p><small><?php echo $restorant->getConfig('impressum_value',''); ?>.</small></p>
                                    </div>
                                @endif
                                <h6 class="text-center"><small>{{ __('Powered by') }} <a href="/" target="_blank" rel="noopener noreferrer">{{ config('global.site_name') }}</a></small></h6>
                                @if (!config('settings.single_mode')&&config('settings.restaurant_link_register_position')=="footer")
                                <a  target="_blank" class="nav-link" href="{{ route('newrestaurant.register') }}">{{ __('Add your Restaurant') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
