
<!-- section-place-content-menu -->
<section class='section section-place-content-menu'>
    <div class='packer'>
        <div class="package">
            <nav>
                <a href='#place-menu' class='current menu-tab'>{{ __('Menu') }}</a>
                <a class='menu-tab' href='#place-info'>{{ __('Info') }}</a>
            </nav>
        </div>
    </div>
</section>
<!-- section-place-content -->
<section class='section section-place-content'>
    <div class='packer'>
        <div class='package'>
            <div id="theCartBottomButton" onClick="openNav()" class=" close-mobile-menu circle callOutShoppingButtonBottom icon icon-shape bg-gradient-red text-white rounded-circle shadow mb-4" style=" background: linear-gradient(87deg, #ffffff 0, #ffffff 100%) !important;">
                <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_atunf5kv.json"  background="transparent"  speed="0.5"  style="width: 50px; height:50px;" loop autoplay></lottie-player>
            </div>
            <div class='content'>
                
                <!-- tab menu -->
                <div id='place-menu' class='holder-left {{  !$canDoOrdering?"fullHolder":""  }} content-tab expanded'>
                    <div class='content-left'>
                        
                        <div class='categories'>
                            <div class='categories_title'>{{__('Categories')}}</div>
                            <nav>

                            @foreach ( $restorant->categories as $key => $category)
                                @if(!$category->items->isEmpty())
                                    <div class='item'>
                                        <a href='#subsection-<?php echo $category->id; ?>'><?php echo $category->name ?></a>
                                    </div>
                                @endif
                            @endforeach

                               
                            </nav>



                            <!-- alergens legend -->
                                @if (count($allergens)>0)
                                
                                    <br /><br />
                                    <div class='categories_title'>{{__('Allergens')}}</div>
                                    <nav>

                                    @foreach ( $allergens as $key => $allergen)
                                        
                                        <div class='item'>
                                            <div class='allergen' >
                                                <img  src="{{$allergen->image_link}}" />
                                            </div>
                                            <?php echo " ".$allergen->title ?>
                                        </div>
                                        
                                    @endforeach

                                    
                                    </nav>
                        
                            @endif
                            <!-- alergens legend -->

                        </div>

                        

                        
                        


                    </div>
                    <div class='content-center'>

                        
                 

                        @if(!$restorant->categories->isEmpty())
                            @foreach ( $restorant->categories as $key => $category)

                            <div id='subsection-<?php echo $category->id; ?>' class='box-info'>
                                <div class='head align-center'>
                                    <h3><?php echo $category->name; ?></h3>
                                </div>
                                <div class='content'>
                                    @foreach ($category->aitems as $item)
                                        <a href='javascript:;' onClick="setCurrentItem({{ $item->id }})" class='item-offer-horizontal'>
                                            <div class='info'>
                                                <h4 class="title">{{ $item->name }}</h4>
                                                <p>{{ $item->short_description}}</p>
                                                <div class='extras'>
                                                    <div class='price'>
                                                        @if ($item->discounted_price>0)
                                                        <span class="text-muted" style="text-decoration: line-through;">@money($item->discounted_price, config('settings.cashier_currency'),config('settings.do_convertion'))</span>
                                                    @endif
                                                        @money($item->price, config('settings.cashier_currency'),config('settings.do_convertion'))
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
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            @endforeach
                        @endif




                       
                    </div>
                </div>

                <!-- tab info -->
                <div id='place-info' class='holder-left {{  !$canDoOrdering?"fullHolder":""  }} content-tab'>
                    <div class='full-width'>
                        <div class='box-info'>
                            <div class='head'>
                                <h3><i class="las la-map-marker"></i>{{ __('Address') }}</h3>
                                <div class='info'>
                                    <p><strong>{{ $restorant->address }}</strong></p>
                                    <p>{{ $restorant->phone }}</p>
                                </div>
                            </div>
                            <div class='content'>
                                <div class='schedule-map'>
                                    <div class='schedule'>
                                        <h4>{{ __('Working Hours') }}</h4>
                                        <ol class='items'>
                                            @foreach ($wh as $day=>$hours)
                                                <li>
                                                    @if ($day==$currentDay)
                                                        <div class='day'>{{ __(ucfirst($day))}}
                                                            <span class='tag'>
                                                                {{ __('Today') }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class='day'>{{ __(ucfirst($day))}} </div>
                                                    @endif
                                                    @foreach ($hours as $timeRange)
                                                        <div class='hours'>{{ $timeRange->start() }} - {{ $timeRange->end() }} </div>
                                                    @endforeach
                                                    
                                                </li>
                                            @endforeach
                                            
                                        </ol>
                                        
                                    </div>
                                    <div class="map">
                                        <iframe src="https://maps.google.com/maps?q={{ $restorant->lat }},{{ $restorant->lng }}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($canDoOrdering)
                    <div class='holder-right'>
                        <!-- New cart -->
                            @include('elegant-template::templates.side_cart',['id'=>'cartList','idtotal'=>'totalPrices'])
                        <!-- End New cart -->
                    </div>
                @endif
                
            </div>
        </div>
    </div>

   
           

</section>