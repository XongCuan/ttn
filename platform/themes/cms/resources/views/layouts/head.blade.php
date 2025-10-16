<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url-home" content="{{ url('/') }}">
<title>@yield('title', config('app.name'))</title>
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.png') }}" />

<!-- CSS files -->
<link rel="stylesheet" href="{{ asset('public/templates/tabler/css/tabler.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/templates/tabler/css/tabler-vendors.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/templates/tabler/icons/tabler-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/jquery-toast-plugin/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/parsley/style.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/datatables/plugins/bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/datatables/plugins/buttons/css/buttons.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/datatables/plugins/responsive/css/responsive.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/select2/css/select2-bootstrap-5-theme.min.css') }}">

<style>
    @import url('https://rsms.me/inter/inter.css');
    :root {
    --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }
    body {
    font-feature-settings: "cv03", "cv04", "cv11";
    }
</style>

@stack('libs-css')

@vite([
    core_public_asset('base', 'css/init.css'),
    core_public_asset('datatable', 'css/datatable.css'),
    theme_asset('cms', 'assets/css/cms.css')
])
@stack('css')