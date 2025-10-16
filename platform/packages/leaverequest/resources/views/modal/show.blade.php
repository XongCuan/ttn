<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" id="leaveRequestUpdate" :action="route('leave_request.update')" type="put"
                :validate="true" data-load-dt="true" data-table-id="leaveRequestTable">
                <x-core_base::input type="hidden" name="id" :value="$leave_request->id" />
                <div class="modal-body">
                    <h2 class="text-center mb-4">@lang('Đơn Xin Nghỉ Phép')</h2>

                    <div class="mb-3">
                        <label class="form-label">@lang('Tiêu đề')</label>
                        <x-core_base::input name="title" :value="$leave_request->title" :required="true" readonly />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">@lang('Loại nghỉ phép')</label>
                        <x-core_base::input name="title" :value="$leave_request->type->description()" :required="true" readonly />
                    </div>

                    @if ($leave_request->is_half_day)
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="halfDayCheck" name="is_half_day" checked
                                disabled value="1">
                            <label class="form-check-label" for="halfDayCheck">@lang('Nghỉ nửa ngày')</label>
                        </div>

                        <div id="halfDaySection" class="mb-3">
                            <label class="form-label">@lang('Buổi nghỉ')</label>
                            <x-core_base::input name="title" :value="$leave_request->half_day_type->description()" :required="true" readonly />
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">@lang('Từ ngày')</label>
                        <x-core_base::input type="date" name="start_date" :required="true"
                            :value="$leave_request->start_date" readonly />
                    </div>
                    @if ($leave_request->end_date)
                        <div id="endDateSection" class="mb-3">
                            <label class="form-label">@lang('Đến ngày')</label>
                            <x-core_base::input type="date" name="end_date" :value="$leave_request->end_date" />
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">@lang('File đính kèm')</label>
                        <x-core_base::input.filepond name="file" style="opacity: 0" :value="$leave_request->file" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">@lang('Lý do nghỉ phép')</label>
                        <textarea class="form-control" name="reason" id="leaveReason" rows="3" placeholder="Nhập lý do nghỉ phép">{!! $leave_request->reason !!}</textarea>
                    </div>

                    <div id="rejectReasonSection" class="{{ $leave_request->reason_rejection ? 'd-block' : 'd-none' }} mb-3">
                        <label class="form-label">@lang('Lý do từ chối')</label>
                        <textarea class="form-control" name="reason_rejection" id="rejectReason" rows="3"
                            placeholder="Nhập lý do từ chối">{{ $leave_request->reason_rejection }}</textarea>
                    </div>
                    

                    @if ($leave_request->isPending())
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" name="submitter"
                                value="reject">@lang('Từ chối')</button>
                            <button type="submit" class="btn btn-success" name="submitter"
                                value="approve">@lang('Duyệt')</button>
                        </div>
                    @endif

                </div>
            </x-core_base::form>
        </div>
    </div>
</div>
