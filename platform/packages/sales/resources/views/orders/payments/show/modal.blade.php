<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    @lang('Thông tin thanh toán')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">@lang('Tên thanh toán')</label>
                        <x-core_base::input name="name" :value="$payment->name" readonly />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="" class="form-label">@lang('Số tiền')</label>
                        <x-core_base::input name="amount" :value="number_format($payment->amount)" readonly />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="" class="form-label">@lang('Thời gian')</label>
                        <x-core_base::input name="amount" :value="format_datetime($payment->created_at)" readonly />
                    </div>
                    <div class="col-12">
                        <label for="" class="form-label">@lang('Mô tả / chứng từ')</label>
                        {!! $payment->desc !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Đóng')</button>
            </div>
        </div>
    </div>
</div>
