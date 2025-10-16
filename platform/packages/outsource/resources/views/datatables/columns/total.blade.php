<div class="">
    <div>@lang('Dịch vụ:')<strong class="float-end text-warning">{{ number_format($data->sub_total) }}</strong></div>
@if ($data->arises_sum_amount > 0)
    <div>@lang('Phát sinh:')<strong class="float-end text-pink">{{ number_format($data->arises_sum_amount) }}</strong></div>
    <div>@lang('Tổng:')<strong class="float-end text-danger">{{ number_format($data->total) }}</strong></div>
@endif
@if ($data->payments_sum_amount > 0)
    <div>@lang('Đã thanh toán:')<strong class="float-end text-success">{{ number_format($data->payments_sum_amount) }}</strong></div>
@endif
</div>