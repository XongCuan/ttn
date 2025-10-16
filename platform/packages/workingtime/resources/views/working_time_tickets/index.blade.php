@extends('themes_cms::layouts.datatable')

@push('libs-css')

<link rel="stylesheet" href="{{ asset('public/libs/filepond/dist/filepond.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/filepond/plugins/image-preview/dist/filepond-plugin-image-preview.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/filepond/plugins/file-poster/filepond-plugin-file-poster.min.css') }}">

@endpush

@section('datatable')
@if (get_auth_admin()->isRoleManager())
    <div class="d-flex gap-2 mb-3">
        <div class="">
            <a href="{{ route('workingtime_ticket.index') }}" @class(['btn btn-outline-primary', 'active' => request()->routeIs('workingtime_ticket.index')])>@lang('Của tôi')</a>
        </div>
        <div class="">
            <a href="{{ route('workingtime_ticket.index_employee') }}" @class(['btn btn-outline-primary', 'active' => request()->routeIs('workingtime_ticket.index_employee')])>@lang('Nhân viên')</a>
        </div>
    </div>
@endif
<div class="card">
    <div class="card-header justify-content-between">
        <h2 class="mb-0">@lang('Danh sách')</h2>
        @if(request()->routeIs('workingtime_ticket.index') && get_auth_admin()->isSuperadmin() == false)
        <button type="button" class="btn btn-primary open-modal-form" data-route="{{ route('workingtime_ticket.create') }}">
            <i class="ti ti-plus icon"></i>
            <span>@lang('Thêm')</span>
        </button>
        @endif
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
    <script src="{{ asset('libs/filepond/dist/filepond.min.js') }}"></script>
    <script
        src="{{ asset('libs/filepond/plugins/image-preview/dist/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ asset('libs/filepond/plugins/file-validate-size/dist/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('libs/filepond/plugins/file-validate-type/dist/filepond-plugin-file-validate-type.min.js') }}">
    </script>

    <script
        src="{{ asset('libs/filepond/plugins/image-resize/dist/filepond-plugin-image-resize.min.js') }}">
    </script>
    <script
        src="{{ asset('libs/filepond/plugins/file-encode/dist/filepond-plugin-file-encode.min.js') }}">
    </script>
    <script src="{{ asset('libs/filepond/dist/filepond.jquery.js') }}"></script>
@endpush

@push('js')
    <script type="module" src="{{ vite_asset(core_public_asset('base', 'js/filepond.js')) }}"></script>
    <script>
        $(document).on('change', 'input[name="status"]', function() {
            if($(this).val() == '30')
            {
                $('textarea[name="reason_refuse"]').css('display', 'block');
            }else {
                $('textarea[name="reason_refuse"]').css('display', 'none');
            }
        })
    </script>
@endpush

