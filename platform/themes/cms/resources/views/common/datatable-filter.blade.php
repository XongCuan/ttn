<div class="filter-data-inner">
    <div class="input-group">
        <x-core_base::select name="filter_month">
            <x-core_base::select.option value="" :title="trans('Chọn tháng')" />
            @for ($month = 1; $month <= 12; $month++)
                <x-core_base::select.option :value="str_pad($month, 2, '0', STR_PAD_LEFT)" :title="trans('Tháng :value', ['value' => $month])" />
            @endfor
        </x-core_base::select>
        <x-core_base::select name="filter_year">
            <x-core_base::select.option value="" :title="trans('Chọn năm')" />
            @foreach ($list_years as $year)
                <x-core_base::select.option :value="$year" :title="trans('Năm :value', ['value' => $year])" />
            @endforeach
        </x-core_base::select>
        <button type="button" class="btn btn-primary btn-action-filter">@lang('Lọc')</button>
    </div>
</div>