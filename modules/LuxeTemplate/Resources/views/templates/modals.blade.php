<div class="modal fade bd-example-modal-sm" id="productModal" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered " role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="mb-0">{{ __('Add to Cart') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="row no-gutters m-0 align-items-center">
                    <div class="col-12">
                        <div class="modalCover">
                            <figure  id="modalImgPart">
                                <img id="modalImg" src="" width="100%">
                            </figure>
                        </div>
                    </div>
                    <div class="col-12" id="modalItemDetailsPart">
                        <div class="pt-5 pb-3 px-6">
                            <h4 id="modalTitle" class="modal-title mb-2" id="modal-title-new-item"></h4>
                            <p id="modalDescription" class="mb-6"></p>
                            <input id="modalID" type="hidden"></input>
                            <div class="price-modal">

                            </div>
                            <div id="variants-area">
                                <label class="form-control-label mb-3">{{ __('Select your options') }}</label>
                                <div id="variants-area-inside">
                                </div>
                            </div>
                            <div id="exrtas-area">
                                <h5 class="form-control-label w-100">{{ __('Extras') }}</h5>
                                <div id="exrtas-area-inside">
                                </div>
                            </div>
                            <!-- Inform if closed -->
                            @if (isset($openingTime)&&!empty($openingTime))
                                <div class="closed_time">{{__('Opens')}} {{ $openingTime }}</div>
                            @endif
                            <!-- End inform -->
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="pt-2 pb-3 px-6">
                            <label for="">Comments</label>
                            <textarea id="commentItem" name="comment"
                                      onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '')"  cols="30" rows="10"
                                      placeholder="{{ __('Special comment') }}"></textarea>
                        </div>

                    </div>
                </div>
            </div>

            @if(  !(isset($canDoOrdering)&&!$canDoOrdering)   )
            <div class="modal-footer">
                <div class="footer-area">
                    <div class="d-flex product-price justify-content-between align-items-start mb-4">
                        <div id="price-area" class="py-2">
                            <h6>{{ __('Price' ) }}</h6>
                            <h3 id="modalPrice" class="new-price mt-2 mb-0"></h3>
                        </div>
                        <div class="quantity-area py-2">
                            <h6>{{ __('Quantity' ) }}</h6>
                            <div class="numbers-row">
                                <input type="number" value="1" id="quantity" class="qty2 form-control" name="quantity" placeholder="1" min="1" step="1"  autofocus required >
                            </div>
                        </div>
                    </div>
                    <div class="quantity-btn btn-block">
                        <div id="addToCart1">
                            <button class="btn btn-primary btn-block" v-on:click='addToCartAct'>{{ __('Add To Cart') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@isset($restorant)
<div class="modal fade" id="modal-restaurant-info" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalRestaurantTitle"  class="modal-title notranslate">{{ $restorant->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card">
                    <div class="card-header bg-white text-center">
                        <img class="rounded img-center" src="{{ $restorant->icon }}" width="90px" height="90px"></img>
                        <h4 class="heading mt-4">{{ $restorant->name }} &nbsp;@if(count($restorant->ratings))<span><i class="fa fa-star" style="color: #dc3545"></i> <strong>{{ number_format($restorant->averageRating, 1, '.', ',') }} <span class="small">/ 5 ({{ count($restorant->ratings) }})</strong></span></span>@endif</h4>
                        <p class="description">{{ $restorant->description }}</p>
                        @if(!empty($openingTime) && !empty($closingTime))
                            <p class="description">{{ __('Open') }}: {{ $openingTime }} - {{ $closingTime }}</p>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{ __('About') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{ __('Reviews') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="heading-small">{{ __('Phone') }}</h6>
                                        <p class="heading-small text-muted">{{ $restorant->phone }}</p>
                                        <br/>
                                        <h6 class="heading-small">{{ __('Address') }}</h6>
                                        <p class="heading-small text-muted">{{ $restorant->address }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div id="map3" class="form-control form-control-alternative"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                @if(count($restorant->ratings) != 0)
                                    <br/>
                                    <h5>{{ count($restorant->ratings) }} {{ count($restorant->ratings) == 1 ? __('Review') : __('Reviews')}}</h5>
                                    <hr />

                                    @foreach($restorant->ratings as $rating)
                                        <div class="strip">
                                            <span class="res_title"><b>{{ $rating->user->name }}</b></span><span class="float-right"><i class="fa fa-star" style="color: #dc3545"></i> <strong>{{ number_format($rating->rating, 1, '.', ',') }} <span class="small">/ 5</strong></span></span><br />
                                            <span class="text-muted"> {{ $rating->created_at->format(env('DATETIME_DISPLAY_FORMAT','d M Y')) }}</span><br/>
                                            <br/>
                                            <span class="res_description text-muted">{{ $rating->comment }}</span><br />
                                        </div>
                                    @endforeach
                                @else
                                  <p>{{ __('There are no reviews yet.') }}<p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset

<!-- Hours week modal -->

<div class="modal fade bd-example-modal-sm" id="schedule-week" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered " role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="mb-0">{{ __('Opening Hours') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
        <div class='schedule'>
            <ol class='items w-100'>
                @foreach ($wh as $day=>$hours)
                    <li class="@if ($day==$currentDay) today @endif">
                        @if ($day==$currentDay)
                            <div class='day d-flex'>{{ __(ucfirst($day))}}
                                <span class='tag d-flex justify-content-center align-items-center'>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#00bc8b" width="8" id="BeBold" viewBox="0 0 14 14"><path id="Arrow-right-3" class="cls-1" d="M11.612,8.385l-5,5.2A1.608,1.608,0,0,1,3.92,12.389V1.611A1.608,1.608,0,0,1,6.607.419l5.005,5.2A1.87,1.87,0,0,1,11.612,8.385Z"></path></svg>
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
            </div>
        </div>
    </div>
</div>

<style>
    #commentItem {
        width:100%;
        border-radius: 1rem;
        padding: 1rem;
        border: 1px solid #eee;
        resize:none;
        height: 100px;
    }
</style>
