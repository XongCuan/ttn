<!-- Thông tin cơ bản -->
<h1 class="text-center mb-4 fw-bold text-primary">
    @lang('Thống Kê Lương Tháng :month/:year', [
        'month' => request('filter_month') ?? (now()->month == 1 ? 12 : now()->month - 1),
        'year' => request('filter_year') ?? (now()->month == 1 ? now()->year - 1 : now()->year),
    ])
</h1>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title text-uppercase text-muted mb-0">@lang('Lương cơ bản')</h4>
                        <span class="h2 font-weight-bold mb-0">{{ format_price($salary_data['basic_salary']) }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon-circle bg-gradient-primary text-white">
                            <i class="fas fa-money-bill fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title text-uppercase text-muted mb-0">@lang('Ngày làm việc')</h4>
                        <span
                            class="h2 font-weight-bold mb-0">{{ $salary_data['working_days']['actual'] }}/{{ $salary_data['working_days']['total'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon-circle bg-gradient-info text-white">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title text-uppercase text-muted mb-0">@lang('Nghỉ phép')</h4>
                        <span class="h4 font-weight-bold mb-0">
                            <div class="d-flex flex-column">
                                <div class="text-success">@lang('Có lương'):
                                    {{ number_format($salary_data['leave_info']['paid_leave_days'], 1) }}
                                    @lang('ngày')</div>
                                <div class="text-danger">@lang('Không lương'):
                                    {{ number_format($salary_data['leave_info']['unpaid_leave_days'], 1) }}
                                    @lang('ngày')</div>
                            </div>
                        </span>
                    </div>
                    <div class="col-auto">
                        <div class="icon-circle bg-gradient-warning text-white">
                            <i class="fas fa-bed fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title text-uppercase text-muted mb-0">@lang('Tổng lương')</h4>
                        <span
                            class="h2 font-weight-bold mb-0">{{ format_price($salary_data['salary_calculation']['total_salary']) }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon-circle bg-gradient-success text-white">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chi tiết tính lương -->
<div class="row g-4 mb-4">
    <div class="col-12 col-xl-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-calculator me-2"></i>@lang('Chi Tiết Lương')</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>@lang('Lương 1 giờ'):</td>
                                <td class="text-end fw-bold">
                                    {{ format_price($salary_data['salary_rates']['hourly']) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Lương 1 ngày'):</td>
                                <td class="text-end fw-bold">
                                    {{ format_price($salary_data['salary_rates']['daily']) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Tổng ngày làm'):</td>
                                <td class="text-end fw-bold">@lang(':count ngày', ['count' => $salary_data['working_days']['actual']])</td>
                            </tr>
                            <tr class="table-primary">
                                <td>@lang('Tổng lương cơ bản'):</td>
                                <td class="text-end fw-bold">
                                    {{ format_price($salary_data['salary_calculation']['basic_salary']) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Nghỉ phép có lương'):</td>
                                <td class="text-end text-success fw-bold">
                                    @lang(':count ngày', ['count' => number_format($salary_data['leave_info']['paid_leave_days'], 1)])
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('Nghỉ phép không lương'):</td>
                                <td class="text-end text-danger fw-bold">
                                    @lang(':count ngày', ['count' => number_format($salary_data['leave_info']['unpaid_leave_days'], 1)])
                                </td>
                            </tr>
                            <tr class="table-primary">
                                <td>@lang('Tổng bù lương'):</td>
                                <td class="text-end fw-bold">
                                    {{ format_price($salary_data['salary_calculation']['paid_leave_salary']) }}
                            </tr>

                            @if ($is_birthday_month)
                                <tr class="table-success">
                                    <td>@lang('Thưởng sinh nhật'): <small class="fw-bold text-danger">({{ format_date($admin->birthday, 'd/m') }})</small></td>
                                    <td class="text-end fw-bold">{{ format_price(500000) }}</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-clock me-2"></i>@lang('Chi Tiết Tăng Ca (OT)')</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('Loại')</th>
                                <th class="text-center">@lang('Hệ số')</th>
                                <th class="text-center">@lang('Số giờ')</th>
                                <th class="text-end">@lang('Thành tiền')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salary_data['overtime'] as $overtime)
                                <tr>
                                    <td>{{ $overtime['type'] }}</td>
                                    <td class="text-center">{{ $overtime['rate'] }}</td>
                                    <td class="text-center">{{ $overtime['hours'] }}</td>
                                    <td class="text-end">{{ format_price($overtime['amount']) }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-success">
                                <td colspan="3" class="fw-bold">@lang('Tổng lương OT'):</td>
                                <td class="text-end fw-bold">
                                    {{ format_price($salary_data['salary_calculation']['overtime_salary']) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">@lang('TỔNG THU NHẬP')</h4>
                        <small>@lang('Đã bao gồm lương cơ bản và OT')</small>
                    </div>
                    <div class="col-auto">
                        <h2 class="mb-0">
                            {{ format_price($salary_data['salary_calculation']['total_salary']) }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
