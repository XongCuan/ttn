<div class="row align-items-end mb-3">
    <div class="col-12 col-md-auto ms-md-auto">
        <div class="col-12 col-md-auto ms-md-auto">
            <x-core_base::form :action="url()->current()">
                <div class="d-flex flex-wrap gap-2">
                    <div class="flex-grow-1 flex-md-grow-0">
                        <label class="form-label">@lang('Từ ngày'):</label>
                        <x-core_base::input type="date" name="start_date" :value="request('start_date')" class="w-100" />
                    </div>
                    <div class="flex-grow-1 flex-md-grow-0">
                        <label class="form-label">@lang('Đến ngày')</label>
                        <x-core_base::input type="date" name="end_date" :value="request('end_date')" class="w-100" />
                    </div>
                    <div class="d-flex align-items-end">
                        <button type="submit" class="btn btn-primary px-4">@lang('Lọc')</button>
                    </div>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>