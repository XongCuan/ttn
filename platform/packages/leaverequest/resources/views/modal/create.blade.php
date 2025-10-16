<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Đơn Xin Nghỉ Phép')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <x-core_base::form class="ajax-modal-form" :action="route('leave_request.store')" type="post" :validate="true"
                data-load-dt="true" data-table-id="leaveRequestTable">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">@lang('Số ngày phép năm còn lại')</label>
                            <x-core_base::input id="remainingLeave" :value="get_auth_admin()->leave_days ?? 0" readonly />
                        </div>
                        <div class="col-6">
                            <label class="form-label">@lang('Số ngày nghỉ trong tháng')</label>
                            <x-core_base::input id="monthlyLeave" :value="get_auth_admin()->calculateLeaveDaysForCurrentMonth()" readonly />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">@lang('Tiêu đề')</label>
                        <x-core_base::input name="title" :required="true" :placeholder="__('Tiêu đề')" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">@lang('Loại nghỉ phép')</label>
                        <x-core_base::select id="leaveType" required name="type" :required="true">
                            <x-core_base::select.option :title="@trans('Chọn loại nghỉ phép')" />
                            @foreach ($types as $key => $value)
                                <x-core_base::select.option :value="$key" :title="$value" />
                            @endforeach
                        </x-core_base::select>
                    </div>

                    <div class="mb-3 form-check" id="halfDay">
                        <input type="checkbox" class="form-check-input" id="halfDayCheck" name="is_half_day"
                            value="1">
                        <label class="form-check-label" for="halfDayCheck">@lang('Nghỉ nửa ngày')</label>
                    </div>

                    <div id="halfDaySection" class="mb-3" style="display:none;">
                        <label class="form-label">@lang('Chọn buổi')</label>
                        <x-core_base::select id="halfDayType" name="half_day_type">
                            @foreach ($haft_day_types as $key => $value)
                                <x-core_base::select.option :value="$key" :title="$value" />
                            @endforeach
                        </x-core_base::select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">@lang('Từ ngày')</label>
                        <x-core_base::input type="date" name="start_date" id="startDate" :required="true" />
                    </div>

                    <div id="endDateSection" class="mb-3">
                        <label class="form-label">@lang('Đến ngày')</label>
                        <x-core_base::input type="date" name="end_date" id="endDate" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('File đính kèm')</label>
                        <x-core_base::input.filepond name="file" style="opacity: 0" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">@lang('Lý do nghỉ phép')</label>
                        <textarea class="form-control" name="reason" id="leaveReason" rows="3" placeholder="Nhập lý do nghỉ phép"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">@lang('Gửi Yêu Cầu Nghỉ Phép')</button>

                </div>
            </x-core_base::form>
        </div>
    </div>
</div>
