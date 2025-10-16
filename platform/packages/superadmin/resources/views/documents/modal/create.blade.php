<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('superadmin.document.store')" type="post" :validate="true" data-load-dt="true" data-table-id="document">
                <div class="modal-header">
                    <div class="modal-title">@lang('Thêm')</div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Loại'):</label>
                        <x-core_base::select name="type_id" :required="true">
                            @foreach ($types as $type)
                                <x-core_base::select.option :value="$type->id" :title="str_repeat('-', $type->depth) . ' ' . $type->name" />
                            @endforeach
                        </x-core_base::select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Ngày'):</label>
                        <x-core_base::input type="date" name="document_date" :required="true" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Mô tả'):</label>
                        <textarea name="desc" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Chứng từ'):</label>
                        <x-core_base::input.filepond name="attachments[]" :required="true" :multiple="true" :maxFiles="5" />
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