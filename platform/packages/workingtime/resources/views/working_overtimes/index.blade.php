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
    <div class="card">
        <div class="card-header justify-content-between">
            <h2 class="mb-0">@lang('Danh sách')</h2>
            <div class="col-auto">
                <div class="card-header-action">
                    <div class="modal-button-container d-flex justify-content-end gap-1">
                        <a href="{{ route('working_overtime.create') }}" class="btn btn-primary">
                            <i class="icon ti ti-plus"></i>
                            <span>@lang('Thêm')</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive position-relative">
                @include('core_datatable::common.toggle_column.show')
                {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
            </div>
        </div>
    </div>
@endsection

