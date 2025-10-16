<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('outsource.project.update_change_status')" type="put" :validate="true"
                data-load-dt="true" data-table-id="projectTable">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="modal-header">
                    <div class="modal-title">@lang('Xử lý dự án')</div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($status as $key => $value)
                            <div class="col-12">
                                <label class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="status"
                                        value="{{ $key }}" {{ $data->status->value == $key ? 'checked' : '' }}
                                        data-parsley-multiple="confirm">
                                    <span class="form-check-label">{{ $value }}</span>
                                </label>
                            </div>
                        @endforeach
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
