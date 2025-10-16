<div class="nav-item dropdown">
    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
        aria-label="Open user menu">
        <span class="avatar avatar-sm" style="background-image: url({{ get_auth_admin()->getAvatar() }})"></span>
        <div class="d-none d-xl-block ps-2">
            <div>{{ get_auth_admin()->fullname() }}</div>
            <div class="mt-1 small text-secondary"></div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <a href="{{ route('auth.profile.index') }}" class="dropdown-item">@lang('Hồ sơ')</a>
        <a href="{{ route('auth.password.change') }}" class="dropdown-item">@lang('Đổi mật khẩu')</a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalLogout">@lang('Đăng xuất')</a>
    </div>
</div>