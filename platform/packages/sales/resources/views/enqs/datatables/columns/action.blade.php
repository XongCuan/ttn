<a href="{{ route('sales.customer.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@if (get_auth_admin()->hasLeaderShipRoleSales())
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="customerTable" data-route="{{ route('sales.customer.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endif

