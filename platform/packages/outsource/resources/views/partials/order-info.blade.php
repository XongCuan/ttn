<div class="card mb-3">
    <div class="card-header">
        <h4 class="mb-0">@lang('Thông tin đơn hàng')</h4>
    </div>
    <div class="card-body">
        <div class="mb-2 ">
            <h4 class="text-secondary mb-1">@lang('Tên đơn hàng')</h4>
            <p class="h4">{{ $order->name }}</p>
        </div>

        <div class="mb-4">
            <h4 class="text-secondary">@lang('Thông tin dịch vụ')</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>@lang('Tên dịch vụ')</th>
                            <th>@lang('Ngày hiệu lực')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->services as $service)
                            <tr>
                                <td>{{ $service->type->description() }}</td>
                                <td>{{ format_date($service->day_begin) }} - {{ format_date($service->day_end) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-4">
            <h4 class="text-secondary">
                @lang('Mức độ ưu tiên')&nbsp; 
                <span @class(["badge text-white", $order->priority->badge()])>{{ $order->priority->description() }}</span>
            </h4>
            
        </div>

        <div>
            <h4 class="text-secondary">@lang('Mô tả')</h4>
            <p class="mb-0">{!! $order->desc !!}</p>
        </div>
    </div>
</div>
