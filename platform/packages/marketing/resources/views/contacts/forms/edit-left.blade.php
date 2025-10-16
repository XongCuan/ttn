<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Họ và tên'):</label>
                    <x-core_base::input name="fullname" :value="$data->fullname" :required="true"
                        :placeholder="__('Họ và tên')" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Số điện thoại'):</label>
                    <x-core_base::input.phone name="phone" :value="$data->phone" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Email'):</label>
                    <x-core_base::input.email name="email" :value="$data->email" />
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">@lang('Giới tính'):</label>
                    <x-core_base::select name="gender">
                        @foreach ($gender as $key => $value)
                            <x-core_base::select.option :selected="$data->gender->value" :value="$key" :title="$value" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày tạo'):</label>
                    <x-core_base::input type="date" name="date_add" :value="$data->date_add?->format('Y-m-d')" />
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Nguồn'):</label>
                    <x-core_base::select name="source_id">
                        @foreach ($sources as $source)
                            <x-core_base::select.option :selected="$data->source_id" :value="$source->id" :title="$source->name" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Loại'):</label>
                    <x-core_base::select name="type_id">
                        @foreach ($types as $type)
                            <x-core_base::select.option :selected="$data->type_id" :value="$type->id" :title="$type->name" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Trạng thái'):</label>
                    <x-core_base::select name="status">
                        @foreach ($status as $key => $value)
                            <x-core_base::select.option :selected="$data->status->value" :value="$key" :title="$value" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('khu vực'):</label>
                    <x-core_base::select name="area">
                        @foreach ($area as $key => $value)
                            <x-core_base::select.option :selected="$data->area->value" :value="$key" :title="$value" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Lĩnh vực'):</label>
                    <x-core_base::select name="sector_id">
                        @foreach ($sectors as $sector)
                            <x-core_base::select.option :selected="$data->sector_id" :value="$sector->id" :title="$sector->name" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Tầm giá'):</label>
                    <x-core_base::select name="range_price_id">
                        @foreach ($range_prices as $range_price)
                            <x-core_base::select.option :selected="$data->range_price_id" :value="$range_price->id" :title="$range_price->name" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>

            <!-- province -->
            <div class="col-md-4 col-sm-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Tỉnh/Thành phố') }}:</label>
                    <x-core_base::select class="select2-bs5-ajax-many select2-condition" name="province_code" :data-url="route('base.select_region.province')"
                        data-condition="select[name='district_code']" data-param="province_code">
                        @if($data->province_code)
                            <x-core_base::select.option :selected="$data->province_code" :value="$data->province_code" :title="$data->province->name" />
                        @endif
                    </x-core_base::select>
                </div>
            </div>

            <!-- district -->
            <div class="col-md-4 col-sm-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Quận/Huyện') }}:</label>
                    <x-core_base::select class="select2-bs5-ajax-many select2-condition" name="district_code" :data-url="route('base.select_region.district', ['province_code' => 0])"
                        data-condition="select[name='ward_code']" data-param="district_code">
                        @if($data->province_code)
                            <x-core_base::select.option :selected="$data->district_code" :value="$data->district_code" :title="$data->district->name" />
                        @endif
                    </x-core_base::select>
                </div>
            </div>

            <!-- ward -->
            <div class="col-md-4 col-sm-12">
                <div class="mb-3 wrap-select2">
                    <label class="form-label">{{ __('Phường/Xã') }}:</label>
                    <x-core_base::select class="select2-bs5-ajax-many" name="ward_code" :data-url="route('base.select_region.ward', ['district_code' => 0])">
                        @if($data->province_code)
                            <x-core_base::select.option :selected="$data->ward_code" :value="$data->ward_code" :title="$data->ward->name" />
                        @endif
                    </x-core_base::select>
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Địa chỉ'):</label>
                    <x-core_base::input name="address" :value="$data->address" :placeholder="__('Địa chỉ')" />
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('note'):</label>
                    <textarea name="note" class="form-control" placeholder="{{ trans('Ghi chú') }}">{{ $data->note }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>