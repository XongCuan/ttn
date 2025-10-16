<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('sales.customer_return.store')" type="post" :validate="true" data-load-dt="true" data-table-id="customerReturnTable">
                <div class="modal-header">
                    <div class="modal-title">@lang('Thêm')</div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Tên'):</label>
                        <x-core_base::select class="select2-bs5-ajax-many" name="customer_id" :required="true" :data-url="route('sales.select_customer')"></x-core_base::select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Ghi chú'):</label>
                        <textarea name="note" class="form-control"></textarea>
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