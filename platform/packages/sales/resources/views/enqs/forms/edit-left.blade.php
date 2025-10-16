<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Tên Khách Hàng -->
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên Khách Hàng'):</label>
                    <x-core_base::input name="company" :value="$data->company" :placeholder="__('Tên Khách Hàng')" />
                </div>
            </div>

            <!-- Người liên hệ -->
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Người Liên Hệ'):</label>
                    <x-core_base::input name="fullname" :value="$data->fullname" :placeholder="__('Người Liên Hệ')"
                        :required="true" />
                </div>
            </div>

            <!-- Email -->
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Email'):</label>
                    <x-core_base::input.email name="email" :value="$data->email" />
                </div>
            </div>

            <!-- Loại Khách Hàng -->
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">@lang('Loại Khách Hàng'):</label>
                    <x-core_base::select name="gender">
                        @foreach ($gender as $key => $value)
                        <x-core_base::select.option :selected="$data->gender->value ?? null" :value="$key"
                            :title="$value" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>

            <!-- Tên viết tắt -->
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên viết tắt *'):</label>
                    <x-core_base::input name="short_name" :value="$data->short_name"
                        :placeholder="__('Tên viết tắt')" />
                </div>
            </div>

            <!-- Địa chỉ -->
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Địa chỉ'):</label>
                    <x-core_base::input name="address" :value="$data->address" :placeholder="__('Địa chỉ')" />
                </div>
            </div>

            <!-- Số điện thoại -->
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Số điện thoại'):</label>
                    <x-core_base::input.phone name="phone" :value="$data->phone" />
                </div>
            </div>

            <!-- Mã số Thuế -->
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Mã số Thuế'):</label>
                    <x-core_base::input name="tax_code" :value="$data->tax_code" :placeholder="__('Mã số Thuế')" />
                </div>
            </div>
        </div>
    </div>
</div>