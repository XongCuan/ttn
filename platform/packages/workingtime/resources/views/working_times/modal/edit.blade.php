<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog modal-small modal-dialog-centered">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" data-load-dt="true" data-table-id="adminWorkingtimeeTable"
                action="{{ route('working_time.update') }}" type="put" :validate="true">
                <x-core_base::input type="hidden" name="id" :value="$working_time->id" />
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Sửa') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">@lang('Ngày'):</label>
                            <x-core_base::input type="date" name="date" :value="$working_time->date->format('Y-m-d')" :required="true" readonly
                                :placeholder="__('Date')" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">@lang('Checkin'):</label>
                            <x-core_base::input type="time" name="check_in" :value="$working_time->check_in->format('H:i')" :required="true"
                                :placeholder="__('Checkin')" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">@lang('Checkout'):</label>
                            <x-core_base::input type="time" name="check_out" :value="$working_time->check_out?->format('H:i')" :placeholder="__('Checkout')" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Thoát') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                </div>
                </x-core_base::form>
        </div>
    </div>
</div>
