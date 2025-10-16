<div class="col-12 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="fw-bold">@lang('Dịch vụ')</div>
            <div class="w-75">
                <div class="input-group">
                    <x-core_base::select name="service_type" :required="true">
                        @foreach ($service_type as $key => $value)
                            <x-core_base::select.option :value="$key" :title="$value" />
                        @endforeach
                    </x-core_base::select>
                    <button type="button" class="btn btn-primary open-modal-add-service" data-route="{{route('sales.order_service.create')}}">@lang('Thêm')</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('packages_sales::orders.services.partials.create-table')
            @include('packages_sales::orders.services.partials.create-table-total')
        </div>
    </div>
</div>

@include('packages_sales::orders.scripts.create-service')