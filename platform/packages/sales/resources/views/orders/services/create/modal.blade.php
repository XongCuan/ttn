<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form-add-service" action="{{ route('sales.order_service.store_fake') }}" type="post" :validate="true">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @lang('Dịch vụ :title', ['title' => $service_type->description()])
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('packages_sales::orders.services.create.'.strtolower($service_type->name), [
                        'type' => $service_type->value
                    ])
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Đóng')</button>
                    <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>
