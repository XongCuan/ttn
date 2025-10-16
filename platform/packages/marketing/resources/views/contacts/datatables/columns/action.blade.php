<a href="{{ route('marketing.contact.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@if (get_auth_admin()->hasLeaderShipRoleMkt())
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="contactTable" data-route="{{ route('marketing.contact.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endif

