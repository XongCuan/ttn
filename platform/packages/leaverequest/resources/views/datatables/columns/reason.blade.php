<div class="mb-1">
    {!! nl2br(e($leave_request->reason)) !!}
</div>

@if ($leave_request->file)
    <a href="{{ asset($leave_request->file) }}" class="text-primary text-decoration-none" target="_blank">
        <i class="ti ti-paperclip me-1"></i>@lang('File đính kèm')
    </a>
@endif