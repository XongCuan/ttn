<div class="row row-deck row-cards">

    <div class="col-sm-6 col-lg-3">
        <a href="{{ route('marketing.contact.index') }}" class="card card-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column mb-3">
                    <div class="fs-4 text-muted fw-bold">@lang('Data quan tâm')</div>
                    <div class="fs-1 fw-bold text">{{ $total_contact['total'] }}</div>
                </div>
                <div class="d-flex">
                    @if (request()->enum('type', App\Enums\Customer\CustomerType::class) == App\Enums\Customer\CustomerType::New)
                        <div class="">
                            <div class="badge bg-green-lt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('Mục tiêu')">
                                <i class="ti ti-target-arrow me-1"></i>
                                @if($total_contact['kpi_target'] > 0)
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        {{ $total_contact['kpi_target'] }}% 
                                        <i class="ti ti-trending-up"></i>
                                    </span>
                                @elseif ($total_contact['kpi_target'] < 0)
                                    <span class="text-danger d-inline-flex align-items-center lh-1">
                                        {{ - $total_contact['kpi_target'] }}% 
                                        <i class="ti ti-trending-down"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="ms-auto">
                        <div class="badge bg-green-lt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('Cùng kỳ tháng trước')">
                            <i class="ti ti-calendar-month me-1"></i>
                            @if($total_contact['same_period'] > 0)
                                <span class="text-green d-inline-flex align-items-center lh-1">
                                    {{ $total_contact['same_period'] }}% 
                                    <i class="ti ti-trending-up"></i>
                                </span>
                            @elseif ($total_contact['same_period'] < 0)
                                <span class="text-danger d-inline-flex align-items-center lh-1">
                                    {{ - $total_contact['same_period'] }}% 
                                    <i class="ti ti-trending-down"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column mb-3">
                    <div class="fs-4 text-muted fw-bold">@lang('Doanh thu')</div>
                    <div class="fs-1 fw-bold text">{{ format_price($total_revenue['total']) }}</div>
                </div>
                <div class="d-flex">
                    <div class="ms-auto">
                        <div class="badge bg-green-lt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('Cùng kỳ tháng trước')">
                            <i class="ti ti-calendar-month me-1"></i>
                            @if($total_revenue['same_period'] > 0)
                                <span class="text-green d-inline-flex align-items-center lh-1">
                                    {{ $total_revenue['same_period'] }}% 
                                    <i class="ti ti-trending-up"></i>
                                </span>
                            @elseif ($total_revenue['same_period'] < 0)
                                <span class="text-danger d-inline-flex align-items-center lh-1">
                                    {{ - $total_revenue['same_period'] }}% 
                                    <i class="ti ti-trending-down"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column mb-3">
                    <div class="fs-4 text-muted fw-bold">@lang('Đơn hàng')</div>
                    <div class="fs-1 fw-bold text">{{ $total_order['total'] }}</div>
                </div>
                <div class="d-flex">
                    <div class="ms-auto">
                        <div class="badge bg-green-lt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('Cùng kỳ tháng trước')">
                            <i class="ti ti-calendar-month me-1"></i>
                            @if($total_order['same_period'] > 0)
                                <span class="text-green d-inline-flex align-items-center lh-1">
                                    {{ $total_order['same_period'] }}% 
                                    <i class="ti ti-trending-up"></i>
                                </span>
                            @elseif ($total_order['same_period'] < 0)
                                <span class="text-danger d-inline-flex align-items-center lh-1">
                                    {{ - $total_order['same_period'] }}% 
                                    <i class="ti ti-trending-down"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column mb-3">
                    <div class="fs-4 text-muted fw-bold">@lang('Tỉ lệ chuyển đổi')</div>
                    <div class="fs-1 fw-bold text">{{ $conversion_rate['total'] }}</div>
                </div>
                <div class="d-flex">
                    <div class="ms-auto">
                        <div class="badge bg-green-lt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('Cùng kỳ tháng trước')">
                            <i class="ti ti-calendar-month me-1"></i>
                            @if($conversion_rate['same_period'] > 0)
                                <span class="text-green d-inline-flex align-items-center lh-1">
                                    {{ $conversion_rate['same_period'] }}% 
                                    <i class="ti ti-trending-up"></i>
                                </span>
                            @elseif ($conversion_rate['same_period'] < 0)
                                <span class="text-danger d-inline-flex align-items-center lh-1">
                                    {{ - $conversion_rate['same_period'] }}% 
                                    <i class="ti ti-trending-down"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
