<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Employee -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Nhân viên'):</label>
                    <x-core_base::input :value="$working_time->admin->fullname" :required="true" readonly />
                    <x-core_base::input type="hidden" name="admin_id" :value="$working_time->admin_id" :required="true" />
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày'):</label>
                    <x-core_base::input type="date" name="date" :value="$working_time->date->format('Y-m-d')" :required="true"
                        :placeholder="__('Ngày')" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Checkin'):</label>
                    <x-core_base::input type="time" name="check_in" :value="$working_time->check_in->format('H:i')" :required="true"
                        :placeholder="__('Checkin')" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Checkout'):</label>
                    <x-core_base::input type="time" name="check_out" :value="$working_time->check_out?->format('H:i')" :placeholder="__('Checkout')" />
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">@lang('Ghi chú'):</label>
                <textarea name="note" class="form-control">{{ $working_time->note }}</textarea>
            </div>
        </div>
    </div>
</div>
