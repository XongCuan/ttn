<div style="white-space: nowrap;">
    <button type="button" data-route="{{ route('accounting.receipt_type.edit', $id) }}"
        class="btn btn-icon btn-warning open-modal-form" data-load-dt="true" data-table-id="receiptType">
        <i class="ti ti-edit"></i>
    </button>
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="receiptType"
        data-route="{{ route('accounting.receipt_type.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
</div>
