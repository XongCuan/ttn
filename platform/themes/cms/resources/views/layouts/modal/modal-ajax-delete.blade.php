<div class="modal modal-blur fade" id="modalAjaxDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">@lang('Bạn có chắc?')</div>
                <div>@lang('Nếu bạn tiếp tục, dữ liệu sẽ được xóa khỏi hệ thống.')</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">@lang('Hủy')</button>
                <x-core_base::form class="ajax-modal-form" action="#" type="delete">
                    <button type="submit" class="btn btn-danger btn-icon"><i class="ti ti-trash"></i></button>
                </x-core_base::form>
            </div>
        </div>
    </div>
</div>