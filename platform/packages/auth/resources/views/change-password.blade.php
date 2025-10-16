@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <x-core_base::form class="block-double-click" :action="route('auth.password.update')" type="put" enctype="multipart/form-data" :validate="true">
                    <div class="card">
                        <div class="card-body">
                            <!-- password old -->
                            <div class="mb-3">
                                <label class="form-label">@lang('Mật khẩu cũ'):</label>
                                <x-core_base::input.password name="old_password" :required="true"/>
                            </div>
                            <!-- new password -->
                            <div class="mb-3">
                                <label class="form-label">@lang('Mật khẩu mới'):</label>
                                <x-core_base::input.password name="password" :required="true"/>
                            </div>
                            <!-- new password confirmation-->
                            <div class="mb-3">
                                <label class="form-label">@lang('Nhập lại mật khẩu'):</label>
                                <x-core_base::input.password name="password_confirmation" :required="true" data-parsley-equalto="input[name='password']" data-parsley-equalto-message="{{ __('Mật khẩu chưa chính xác') }}"/>
                            </div>
                            <div class="btn-list justify-content-center">
                                <button type="submit" class="btn btn-primary">@lang('Đổi mật khẩu')</button>
                            </div>
                        </div>
                    </div>
                    </x-core_base::form>
                </div>
            </div>
        </div>
    </div>
@endsection
