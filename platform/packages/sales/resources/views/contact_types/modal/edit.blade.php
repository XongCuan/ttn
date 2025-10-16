<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('sales.contact_type.update')" type="put" :validate="true" data-load-dt="true" data-table-id="contactTypeTable">
                <x-core_base::input type="hidden" name="id" :value="$data->id" />
                <div class="modal-header">
                    <div class="modal-title">@lang('Sửa')</div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Tên'):</label>
                        <x-core_base::input name="name" :value="$data->name" :required="true" :placeholder="trans('Tên loại')" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Ghi chú'):</label>
                        <textarea name="note" class="form-control">{{ $data->note }}</textarea>
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