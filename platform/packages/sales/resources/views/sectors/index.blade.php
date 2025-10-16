@extends('themes_cms::layouts.datatable')

@section('datatable')

<div class="card">
    <div class="card-header justify-content-between">
        <h2 class="mb-0">@lang('Danh sách')</h2>
        <button type="button" class="btn btn-primary open-modal-form" data-route="{{ route('sales.sector.create') }}">
            <i class="ti ti-plus icon"></i>
            <span>@lang('Thêm')</span>
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive position-relative">
            @include('core_datatable::common.toggle_column.show')
            {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
        </div>
    </div>
</div>

@endsection
