<x-core_base::input type="hidden" name="service[{{$type}}][type]" :value="$type" />
@if (isset($required) == false || (isset($required) && $required))
<x-core_base::input type="hidden" name="is_service_domain" value="1" />
@endif
<div class="row">
    <div class="col-12 mb-3">
        <label for="" class="form-label">@lang('Số tiền')</label>
        <x-core_base::input type="text" class="inp-number-format" name="service[{{$type}}][amount]"
            :required="$required ?? true" :placeholder="trans('Số tiền')" />
    </div>
    <div class="col-12 col-md-6 mb-3">
        <label for="" class="form-label">@lang('Ngày bắt đầu')</label>
        <x-core_base::input type="date" name="service[{{$type}}][day_begin]" :required="$required ?? true" />
    </div>
    <div class="col-12 col-md-6 mb-3">
        <label for="" class="form-label">@lang('Ngày kết thúc')</label>
        <x-core_base::input type="date" name="service[{{$type}}][day_end]" />
    </div>
    <div class="col-md-12 col-12">
        <label class="form-label">@lang('Desc'):</label>
        <textarea name="service[{{$type}}][desc]" class="ckeditor visually-hidden"></textarea>
    </div>
</div>