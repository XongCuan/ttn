<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Email Address -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Email'):</label>
                    <x-core_base::input.email name="admin[email]" :value="old('admin.email')" :required="true" /> 
                </div>
            </div>
            <!-- Fullname -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Họ và tên'):</label>
                    <x-core_base::input name="admin[fullname]" :value="old('admin.fullname')" :required="true"
                        :placeholder="__('Họ và tên')" />
                </div>
            </div>
            <!-- new password -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Mật khẩu'):</label>
                    <x-core_base::input.password name="admin[password]" :required="true" />
                </div>
            </div>
            <!-- new password confirmation-->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Nhập lại mật khẩu'):</label>
                    <x-core_base::input.password name="admin[password_confirmation]" :required="true"
                        data-parsley-equalto="input[name='admin[password]']"
                        data-parsley-equalto-message="{{ trans('Mật khẩu không khớp') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Số điện thoại'):</label>
                    <x-core_base::input.phone name="admin[phone]" :value="old('admin.phone')" :required="true" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày sinh'):</label>
                    <x-core_base::input type="date" name="admin[birthday]" :value="old('admin.birthday')" />
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="row card-body">
            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngân hàng'):</label>
                    <x-core_base::select class="select2-bs5" name="bank_account[bank_id]">
                        <x-core_base::select.option value="" :title="trans('Chọn ngân hàng')" />
                        @foreach ($banks as $bank)
                            <x-core_base::select.option :value="$bank->id" :title="$bank->displayName()" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Chủ tài khoản'):</label>
                    <x-core_base::input name="bank_account[account_holder]" :value="old('bank_account.account_holder')" :placeholder="__('Chủ tài khoản')" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Số tài khoản'):</label>
                    <x-core_base::input name="bank_account[account_number]" :value="old('bank_account.account_number')" :placeholder="__('Số tài khoản')" />
                </div>
            </div>
        </div>
    </div>
</div>