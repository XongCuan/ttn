
<button type="button" data-route="{{ route('sales.range_price.edit', $id) }}" class="btn btn-icon btn-warning open-modal-form" data-load-dt="true" data-table-id="rangePriceTable">
    <i class="ti ti-edit"></i>
</button>

<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="rangePriceTable" data-route="{{ route('sales.range_price.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
