<div class="card mb-3">
    <div class="card-header">
        <h4 class="mb-0">@lang('Thông tin yêu cầu')</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6 mb-2 ">
                <h4 class="text-secondary mb-1">@lang('Tên yêu cầu')</h4>
                <p class="h4">{{ $requirement->title }}</p>
            </div>
            <div class="col-6 mb-3">
                <h4 class="text-secondary">@lang('Deadline')</h4>
                {{ format_date($requirement->start_date) }} - {{ format_date($requirement->end_date) }}
            </div>
        </div>

        <div>
            <h4 class="text-secondary">@lang('Chi tiết')</h4>
            <p class="mb-0">{!! $requirement->content !!}</p>
        </div>
    </div>
</div>
