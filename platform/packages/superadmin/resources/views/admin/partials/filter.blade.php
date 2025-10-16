<div class="row align-items-end mb-3">
    <div class="col-12 col-md-4 ms-md-auto">
        <x-core_base::form id="formFilterMonthYear" :action="route('superadmin.admin.salary', $admin->id)" type="get" :validate="true">
            <div class="input-group">
                <x-core_base::select name="filter_month">
                    <x-core_base::select.option value="" :title="trans('Chọn tháng')" />
                    @for ($month = 1; $month <= 12; $month++)
                        <x-core_base::select.option :selected="(int) request('filter_month')" :value="$month" :title="trans('Tháng :value', ['value' => $month])" />
                    @endfor
                </x-core_base::select>
                <x-core_base::select name="filter_year">
                    <x-core_base::select.option value="" :title="trans('Chọn năm')" />
                    @foreach ($list_years as $year)
                        <x-core_base::select.option :selected="(int) (request('filter_year'))" :value="$year" :title="trans('Năm :value', ['value' => $year])" />
                    @endforeach
                </x-core_base::select>
                <button type="submit" class="btn btn-primary btn-action-filter">@lang('Lọc')</button>
            </div>
        </x-core_base::form>

    </div>
</div>
