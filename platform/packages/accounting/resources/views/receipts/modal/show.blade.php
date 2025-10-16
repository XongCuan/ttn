<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">@lang('Chi tiết')</div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 col-12 col-md-4">
                        <label for="" class="form-label">@lang('Loại'):</label>
                        <x-core_base::input name="receipt_date" :value="$data->type->name" readonly />
                    </div>
                    <div class="mb-3 col-12 col-md-4">
                        <label for="" class="form-label">@lang('Ngày'):</label>
                        <x-core_base::input name="receipt_date" :value="format_date($data->receipt_date)" readonly />
                    </div>
                    <div class="mb-3 col-12 col-md-4">
                        <label for="" class="form-label">@lang('Số tiền'):</label>
                        <x-core_base::input class="inp-number-format" name="amount" :value="format_price($data->amount)" readonly />
                    </div>
                    <div class="mb-3 col-12">
                        <label for="" class="form-label">@lang('Mô tả'):</label>
                        <textarea name="desc" class="form-control" readonly>{{ $data->desc }}</textarea>
                    </div>
    
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Chứng từ'):</label>
                        <div class="row">
                            @if ($data->attachments)
                                @foreach ($data->attachments as $attachment)
                                    <div class="col-12 col-md-6">
                                        <img src="{{ asset($attachment) }}" alt="" class="w-100">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">@lang('Hủy')</button>
            </div>
        </div>
    </div>
</div>