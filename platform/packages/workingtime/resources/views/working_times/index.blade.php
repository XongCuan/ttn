@extends('themes_cms::layouts.datatable')

@push('css')
    <style>
        .insufficient-hours {
            background-color: #fee2e2 !important;
            color: #7f1d1d;
        }

    </style>
@endpush

@section('datatable')
@if (get_auth_admin()->isRoleManager())
    <div class="d-flex gap-2 mb-3">
        <div class="">
            <a href="{{ route('working_time.index') }}" @class(['btn btn-outline-primary', 'active' => request()->routeIs('working_time.index')])>@lang('Của tôi')</a>
        </div>
        <div class="">
            <a href="{{ route('working_time.index_employee') }}" @class(['btn btn-outline-primary', 'active' => request()->routeIs('working_time.index_employee')])>@lang('Nhân viên')</a>
        </div>
    </div>
@endif
    <div class="card">
        <div class="card-header justify-content-between">
            <h2 class="mb-0">@lang('Danh sách')</h2>
            <div class="col-auto">
                <div class="card-header-action">
                    <div class="modal-button-container d-flex justify-content-end gap-1">
                        @if (get_auth_admin()->isSuperadmin())
                            <a href="{{ route('working_time.create') }}" class="btn btn-primary">
                                <i class="icon ti ti-plus"></i>
                                <span>@lang('Thêm')</span>
                            </a>
                        @elseif(request()->routeIs('working_time.index'))
                            @if (get_auth_admin()->canCheckin())
                                <x-core_base::form class="form-checkin" :action="route('working_time.checkin')" data-load-dt="true"
                                    data-table-id="workingtimeTable" type="post">
                                    <button class="btn btn-primary">
                                        <i class="icon ti ti-calendar-check"></i>
                                        <span>@lang('Check in')</span>
                                    </button>
                                </x-core_base::form>
                            @elseif (get_auth_admin()->canCheckout())
                                <x-core_base::form :action="route('working_time.checkout')" class="form-checkout" data-load-dt="true"
                                    data-table-id="workingtimeTable" type="put">
                                    <button class="btn btn-warning">
                                        <i class="icon ti ti-calendar-check"></i>
                                        <span>@lang('Check out')</span>
                                    </button>
                                </x-core_base::form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="row justify-content-end mb-3">
                <div class="col-md-6">
                    @include('themes_cms::common.datatable-filter')
                </div>
            </div>
            <div class="table-responsive position-relative">
                @include('core_datatable::common.toggle_column.show')
                {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
            </div>
        </div>
    </div>
@endsection


@push('js')
    @includeWhen(
        (get_auth_admin()->canCheckin() || get_auth_admin()->canCheckout()) &&
            get_auth_admin()->canWorkRemoteToday() == false,
        'packages_workingtime::.working_times.scripts.location')
@endpush
