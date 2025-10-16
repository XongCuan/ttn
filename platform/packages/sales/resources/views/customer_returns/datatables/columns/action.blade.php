
<button type="button" data-route="{{ route('sales.customer_return.edit', $data->id) }}" class="btn btn-icon btn-warning open-modal-form">
    <i class="ti ti-edit"></i>
</button>
@if (get_auth_admin()->hasLeaderShipRoleSales())
    @if ($data->isMakeOrder())
        <a class="btn btn-icon btn-success" href="{{ route('sales.order.create', ['customer_return_id' => $data->id]) }}">
            <i class="ti ti-shopping-cart-plus"></i>
        </a>
    @endif
    
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="customerTable" data-route="{{ route('sales.customer_return.delete', $data->id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endif

