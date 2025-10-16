<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    @lang('Thông tin dịch vụ')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="" class="form-label">@lang('Tên dịch vụ')</label>
                        <x-core_base::input name="type" :value="$service->type->description()" readonly />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="" class="form-label">@lang('Số tiền')</label>
                        <x-core_base::input name="amount" :value="number_format($service->amount)" readonly />
                    </div>
                    @if ($service->day_begin)
                        <div class="col-12 col-md-6 mb-3">
                            <label for="" class="form-label">@lang('Ngày bắt đầu')</label>
                            <x-core_base::input name="amount" :value="format_date($service->day_begin)" readonly />
                        </div>
                    @endif
                    @if ($service->day_end)
                        <div class="col-12 col-md-6 mb-3">
                            <label for="" class="form-label">@lang('Ngày kết thúc')</label>
                            <x-core_base::input name="amount" :value="format_date($service->day_end)" readonly />
                        </div>
                    @endif
                    <div class="col-12">
                        <label for="" class="form-label">@lang('Mô tả')</label>
                        {!! $service->desc !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Đóng')</button>
            </div>
        </div>
    </div>
</div>
