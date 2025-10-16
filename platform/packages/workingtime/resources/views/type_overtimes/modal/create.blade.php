<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('type_overtime.store')" type="post" :validate="true" data-load-dt="true" data-table-id="typeOvertimeTable">
                <div class="modal-header">
                    <div class="modal-title">@lang('Thêm')</div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Loại OT'):</label>
                        <x-core_base::input name="name" :required="true" :placeholder="trans('Loại OT')" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Giá trị'):</label>
                        <x-core_base::input.number name="value" :required="true" :placeholder="trans('Giá trị')" />
                        <small class="form-hint">
                            @lang('Ví dụ: 1.5, 2, ...')
                          </small>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">@lang('Hủy')</button>
                    <button type="submit" class="btn btn-primary">
                        @lang('Thêm')
                    </button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>