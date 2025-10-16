<div class="row align-items-end mb-3">
    {{-- <div class="col-12 col-md-auto">
        <div class="d-flex gap-2">
            <a href="{{ request()->fullUrlWithQuery(['type' => '']) }}" @class(['btn btn-sm btn-outline-primary w-100', 'active' => request('type') == ''])>
                @lang('Tất cả')
            </a>
            @foreach ($customer_type as $key => $type)
                <a href="{{ request()->fullUrlWithQuery(['type' => $key]) }}" @class(['btn btn-sm btn-outline-primary w-100', 'active' => request('type') == $key])>
                    {{ $type }}
                </a>
            @endforeach
        </div>
    </div> --}}
    <div class="col-12 col-md-auto ms-md-auto">
        <div class="col-12 col-md-auto ms-md-auto">
            <x-core_base::form :action="url()->current()">
                <x-core_base::input type="hidden" name="type" value="{{ request('type') }}" />
                <div class="d-flex flex-wrap gap-2">
                    <div class="flex-grow-1 flex-md-grow-0">
                        <label class="form-label">@lang('Nguồn'):</label>
                        <x-core_base::select name="source_id">
                            <x-core_base::select.option :title="trans('Tất cả')" />
                            @foreach ($sources as $source)
                                <x-core_base::select.option :selected="(int) request('source_id')" :title="$source->name" :value="$source->id" />
                            @endforeach
                        </x-core_base::select>
                    </div>
                    <div class="flex-grow-1 flex-md-grow-0">
                        <label class="form-label">@lang('Từ ngày'):</label>
                        <x-core_base::input type="date" name="start_date" :value="request('start_date')" class="w-100" />
                    </div>
                    <div class="flex-grow-1 flex-md-grow-0">
                        <label class="form-label">@lang('Đến ngày')</label>
                        <x-core_base::input type="date" name="end_date" :value="request('end_date')" class="w-100" />
                    </div>
                    <div class="d-flex align-items-end">
                        <button type="submit" class="btn btn-primary px-4">@lang('Lọc')</button>
                    </div>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>