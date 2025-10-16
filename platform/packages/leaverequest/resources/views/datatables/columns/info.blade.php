{{-- @if (isset($leave_request))
    <div class="leave-info">
        <div class="leave-header">
            <div class="leave-title mb-0">@lang('Tiêu đề'): <span class="title">{{ $leave_request->title }}</span></div>
        </div>
        <div class="leave-details">
            <div class="leave-item">
                @lang('Loại nghỉ'):
                @if ($leave_request->is_half_day)

                        <span class="leave-type half-day">
                        @lang('Nửa ngày') ({{ $leave_request->half_day_type?->description() ?? 'Chưa chọn buổi' }})
                    </span>
                @else
                    <span class="leave-type full-day">Nghỉ cả ngày</span>
                @endif
            </div>
            <div class="leave-item">
                @lang('Thời gian'):
                <span class="start-date">{{ format_date($leave_request->start_date, 'd/m/Y') }}</span>
                @if ($leave_request->start_date !== $leave_request->end_date && $leave_request->end_date)
                    <span class="to">-</span>
                    <span class="end-date">{{ format_date($leave_request->end_date, 'd/m/Y') }}</span>
                @endif
            </div>
            <div class="leave-item">
                @lang('Lý do'):
                <span class="reason">{{ $leave_request->reason }}</span>
            </div>
            <div class="leave-item">
                @lang('Tệp đính kèm'):
                @if (!empty($leave_request->file))
                    <a href="{{ $leave_request->file }}" class="attachment-link" target="_blank">@lang('Xem')</a>
                @endif
            </div>
        </div>
    </div>
@endif --}}


<span class="start-date">{{ format_date($leave_request->start_date, 'd/m/Y') }}</span>
@if ($leave_request->start_date !== $leave_request->end_date && $leave_request->end_date)
    <span class="to">-</span>
    <span class="end-date">{{ format_date($leave_request->end_date, 'd/m/Y') }}</span>
@endif
