<tr class="item-pay">
    <td>
        <button type="button" class="btn btn-sm btn-icon btn-danger btn-delete-item-pay">
            <i class="ti ti-trash"></i>
        </button>
        <x-core_base::input type="hidden" name="payment[{{$uniqid}}][name]" value="{{ $payment_data['name'] }}" />
        <x-core_base::input type="hidden" class="pay-amount" name="payment[{{$uniqid}}][amount]" value="{{ string_to_integer($payment_data['amount']) }}" />
        <textarea name="payment[{{$uniqid}}][desc]" class="d-none">{{ $payment_data['desc'] }}</textarea>
    </td>
    <td>{{ $payment_data['name'] }}</td>
    <td class="text-end">{{ $payment_data['amount'] }}</td>
</tr>