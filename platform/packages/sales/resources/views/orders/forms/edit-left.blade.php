<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-md-6 col-sm-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Khách hàng') }}:</label>
                    <x-core_base::input name="customer_id" :value="$order->customer->displayText()" readonly />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên đơn hàng'):</label>
                    <x-core_base::input name="order[name]" :value="$order->name" :required="true"
                        :placeholder="__('Tên đơn hàng')" />
                </div>
            </div>

            @include('packages_sales::orders.services.edit')
            @include('packages_sales::orders.payments.edit')
            @include('packages_sales::orders.arises.index')

            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Mô tả'):</label>
                    <textarea name="order[desc]" class="ckeditor visually-hidden">
                        {!! $order->desc !!}
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>