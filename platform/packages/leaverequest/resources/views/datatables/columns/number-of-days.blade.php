@if ($leave_request->is_half_day)
    @lang('Nửa ngày')
@else
{{ get_working_days($leave_request->start_date, $leave_request->end_date) }}
    @lang('ngày')
@endif
