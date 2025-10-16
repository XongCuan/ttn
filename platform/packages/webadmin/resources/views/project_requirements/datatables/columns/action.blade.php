<div style="white-space: nowrap;">
    <button type="button" data-route="{{ route('webadmin.project_requirement.change_status', $id) }}"
        class="btn btn-icon btn-info open-modal-form" data-load-dt="true" data-table-id="projectTable">
        <i class="ti ti-progress"></i>
    </button>

    {{-- <button type="button" data-route="{{ route('webadmin.project_requirement.show', $id) }}"
        class="btn btn-icon btn-success open-modal-form" data-load-dt="true" data-table-id="projectTable">
        <i class="ti ti-eye"></i>
    </button> --}}

    
        <a href="{{ route('webadmin.project_requirement.edit', $id) }}" class="btn btn-icon btn-warning">
            <i class="ti ti-edit"></i>
        </a>
    @if (get_auth_admin()->hasLeaderShipRoleWebadmin())
        <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="projectTable"
            data-route="{{ route('webadmin.project_requirement.delete', $id) }}" data-target="#modalAjaxDelete">
            <i class="ti ti-trash"></i>
        </button>
    @endif
</div>
