<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">@lang('Chi tiết')</div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">@lang('Loại'):</label>
                        <x-core_base::input name="receipt_date" :value="$data->type->name" readonly />
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">@lang('Ngày'):</label>
                        <x-core_base::input name="receipt_date" :value="format_date($data->receipt_date)" readonly />
                    </div>
                    <div class="mb-3 col-12">
                        <label for="" class="form-label">@lang('Mô tả'):</label>
                        <textarea name="desc" class="form-control" readonly>{{ $data->desc }}</textarea>
                    </div>
    
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('File'):</label>
                        <div class="row">
                            @if ($data->attachments)
                                @foreach ($data->attachments as $attachment)
                                    <div class="col-12 col-md-3">
                                        <div class="d-flex flex-column gap-1 justify-content-center">
                                            <div class="text-center">
                                                <i class="ti ti-file" style="font-size: 60px"></i>
                                            </div>
                                            <div class="text-center">
                                                <a href="{{ asset($attachment) }}" target="_blank">{{ str($attachment)->afterLast('/') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">@lang('Đóng')</button>
            </div>
        </div>
    </div>
</div>