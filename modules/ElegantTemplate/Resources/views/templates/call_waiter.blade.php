<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent pb-2">
                        <h4 class="text-center mt-2 mb-3">{{ __('Call Waiter') }}</h4>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('call.waiter') }}">
                            @csrf
                            @include('partials.fields',$fields)
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Call Now') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>