@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            @yield('datatable')
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ vite_asset(core_public_asset('datatable', 'js/buttons.server-side.js')) }}"></script>
@endpush

@push('js')
    {{ $dataTable->scripts() }}

    @include('themes_cms::scripts.datatable-search-month-year')

    @include('core_datatable::common.toggle_column.script', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])
@endpush
