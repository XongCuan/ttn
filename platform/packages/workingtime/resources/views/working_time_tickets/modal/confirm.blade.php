<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('workingtime_ticket.handle_confirm')" type="put" :validate="true"
                data-load-dt="true" data-table-id="workingtimeTicket">
                <x-core_base::input type="hidden" name="id" :value="$data->id" />
                <div class="modal-header">
                    <div class="modal-title">@lang('Duyệt bổ sung')</div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <x-core_base::input.radio name="status" value="20" :label="trans('Duyệt')" />
                                </div>
                                <div class="col-6">
                                    <x-core_base::input.radio name="status" value="30" :label="trans('Từ chối')" />
                                </div>
                                <div class="col-12">
                                    <textarea name="reason_refuse" class="form-control" style="display: none;" placeholder="@lang('Lý do từ chối')"></textarea>
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
                            <p><strong>@lang('Loại bổ sung'):</strong> <span @class(['badge', $data->type->badge()])>{{ $data->type->description() }}</span></p>
                        </div>
                        <div class="col-12">
                            <p><strong>@lang('Lý do'):</strong> {{ $data->reason }}</p>
                            <img src="{{ asset($data->attachment_path) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">@lang('Hủy')</button>
                    <button type="submit" class="btn btn-primary">
                        @lang('Xác nhận')
                    </button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>
