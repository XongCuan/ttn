@php
    $is_add = isset($is_add) ? $is_add : true; 
@endphp
<div class="col-12 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="fw-bold">@lang('Thông tin phát sinh')</div>
            @if ($order->hasAddArise() && $is_add && get_auth_admin()->hasLeaderShipRoleSales())
                <div class="w-75 text-end">
                    <button type="button" class="btn btn-sm btn-primary open-modal-form" 
                        data-route="{{ route('sales.order_arise.create', $order->id) }}"
                    >
                        <i class="ti ti-plus"></i>
                        @lang('Thêm')
                    </button>
                </div>
            @endif
        </div>
        <div class="card-body">
            <table id="listArise" class="table table-transparent table-responsive mb-0">
                <thead>
                    <tr>
                        <th class="" style="width: 100px">@lang('Hành động')</th>
                        <th>@lang('Thời gian')</th>
                        <th>@lang('Tên phát sinh')</th>
                        <th class="text-end">@lang('Số tiền')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->arises as $arise)
                        <tr>
                            <td>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-icon btn-info open-modal-form" data-route="{{ route('sales.order_arise.show', $arise->id) }}">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                    @if(get_auth_admin()->hasLeaderShipRoleSales())
                                        <button type="button" class="btn btn-sm btn-icon btn-warning open-modal-form" data-route="{{ route('sales.order_arise.edit', $arise->id) }}">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                            <td>{{ format_datetime($arise->created_at) }}</td>
                            <td>{{ $arise->name }}</td>
                            <td class="text-end">{{ number_format($arise->amount) }}</td>
                        </tr>
                    @empty
                        <tr class="norecord">
                            <td class="text-muted text-center" colspan="4">@lang('Chưa có thông tin')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <table class="table table-transparent table-responsive mb-0">
                <thead class="d-none">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" class="fw-bold text-end text-uppercase align-middle">@lang('Tổng phát sinh')</td>
                        <td class="text-end fs-4 align-middle text-danger arise-total" colspan="2">{{ number_format($order->arises->sum('amount')) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
<script>

    $(document).on('submit', '.ajax-modal-form-add-arise', function(e) {
        e.preventDefault();
        resetAjaxFormLibrary();
        AjaxFormLibrary.target = $(this);

        AjaxFormLibrary.beforeSuccess = function(response) {
            location.reload();
        }

        AjaxFormLibrary.ajaxRequest();
    })
</script>
@endpush