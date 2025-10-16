<tr class="item-serv">
    <td>
        <button type="button" class="btn btn-sm btn-icon btn-danger btn-delete-item-serv">
            <i class="ti ti-trash"></i>
        </button>
        <x-core_base::input type="hidden" name="service[{{$uniqid}}][type]" value="{{ $service_type->value }}" />
        <x-core_base::input type="hidden" class="serv-amount" name="service[{{$uniqid}}][amount]" value="{{ string_to_integer($service_data['amount']) }}" />
        <x-core_base::input type="hidden" name="service[{{$uniqid}}][day_begin]" value="{{ $service_data['day_begin'] }}" />
        <x-core_base::input type="hidden" name="service[{{$uniqid}}][day_end]" value="{{ $service_data['day_end'] }}" />
        <textarea class="d-none" name="service[{{$uniqid}}][desc]">{{ $service_data['desc'] }}</textarea>
    </td>
    <td>{{ $service_type->description() }}</td>
    <td>{{ format_date($service_data['day_begin']) }} - {{ format_date($service_data['day_end']) }}</td>
    <td class="text-end">{{ $service_data['amount'] }}</td>
</tr>