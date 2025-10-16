<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">@lang('Xem')</div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div @class(['alert', working_time_ticket_service()->isStatusApproved($data) ? 'alert-success' : 'alert-danger']) role="alert">
                            <div>
                                <h4 class="alert-heading">{{ $data->status->description() }}</h4>
                                @if(working_time_ticket_service()->isStatusApproved($data))
                                    <div class="alert-description">
                                        @lang('Đơn bổ sung được duyệt')
                                    </div>
                                @else
                                    <div class="alert-description">
                                        {{ $data->reason_refuse }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <p><strong>@lang('Tên nhân viên'):</strong> {{ $data->admin?->fullname }}</p>
                    </div>
                    <div class="col-6">
                        <p><strong>@lang('Ngày bổ sung'):</strong> {{ format_date($data->ticket_date) }}</p>
                    </div>
                    <div class="col-6">
                        <p><strong>@lang('Loại bổ sung'):</strong> <span
                                @class(['badge', $data->type->badge()])>{{ $data->type->description() }}</span></p>
                    </div>
                    <div class="col-12">
                        <p><strong>@lang('Lý do'):</strong> {{ $data->reason }}</p>
                        <img src="{{ asset($data->attachment_path) }}" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">@lang('Đóng')</button>
            </div>
        </div>
    </div>
</div>
