<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-md-12 col-sm-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Đơn hàng') }}:</label>
                    <x-core_base::input name="order_id" :value="$data->order?->name" :required="true" :placeholder="__('Tên dự án')" readonly/>
                </div>

            </div>

            <div class="col-12 col-md-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên yêu cầu'):</label>
                    <x-core_base::input name="title" :value="$data->title" :required="true" :placeholder="__('Tên yêu cầu')" />
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày bắt đầu'):</label>
                    <x-core_base::input name="start_date" type="date" :value="$data->start_date" :required="true" />
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày kết thúc'):</label>
                    <x-core_base::input name="end_date" type="date" :value="$data->end_date" :required="true" />
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Chi tiết yêu cầu'):</label>
                    <textarea name="content" class="ckeditor visually-hidden">{!! $data->content !!}</textarea>
                </div>
            </div>
            <div class="col-md-12 col-12">
                @include('packages_outsource::partials.order-info', ['order' => $data->order])
            </div>
        </div>
    </div>
</div>
