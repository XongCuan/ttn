<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('notification.notification_content.store')" type="post" :validate="true" data-load-dt="true" data-table-id="notificationContent">
                <div class="modal-header">
                    <div class="modal-title">@lang('Thông báo')</div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Tiêu đề'):</label>
                        <x-core_base::input name="title" :required="true" :placeholder="trans('Tiêu đề')" />
                    </div>
                    @if (count($departments))
                        @if (get_auth_admin()->isSuperadmin())
                            <div class="mb-3">
                                <x-core_base::input-switch name="is_all" :value="true" :label="trans('Gửi toàn bộ nhân viên')" />
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="" class="form-label">@lang('Chọn phòng ban'):</label>
                            <div class="row">
                                @foreach ($departments as $key => $value)
                                    <div class="col-6 col-md-3">
                                        <x-core_base::input.checkbox name="target_deparments[]" :value="$key" :label="$value" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Mô tả'):</label>
                        <textarea name="content" class="visually-hidden ckeditor"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">@lang('Hủy')</button>
                    <button type="submit" class="btn btn-primary">
                        @lang('Thêm')
                    </button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>