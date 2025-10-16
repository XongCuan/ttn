<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <x-core_base::form action="{{ route('sales.order_payment.update') }}" type="put" :validate="true">
                <x-core_base::input name="id" :value="$payment->id" type="hidden" />
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Thêm đợt thanh toán')
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="" class="form-label">@lang('Tên thanh toán')</label>
                            <x-core_base::input name="name" :value="$payment->name" :required="true" :placeholder="__('Tên thanh toán')" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="" class="form-label">@lang('Số tiền')</label>
                            <x-core_base::input class="inp-number-format" name="amount" :value="number_format($payment->amount)" :required="true"  :placeholder="trans('Amount')" />
                        </div>
                        <div class="col-12">
                            <label for="" class="form-label">@lang('Mô tả / chứng từ')</label>
                            <textarea name="desc" class="ckeditor visually-hidden">{!! $payment->desc !!}</textarea>
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
