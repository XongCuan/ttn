<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Employee -->
            <div class="col-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">@lang('Nhân viên'):</label>
                    <x-core_base::select class="select2-bs5-ajax-many" name="admin_id" :required="true" :data-url="route('superadmin.select_search.admin.all_employee')"></x-core_base::select>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày'):</label>
                    <x-core_base::input type="date" name="date" :value="old('date')" :required="true"
                        :placeholder="__('Date')" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Checkin'):</label>
                    <x-core_base::input type="time" name="check_in" :value="old('check_in')" :required="true"
                        :placeholder="__('Checkin')" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Checkout'):</label>
                    <x-core_base::input type="time" name="check_out" :value="old('check_out')" :placeholder="__('Checkout')" />
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">@lang('Ghi chú'):</label>
                <textarea name="note" class="form-control">{{ old('note') }}</textarea>
            </div>
        </div>
    </div>
</div>