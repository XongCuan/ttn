<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Thông tin dự án')</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">@lang('Tên dự án')</label>
                        <p>{{ $data->name }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">@lang('Deadline')</label>
                        <p>{{ format_date($data->start_date, 'd/m/Y') }} - {{ format_date($data->end_date, 'd/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">@lang('Sales')</label>
                        <p>{{ $data->order?->assigns?->pluck('fullname')->implode(', ') }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">@lang('Trạng thái')</label>
                        <span
                            @class([
                                'badge',
                                \App\Enums\Project\ProjectStatus::tryFrom($data->status->value)->badge(),
                            ])>{{ \App\Enums\Project\ProjectStatus::getDescription($data->status->value) }}</span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">@lang('Mức độ ưu tiên')</label>
                        <span
                            @class([
                                'badge',
                                \App\Enums\Project\ProjectPriority::tryFrom(
                                    $data->priority->value)->badge(),
                            ])>{{ \App\Enums\Project\ProjectPriority::getDescription($data->priority->value) }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">@lang('Mô tả')</label>
                        <p>{!! $data->desc !!}</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
