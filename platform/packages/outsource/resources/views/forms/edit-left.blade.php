<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-md-6 col-sm-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Đơn hàng') }}:</label>
                    <x-core_base::input name="order_id" :value="$project->order?->name" readonly/>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Yêu cầu webadmin') }}:</label>
                    <x-core_base::input name="order_id" :value="$project->requirement?->name" readonly/>
                </div>
            </div>

            <div class="col-12 col-md-10">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên dự án'):</label>
                    <x-core_base::input name="name" :value="$project->name" :required="true" :placeholder="__('Tên dự án')" />
                </div>
            </div>

            <div class="col-12 col-md-2">
                <label class="form-label">@lang('Quy mô'):</label>
                <x-core_base::select name="scale" :required="true">
                    @foreach ($scale as $key => $value)
                        <x-core_base::select.option :selected="$project->scale->value" :value="$key" :title="$value" />
                    @endforeach
                </x-core_base::select>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày bắt đầu'):</label>
                    <x-core_base::input name="start_date" type="date" :value="$project->start_date" :required="true" />
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày kết thúc'):</label>
                    <x-core_base::input name="end_date" type="date" :value="$project->end_date" :required="true" />
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Mô tả'):</label>
                    <textarea name="desc" class="ckeditor visually-hidden">{!! $project->desc !!}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
