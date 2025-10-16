<tr class="item-pay">
    <td>
        <div class="d-flex gap-1">
            <button type="button" class="btn btn-sm btn-icon btn-info open-modal-form" data-route="{{ route('sales.order_payment.show', $payment->id) }}">
                <i class="ti ti-eye"></i>
            </button>
            @if (get_auth_admin()->hasLeaderShipRoleSales())
                <button type="button" class="btn btn-sm btn-icon btn-warning open-modal-form" data-route="{{ route('sales.order_payment.edit', $payment->id) }}">
                    <i class="ti ti-edit"></i>
                </button>
            @endif
        </div>
    </td>
    <td>{{ format_datetime($payment->created_at) }}</td>
    <td>{{ $payment->name }}</td>
    <td class="text-end">{{ number_format($payment->amount) }}</td>
</tr>