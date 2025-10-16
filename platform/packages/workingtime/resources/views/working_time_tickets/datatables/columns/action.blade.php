
@if(working_time_ticket_service()->isStatusPending($data))

    @if ((get_auth_admin()->isRoleManager() || get_auth_admin()->isSuperadmin()) && get_auth_admin()->id != $data->admin_id)
        <button type="button" data-route="{{ route('workingtime_ticket.confirm', $data->id) }}" class="btn btn-icon btn-success open-modal-form" data-load-dt="true" data-table-id="workingtimeTicket">
            <i class="ti ti-check"></i>
        </button>
    @endif
    <button type="button" data-route="{{ route('workingtime_ticket.edit', $data->id) }}" class="btn btn-icon btn-warning open-modal-form" data-load-dt="true" data-table-id="workingtimeTicket">
        <i class="ti ti-edit"></i>
    </button>

    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="workingtimeTicket" data-route="{{ route('workingtime_ticket.delete', $data->id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@else
<button type="button" data-route="{{ route('workingtime_ticket.show', $data->id) }}" class="btn btn-icon btn-info open-modal-form">
    <i class="ti ti-eye"></i>
</button>
@endif
