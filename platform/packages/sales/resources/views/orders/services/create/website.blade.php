<x-core_base::input type="hidden" name="service[{{$type}}][type]" :value="$type" />
<x-core_base::input type="hidden" name="is_service_website" value="1" />
<div class="row">
    <div class="col-12 col-md-4 mb-3">
        <label for="" class="form-label">@lang('Số tiền')</label>
        <x-core_base::input type="text" class="inp-number-format" name="service[{{$type}}][amount]" :required="true" :placeholder="trans('Sô tiền')" />
    </div>
    <div class="col-12 col-md-4 mb-3">
        <label for="" class="form-label">@lang('Ngày bắt đầu')</label>
        <x-core_base::input type="date" name="service[{{$type}}][day_begin]" />
    </div>
    <div class="col-12 col-md-4 mb-3">
        <label for="" class="form-label">@lang('Ngày kết thúc')</label>
        <x-core_base::input type="date" name="service[{{$type}}][day_end]" />
    </div>
    <div class="col-md-12 col-12">
        <label class="form-label">@lang('Desc'):</label>
        <textarea name="service[{{$type}}][desc]" class="ckeditor visually-hidden"></textarea>
    </div>
</div>
<div class="service-add-container mt-3">
    <div class="form-label fw-bold mb-1">@lang('Dịch vụ thêm'):</div>
    <div class="d-flex gap-3">
        <div class="w-50">
            <x-core_base::input.checkbox class="toggle-elm" data-target=".add-domain" name="is_service_domain" :value="true" :label="trans('Domain')" />
            <div class="add-domain" style="display: none;">
                @include('packages_sales::orders.services.create.domain', ['type' => $service_type_domain->value, 'required' => false])
            </div>
        </div>
        <div class="w-50">
            <x-core_base::input.checkbox class="toggle-elm" data-target=".add-hosting" name="is_service_hosting" :value="true" :label="trans('Hosting')" />
            <div class="add-hosting" style="display: none;">
                @include('packages_sales::orders.services.create.hosting', ['type' => $service_type_hosting->value, 'required' => false])
            </div>
        </div>
    </div>
</div>