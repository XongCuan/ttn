<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Employee -->
            <div class="col-12 col-md-6">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">@lang('Nhân viên'):</label>
                    <x-core_base::select class="select2-bs5-ajax-many" name="admin_id" :required="true" :data-url="route('superadmin.select_search.admin.all_employee')"></x-core_base::select>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">@lang('Loại'):</label>
                    <x-core_base::select class="select2-bs5-ajax-many" name="type_overtime_id" :required="true" :data-url="route('type_overtime.search_select')"></x-core_base::select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày'):</label>
                    <x-core_base::input type="date" name="date" :value="old('date')" :required="true"
                        :placeholder="__('Date')" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Số giờ'):</label>
                    <x-core_base::input.number name="hour" :value="old('hour')" :required="true"
                        :placeholder="__('Số giờ')" />
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">@lang('Ghi chú'):</label>
                <textarea name="note" class="form-control">{{ old('note') }}</textarea>
            </div>
        </div>
    </div>
</div>