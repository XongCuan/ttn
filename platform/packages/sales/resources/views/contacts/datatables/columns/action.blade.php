<button type="button" data-route="{{ route('sales.contact.activity.index', $data->id) }}" class="btn btn-icon btn-info open-modal-form">
    <i class="ti ti-history"></i>
</button>
<a href="{{ route('sales.contact.edit', $data->id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@if (get_auth_admin()->hasLeaderShipRoleSales())
    @if ($data->isMakeOrder())
        <a class="btn btn-icon btn-success" href="{{ route('sales.order.create', ['contact_id' => $data->id]) }}">
            <i class="ti ti-shopping-cart-plus"></i>
        </a>
    @endif
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="contactTable" data-route="{{ route('sales.contact.delete', $data->id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endif

