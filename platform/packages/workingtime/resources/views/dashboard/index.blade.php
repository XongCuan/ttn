@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">@lang('Danh sách')</h2>
                    <div class="col-12 col-md-6">
                        <x-core_base::form class="block-double-click" :action="route('working_time.dashboard')" :validate="true">
                            <div class="input-group">
                                @if (get_auth_admin()->isSuperadmin())
                                    <x-core_base::select name="department">
                                        <x-core_base::select.option value="" :title="trans('Chọn phòng ban')" />
                                        @foreach ($departments as $key => $value)
                                            <x-core_base::select.option :selected="(int) request('department')" :value="$key" :title="$value" />
                                        @endforeach
                                    </x-core_base::select>
                                @endif
                                <x-core_base::select name="month">
                                    <x-core_base::select.option value="" :title="trans('Chọn tháng')" />
                                    @for ($month = 1; $month <= 12; $month++)
                                        <x-core_base::select.option :selected="request('month')" :value="str_pad($month, 2, '0', STR_PAD_LEFT)" :title="trans('Tháng :value', ['value' => $month])" />
                                    @endfor
                                </x-core_base::select>
                                <x-core_base::select name="year">
                                    <x-core_base::select.option value="" :title="trans('Chọn năm')" />
                                    @foreach ($list_years as $year)
                                        <x-core_base::select.option :selected="(int) request('year')" :value="$year" :title="trans('Năm :value', ['value' => $year])" />
                                    @endforeach
                                </x-core_base::select>
                                <button type="submit" class="btn btn-primary btn-action-filter" name="submitter" value="filter">@lang('Lọc')</button>
                                <button type="submit" class="btn btn-success btn-action-filter" name="submitter" value="exportExcel">@lang('Xuất excel')</button>
                            </div>
                            
                        </x-core_base::form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-vcenter table-striped">
                        <thead>
                            <tr>
                                <th>@lang('STT')</th>
                                <th>@lang('Phòng ban')</th>
                                <th>@lang('Tên NV')</th>
                                <th>@lang('Số ngày công')</th>
                                <th>@lang('Off có phép')</th>
                                <th>@lang('Off không phép')</th>
                                <th>@lang('OT(giờ)')</th>
                                <th>@lang('Thiếu giờ (lần)')</th>
                                <th>@lang('Thiếu giờ (ngày)')</th>
                                <th>@lang('Đi trễ (lần)')</th>
                                <th>@lang('Đi trễ (ngày)')</th>
                                <th>@lang('Tổng vi phạm (lần)')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistic as $item)
                                @php
                                    $offAnual = $item->countAnnualLeave();
                                    $off = $item->countUnpaidLeave();
                                    $dateNotEnough = $item->dateNotEnoughHours();
                                    $late = $item->dateLate();
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{!! $item->admin->getDepartmentBadge() !!}</td>
                                    <td>{{ $item->admin->fullname }}</td>
                                    <td>{{ $item->countRequestAddToWorkingTIme() + $item->countPassDate() }}</td>
                                    <td>{{ $offAnual }}</td>
                                    <td>{{ $off }}</td>
                                    <td></td>
                                    <td>{{ count($dateNotEnough) }}</td>
                                    <td>{{ implode(', ', $dateNotEnough) }}</td>
                                    <td>{{ count($late) }}</td>
                                    <td>{{ implode(', ', $late) }}</td>
                                    <td>{{ count($dateNotEnough) + count($late) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
@endsection

@push('js')

@endpush
