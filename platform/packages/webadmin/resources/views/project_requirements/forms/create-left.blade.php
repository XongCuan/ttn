<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-md-12 col-sm-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Đơn hàng') }}:</label>
                    <x-core_base::select class="select2-bs5-ajax-many" name="order_id"
                        :data-url="route('webadmin.select_order')"></x-core_base::select>
                </div>

            </div>
            <div class="order-info"></div>
            <div class="col-12 col-md-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Tiêu đề'):</label>
                    <x-core_base::input name="title" :value="old('title')" :required="true" :placeholder="__('Tiêu đề')" />
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày bắt đầu'):</label>
                    <x-core_base::input name="start_date" type="date" :value="old('start_date')" :required="true" />
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày kết thúc'):</label>
                    <x-core_base::input name="end_date" type="date" :value="old('end_date')" :required="true" />
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Chi tiết yêu cầu'):</label>
                    <textarea name="content" class="ckeditor visually-hidden"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
