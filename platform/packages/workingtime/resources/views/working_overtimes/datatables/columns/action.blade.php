
<a href="{{ route('working_overtime.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>

<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="workingOvertimeTable" data-route="{{ route('working_overtime.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
