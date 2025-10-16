<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <x-core_base::form action="{{ route('sales.order_service.update') }}" type="put" :validate="true">
                <x-core_base::input type="hidden" name="id" :value="$service->id" />
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
                            <x-core_base::input name="amount" class="inp-number-format" :value="number_format($service->amount)" :required="true" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="" class="form-label">@lang('Ngày bắt đầu')</label>
                            <x-core_base::input type="date" name="day_begin" :value="$service->day_begin" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="" class="form-label">@lang('Ngày kết thúc')</label>
                            <x-core_base::input type="date" name="day_end" :value="$service->day_end" />
                        </div>
                        <div class="col-12">
                            <label for="" class="form-label">@lang('Mô tả')</label>
                            <textarea name="desc" class="ckeditor visually-hidden">{!! $service->desc !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Đóng')</button>
                    <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>
