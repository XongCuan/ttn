<a href="{{ route('superadmin.admin.salary', $id) }}" class="btn btn-icon btn-info" data-bs-toggle=tooltip
    data-bs-placement="bottom" title="@lang('Tính lương')">
    <i class="ti ti-currency-dollar"></i>
</a>


<a href="{{ route('superadmin.admin.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>

<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="packages_superadmin"
    data-route="{{ route('superadmin.admin.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>


<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    })
</script>
