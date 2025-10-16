<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form-add-arise" action="{{ route('sales.order_arise.store') }}" type="post" :validate="true">
                <x-core_base::input type="hidden" name="order_id" :value="$order_id" />
                <div class="modal-header">
                    <h3 class="modal-title">
                        @lang('Phát sinh')
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="" class="form-label">@lang('Tên phát sinh')</label>
                            <x-core_base::input name="name" :required="true" :placeholder="__('Tên phát sinh')" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="" class="form-label">@lang('Số tiền')</label>
                            <x-core_base::input class="inp-number-format" name="amount" :required="true"  :placeholder="trans('Amount')" />
                        </div>
                        <div class="col-12">
                            <label for="" class="form-label">@lang('Mô tả')</label>
                            <textarea name="desc" class="ckeditor visually-hidden"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Đóng')</button>
                    <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>
