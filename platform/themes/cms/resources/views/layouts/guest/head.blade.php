<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<meta name="X-TOKEN" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin')</title>

<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.png') }}" />
<!-- CSS files -->
<link rel="stylesheet" href="{{ asset('public/templates/tabler/css/tabler.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/jquery-toast-plugin/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/parsley/style.css') }}">

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
@stack('css')
    