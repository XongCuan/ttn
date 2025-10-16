<div style="white-space: nowrap;">
    <button type="button" data-route="{{ route('internal.project.change_status', $id) }}"
        class="btn btn-icon btn-info open-modal-form" data-load-dt="true" data-table-id="projectTable">
        <i class="ti ti-progress"></i>
    </button>

    <button type="button" data-route="{{ route('internal.project.show', $id) }}"
        class="btn btn-icon btn-success open-modal-form" data-load-dt="true" data-table-id="projectTable">
        <i class="ti ti-eye"></i>
    </button>

    @if (get_auth_admin()->hasManagerShipRoleInternal())
        <a href="{{ route('internal.project.edit', $id) }}" class="btn btn-icon btn-warning">
            <i class="ti ti-edit"></i>
        </a>
        <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="projectTable"
            data-route="{{ route('internal.project.delete', $id) }}" data-target="#modalAjaxDelete">
            <i class="ti ti-trash"></i>
        </button>
    @endif
</div>
