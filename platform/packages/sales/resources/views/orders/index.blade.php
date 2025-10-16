@extends('themes_cms::layouts.datatable')

@section('datatable')

<div class="card">
    <div class="card-header justify-content-between">
        <h2 class="mb-0">@lang('Danh sách')</h2>
        @if (auth('admin')->user()->hasLeaderShipRoleSales())
            <a class="btn btn-primary" href="{{ route('sales.order.create') }}">
                <i class="ti ti-plus icon"></i>
                <span>@lang('Thêm')</span>
            </a>
        @endif
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
