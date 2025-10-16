<tr class="item-serv">
    <td>
        <div class="d-flex gap-1">
            <button type="button" class="btn btn-sm btn-icon btn-info open-modal-form" data-route="{{ route('sales.order_service.show', $service->id) }}">
                <i class="ti ti-eye"></i>
            </button>
            @if (get_auth_admin()->hasLeaderShipRoleSales())
                <button type="button" class="btn btn-sm btn-icon btn-warning open-modal-form" data-route="{{ route('sales.order_service.edit', $service->id) }}">
                    <i class="ti ti-edit"></i>
                </button>
            @endif
        </div>
        {{-- <button type="button" class="btn btn-sm btn-icon btn-danger btn-delete-item-serv">
            <i class="ti ti-trash"></i>
        </button> --}}
    </td>
    <td>{{ $service->type->description() }}</td>
    <td>{{ format_date($service->day_begin) }} - {{ format_date($service->day_end) }}</td>
    <td class="text-end">{{ number_format($service->amount) }}</td>
</tr>