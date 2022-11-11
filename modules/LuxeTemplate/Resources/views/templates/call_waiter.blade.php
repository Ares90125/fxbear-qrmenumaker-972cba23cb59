
<div class="modal fade bd-example-modal-sm" id="modal-form" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered " role="document">
        <form role="form" method="post" action="{{ route('call.waiter') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="mb-0">{{ __('Call Waiter') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center py-4">
                    @include('partials.fields',$fields)
                </div>
                <div class="modal-footer">
                    <div class="footer-area">
                        <div class="quantity-btn btn-block">
                            <div>
                                <button class="btn btn-block justify-content-center" type="submit">{{ __('Call Now') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>