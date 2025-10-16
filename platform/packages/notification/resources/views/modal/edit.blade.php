<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="mb-0">{{ $data->title }}</h1>
            </div>
            <div class="modal-body">
                <div>
                    {!! $data->content !!}
                </div>
            </div>
        </div>
    </div>
</div>