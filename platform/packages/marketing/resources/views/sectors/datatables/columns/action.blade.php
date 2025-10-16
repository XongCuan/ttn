
<button type="button" data-route="{{ route('marketing.sector.edit', $id) }}" class="btn btn-icon btn-warning open-modal-form" data-load-dt="true" data-table-id="sectorTable">
    <i class="ti ti-edit"></i>
</button>

<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="sectorTable" data-route="{{ route('marketing.sector.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
