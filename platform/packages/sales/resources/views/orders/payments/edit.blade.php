@php
    $is_add = isset($is_add) ? $is_add : true; 
@endphp
<div class="col-12 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="fw-bold">@lang('Thông tin thanh toán')</div>
            @if (get_auth_admin()->hasLeaderShipRoleSales() && $is_add)
                <div class="w-75 text-end">
                    <button type="button" class="btn btn-sm btn-primary open-modal-form" 
                    data-route="{{ route('sales.order_payment.create', $order->id) }}"
                >
                    <i class="ti ti-plus"></i>
                    @lang('Thêm')
                </button>
                </div>
            @endif
        </div>
        <div class="card-body">
            <table id="listPayment" class="table table-transparent table-responsive mb-0">
                <thead>
                    <tr>
                        <th class="" style="width: 100px">@lang('Hành động')</th>
                        <th>@lang('Thời gian')</th>
                        <th>@lang('Tên thanh toán')</th>
                        <th class="text-end">@lang('Số tiền')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->payments as $payment)
                        @include('packages_sales::orders.payments.edit.item-table')

                    @empty
                        <tr class="norecord">
                            <td class="text-muted text-center" colspan="4">@lang('Chưa có thông tin')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <table class="table table-transparent table-responsive mb-0">
                <thead class="d-none">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" class="fw-bold text-end text-uppercase align-middle">@lang('Tổng đơn hàng')</td>
                        <td class="text-end fs-1 align-middle text-blue total-bill" colspan="2">{{ number_format($order->total) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="fw-bold text-end text-uppercase align-middle">@lang('Tổng thanh toán')</td>
                        <td class="text-end fs-1 align-middle text-success total-payment" colspan="2">{{ number_format($order->payments->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="fw-bold text-end text-uppercase align-middle">@lang('Tổng còn lại')</td>
                        <td class="text-end fs-1 align-middle text-danger total-not-payment" colspan="2">{{ number_format($order->unpaidBalance()) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')

<script>


$(document).on('click', '.btn-delete-item-pay', function(e) {
    e.preventDefault();

    const parent = $(this).parents('tr');

    parent.remove();
    
    if ($("#listPayment tbody tr.item-pay").length == 0)
    {
        $("#listPayment tbody tr.norecord").show();
    }
});

$(document).on('submit', '.ajax-modal-form-add-payment', function(e) {
    e.preventDefault();
    resetAjaxFormLibrary();
    AjaxFormLibrary.target = $(this);

    AjaxFormLibrary.beforeSuccess = function(response) {
        location.reload();
    }

    AjaxFormLibrary.ajaxRequest();
})
</script>

@endpush