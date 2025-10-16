<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('superadmin.document_type.update')" type="put" :validate="true" data-load-dt="true" data-table-id="documentType">
                <x-core_base::input type="hidden" name="id" :value="$data->id" />
                <div class="modal-header">
                    <div class="modal-title">@lang('Sửa')</div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Tên'):</label>
                        <x-core_base::input name="name" :value="$data->name" :required="true" :placeholder="trans('Tên')" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('Cha'):</label>
                        <x-core_base::select name="parent_id">
                            <x-core_base::select.option value="" :title="__('Trống')" />
                            @foreach ($parents as $parent)
                                <x-core_base::select.option :selected="$data->parent_id" :value="$parent->id"
                                    :title="str_repeat('-', $parent->depth) . ' ' . $parent->name"
                                />
                            @endforeach
                        </x-core_base::select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Mô tả'):</label>
                        <textarea name="desc" class="form-control">{{ $data->desc }}</textarea>
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