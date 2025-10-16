<div style="white-space: nowrap;">
    <button type="button" data-route="{{ route('superadmin.document_type.edit', $id) }}"
        class="btn btn-icon btn-warning open-modal-form" data-load-dt="true" data-table-id="documentType">
        <i class="ti ti-edit"></i>
    </button>
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="documentType"
        data-route="{{ route('superadmin.document_type.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
</div>
