
<a href="{{ route('working_time.edit', $working_time->id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>

<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="workingtimeTable" data-route="{{ route('working_time.delete', $working_time->id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
