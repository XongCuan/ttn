<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('workingtime_ticket.update')" type="put" :validate="true"
                data-load-dt="true" data-table-id="workingtimeTicket">
                <x-core_base::input type="hidden" name="id" :value="$data->id" />
                <div class="modal-header">
                    <div class="modal-title">@lang('Sửa')</div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">@lang('Ngày'):</label>
                        <x-core_base::input type="date" name="ticket_date" :value="$data->ticket_date->format('Y-m-d')" :required="true"
                            :placeholder="__('Date')" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('Loại')</label>
                        <x-core_base::select name="type" :required="true">
                            @foreach ($type as $key => $value)
                                <x-core_base::select.option :selected="$data->type->value" :value="$key" :title="$value" />
                            @endforeach
                        </x-core_base::select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('Lý do')</label>
                        <textarea class="form-control" name="reason" placeholder="Nhập lý do">{{ $data->reason }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('Hình ảnh')</label>
                        <x-core_base::input.filepond name="attachment_path" :value="$data->attachment_path" style="opacity: 0" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">@lang('Hủy')</button>
                    <button type="submit" class="btn btn-primary">
                        @lang('Cập nhật')
                    </button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>
