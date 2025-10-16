@extends('themes_cms::layouts.guest.master')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark">
                <img src="{{ asset('public/images/logo.png') }}" width="110" height="32" alt="TTN"
                    class="navbar-brand-image">
            </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">@lang('Đăng nhập Admin')</h2>
                <x-core_base::form class="block-double-click" :action="route('login.handle')" type="post"
                    :validate="true">
                    <div class="mb-3">
                        <label class="form-label">@lang('Email'):</label>
                        <x-core_base::input.email name="email" :value="old('email')" :required="true" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('Mật khẩu'):</label>
                        <x-core_base::input.password name="password" :required="true" />
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">@lang('Đăng nhập')</button>
                    </div>
                </x-core_base::form>
            </div>
        </div>
    </div>
</div>
@endsection