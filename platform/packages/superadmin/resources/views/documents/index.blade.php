@extends('themes_cms::layouts.datatable')

@push('libs-css')
<!-- Filepond stylesheet -->
<link href="{{ asset('public/libs/filepond/dist/filepond.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/libs/filepond/plugins/image-preview/dist/filepond-plugin-image-preview.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/libs/filepond/plugins/file-poster/filepond-plugin-file-poster.min.css') }}" rel="stylesheet">
@endpush

@section('datatable')

<div class="card">
    <div class="card-header justify-content-between">
        <h2 class="mb-0">@lang('Danh sách')</h2>
        <button class="btn btn-primary open-modal-form" data-route="{{ route('superadmin.document.create') }}">
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


@push('libs-js')

<!-- include FilePond library -->
<script src="{{ asset('public/libs/filepond/dist/filepond.min.js') }}"></script>

<!-- include FilePond plugins -->
<script src="{{ asset('public/libs/filepond/plugins/image-preview/dist/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('public/libs/filepond/plugins/file-validate-size/dist/filepond-plugin-file-validate-size.min.js') }}"></script>
<script src="{{ asset('public/libs/filepond/plugins/file-validate-type/dist/filepond-plugin-file-validate-type.min.js') }}"></script>
<script src="{{ asset('public/libs/filepond/plugins/image-resize/dist/filepond-plugin-image-resize.min.js') }}"></script>
<script src="{{ asset('public/libs/filepond/plugins/file-encode/dist/filepond-plugin-file-encode.min.js') }}"></script>
<script src="{{ asset('public/libs/filepond/plugins/file-poster/filepond-plugin-file-poster.min.js') }}"></script>

<!-- include FilePond jQuery adapter -->
<script src="{{ asset('public/libs/filepond/dist/filepond.jquery.js') }}"></script>

@endpush

@push('js')
    <script src="{{ vite_asset(core_public_asset('base', '/js/filepond.js')) }}"></script>
@endpush
