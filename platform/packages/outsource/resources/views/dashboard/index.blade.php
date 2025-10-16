@extends('themes_cms::layouts.master')

@section('content')
<div class="page-body">
    <div class="container-xl">
        @include('packages_outsource::dashboard.partials.filter')
        @include('packages_outsource::dashboard.partials.total')

        <div class="row mt-3">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">@lang('Danh sách thống kê')</h3>
                        <table class="table card-table table-vcenter">
                            <thead>
                                <tr>
                                    <th>@lang('Họ và tên')</th>
                                    <th>@lang('Tổng')</th>
                                    <th>@lang('Trễ')</th>
                                    <th>@lang('Hoàn thành')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->fullname }}</td>
                                        <td>{{ $employee->total_p }}</td>
                                        <td>
                                            <div class="progressbg">
                                                <div class="progress progressbg-progress">
                                                  <div class="progress-bar bg-red bg-primary-lt" style="width: {{ $employee->percent_p_late }}%"></div>
                                                </div>
                                                <div class="progressbg-text">@lang('Số lượng'): {{ $employee->count_p_late }}</div>
                                                <div class="progressbg-value position-relative z-1">{{ $employee->percent_p_late }}%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progressbg">
                                                <div class="progress progressbg-progress">
                                                  <div class="progress-bar bg-green bg-primary-lt" style="width: {{ $employee->percent_p_done }}%"></div>
                                                </div>
                                                <div class="progressbg-text">@lang('Số lượng'): {{ $employee->count_p_done }}</div>
                                                <div class="progressbg-value position-relative z-1">{{ $employee->percent_p_done }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection