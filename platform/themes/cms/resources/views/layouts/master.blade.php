<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('themes_cms::layouts.head')
</head>

<body class="layout-fluid">
    <div class="page">
        
        <x-themes_cms::sidebar-left />

        @include('themes_cms::layouts.sidebar-top')
        
        <div class="page-wrapper">
            @section('breadcrums')
                @include('themes_cms::layouts.breadcrumbs')
            @show

            @yield('content')

            @include('themes_cms::layouts.footer')

            @include('themes_cms::layouts.modal.modal-logout')

            @include('themes_cms::layouts.modal.modal-delete')
            
            @include('themes_cms::layouts.modal.modal-ajax-delete')

            @include('themes_cms::layouts.modal.modal-ajax-confirm-update')
            
        </div>
    </div>
    @include('themes_cms::layouts.scripts')
    <x-core_base::alert />
</body>

</html>
