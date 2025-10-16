
<button type="button" data-route="{{ route('sales.contact_type.edit', $id) }}" class="btn btn-icon btn-warning open-modal-form" data-load-dt="true" data-table-id="contactTypeTable">
    <i class="ti ti-edit"></i>
</button>

<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="contactTypeTable" data-route="{{ route('sales.contact_type.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
