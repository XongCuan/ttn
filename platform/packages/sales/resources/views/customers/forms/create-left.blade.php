<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên Khách Hàng'):</label>
                    <x-core_base::input name="company" :placeholder="__('Tên Khách Hàng')" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Người Liên Hệ'):</label>
                    <x-core_base::input name="fullname" :value="old('fullname')" :required="true"
                        :placeholder="__('Người Liên Hệ')" />
                </div>
            </div>


            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Email'):</label>
                    <x-core_base::input.email name="email" :value="old('email')" />
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">@lang('Loại Khách Hàng'):</label>
                    <x-core_base::select name="gender">
                        @foreach ($gender as $key => $value)
                        <x-core_base::select.option :value="$key" :title="$value" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên viết tắt *'):</label>
                    <x-core_base::input name="short_name" :placeholder="__('Tên viết tắt ')" />
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Địa chỉ'):</label>
                    <x-core_base::input name="address" :placeholder="__('Địa chỉ')" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Số điện thoại'):</label>
                    <x-core_base::input.phone name="phone" :value="old('phone')" />
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Mã số Thuế'):</label>
                    <x-core_base::input name="tax_code" :placeholder="__('Mã số Thuế')" />
                </div>
            </div>


        </div>
    </div>
</div>