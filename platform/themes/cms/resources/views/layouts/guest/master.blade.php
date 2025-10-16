<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('themes_cms::layouts.guest.head')
</head>

<body class="border-top-wide d-flex flex-column">

    @yield('content')

    @include('themes_cms::layouts.guest.footer')

    @include('themes_cms::layouts.guest.scripts')

    <x-core_base::alert />

</body>

</html>