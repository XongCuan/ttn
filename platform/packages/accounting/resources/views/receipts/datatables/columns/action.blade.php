<div style="white-space: nowrap;">
    <button type="button" data-route="{{ route('accounting.receipt.show', $id) }}"
        class="btn btn-icon btn-success open-modal-form" data-load-dt="true" data-table-id="receipt">
        <i class="ti ti-eye"></i>
    </button>
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="receipt"
        data-route="{{ route('accounting.receipt.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
</div>
