<div class="card h-100">
    <div class="card-header">
        <h2 class="mb-0">{{ $title ?? trans('Thông tin cài đặt') }}</h2>
    </div>
    <div class="row card-body wrap-loop-input settings">
        @foreach ($settings as $setting)

            <div class="col-12 mb-3">
                <label class="form-label" for="">@lang($setting->setting_name)</label>
                <div class="row g-2">
                    <div class="col">
                        <x-dynamic-component :component="$setting->getNameComponent()"
                            :name="$setting->setting_key"
                            :value="$setting->plain_value" 
                            showImage="{{ $setting->setting_key }}"
                            :required="true"
                        />
                    </div>
                    <div class="col-auto align-self-center">
                        <span class="form-help" data-bs-toggle="popover" data-bs-placement="top"
                            data-bs-content="@lang($setting->desc)">?</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
