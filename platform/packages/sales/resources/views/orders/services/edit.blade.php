<div class="col-12 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="fw-bold">@lang('Dịch vụ')</div>
        </div>
        <div class="card-body">
            <table id="listService" class="table table-transparent table-responsive mb-0">
                <thead>
                    <tr>
                        <th class="" style="width: 100px">@lang('Hành động')</th>
                        <th style="width: 30%">@lang('Tên dịch vụ')</th>
                        <th style="width: 25%" class="">@lang('Ngày hiệu lực')</th>
                        <th style="width: 30%" class="text-end">@lang('Số tiền')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->services as $service)
                        @include('packages_sales::orders.services.edit.item-table')
                    @endforeach
                    <tr class="norecord" style="display: none">
                        <td class="text-muted text-center" colspan="4">@lang('Chưa có dịch vụ')</td>
                    </tr>
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
                        <td colspan="2" class="fw-bold text-end text-uppercase align-middle">@lang('Tổng cộng')</td>
                        <td class="text-end fs-1 align-middle text-danger sub-total-bill" colspan="2">{{ number_format($order->sub_total) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('packages_sales::orders.scripts.create-service')