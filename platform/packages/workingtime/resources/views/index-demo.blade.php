{{-- Lấy đường dẫn css, js từ thư mục resources --}}
{{ vite_package_asset('example', '/abc.js') }}

{{-- Lấy đường dẫn css, js từ thư mục public --}}
{{ vite_asset(package_public_asset('example', '/abc.js')) }}
