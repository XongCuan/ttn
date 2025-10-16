@extends('themes_cms::layouts.master')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df 10%, #224abe 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(45deg, #36b9cc 10%, #1a8a9c 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a 10%, #13855c 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e 10%, #dda20a 100%);
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgb(58 59 69 / 15%);
            overflow: hidden;
        }

        .card-stats {
            transition: all 0.3s ease;
        }

        .card-stats:hover {
            transform: translateY(-5px);
        }

        .icon-circle {
            height: 60px;
            width: 60px;
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0.15rem 1.75rem 0 rgb(58 59 69 / 15%);
        }

        .table> :not(caption)>*>* {
            padding: 1rem;
        }

        .insufficient-hours {
            background-color: #fee2e2 !important;
            color: #7f1d1d;
        }

        .table-responsive {
            overflow: hidden;
        }
        </style>
@endpush

@section('content')
    <div class="container-fluid py-4">

        @include('packages_superadmin::admin.partials.filter')
        @include('packages_superadmin::admin.partials.salary')

        <div class="card">
            <div class="card-header justify-content-between">
                <h2 class="mb-0">@lang('Danh sách làm việc tháng :month', ['month' => request('filter_month') ?? (now()->month == 1 ? 12 : now()->month - 1)])</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive position-relative">
                    @include('core_datatable::common.toggle_column.show')
                    {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ vite_asset(core_public_asset('datatable', 'js/buttons.server-side.js')) }}"></script>
@endpush

@push('js')
    {{ $dataTable->scripts() }}

    @include('core_datatable::common.toggle_column.script', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])

    <script>
        $(document).ready(function() {
            $('#formFilterMonthYear').on('submit', function(e) {
                var selectedMonth = $('select[name="filter_month"]').val();
                var selectedYear = $('select[name="filter_year"]').val();

                if (selectedMonth !== "" && selectedYear === "") {
                    e.preventDefault();
                    msgWarning('Vui lòng chọn năm trước khi lọc!');
                }
            });
        });
    </script>
@endpush
