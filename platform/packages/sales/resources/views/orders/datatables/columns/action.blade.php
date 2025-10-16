<button type="button" data-route="{{ route('sales.order.info', $id) }}" class="btn btn-icon btn-info open-modal-form">
    <i class="ti ti-info-circle"></i>
</button>
<a href="{{ route('sales.order.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@if (get_auth_admin()->hasLeaderShipRoleSales())
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="orderTable" data-route="{{ route('sales.order.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endif

