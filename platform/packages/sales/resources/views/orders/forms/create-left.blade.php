<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-md-6 col-sm-12">
                @if ($type == null)
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Khách hàng') }}:</label>
                    <x-core_base::select class="select2-bs5-ajax-many" name="order[customer_id]"
                        :data-url="route('sales.select_customer')"></x-core_base::select>
                </div>
                @elseif(get_class($type) == App\Models\Contact::class)
                <div class="mb-3">
                    <label class="form-label">{{ __('Liên hệ') }}:</label>
                    <x-core_base::input type="hidden" name="order[contact_id]" :value="$type->id" />
                    <x-core_base::input type="text" name="contact_fullname" :value="$type->displayText()" readonly />
                </div>
                @else
                <div class="mb-3">
                    <label class="form-label">{{ __('Khách hàng quay lại') }}:</label>
                    <x-core_base::input type="hidden" name="order[customer_return_id]" :value="$type->id" />
                    <x-core_base::input type="text" name="customer_return_fullname"
                        :value="$type->customer->displayText()" readonly />
                </div>
                @endif
            </div>

            {{-- CHỖ NÀY CHO CHỌN ENQ - ĐỂ LÀM THÀNH ĐƠN HÀNG --}}
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Báo giá '):</label>
                    <x-core_base::input name="order[name]" :value="old('name')" :required="true"
                        :placeholder="__('Chọn báo giá ')" />
                </div>
            </div>

            @include('packages_sales::orders.services.create')
            @include('packages_sales::orders.payments.create')

            {{-- <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Mô tả'):</label>
                    <textarea name="order[desc]" class="ckeditor visually-hidden"></textarea>
                </div>
            </div> --}}
        </div>
    </div>
</div>