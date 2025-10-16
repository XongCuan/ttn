<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('sales.range_price.update')" type="put" :validate="true" data-load-dt="true" data-table-id="rangePriceTable">
                <x-core_base::input type="hidden" name="id" :value="$data->id" />
                <div class="modal-header">
                    <div class="modal-title">@lang('Sửa')</div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Tên'):</label>
                        <x-core_base::input name="name" :value="$data->name" :required="true" :placeholder="trans('Tên lĩnh vực')" />
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label for="" class="form-label">@lang('Giá từ'):</label>
                            <x-core_base::input class="inp-number-format" :value="number_format($data->min_price)" name="min_price" :required="true" :placeholder="trans('Giá bắt đầu từ VD: 100,000')" />
                        </div>
                        <div class="w-50">
                            <label for="" class="form-label">@lang('Đến giá'):</label>
                            <x-core_base::input class="inp-number-format" name="max_price" :value="number_format($data->max_price)" :required="true" :placeholder="trans('Đến giá VD: 100,000')" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">@lang('Hủy')</button>
                    <button type="submit" class="btn btn-primary">
                        @lang('Cập nhật')
                    </button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>