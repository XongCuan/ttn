<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            @lang('Hành động')
        </div>
        @if (get_auth_admin()->hasLeaderShipRoleSales())
            <div class="card-body">
                <div class="d-flex align-items-center gap-1 flex-wrap">
                    <small>@lang('Người tạo:')</small>
                    @if($order->creator->fullname())
                        {{ $order->creator->fullname() }}
                        {!! $order->creator->getTeamBadge() !!}
                        {!! $order->creator->getRoleBadge() !!}
                        {!! $order->creator->getDepartmentBadge() !!}
                    @endif
                </div>
            </div> 
            <div class="card-footer d-flex justify-content-between">
                <div class="d-flex align-items-center h-100 gap-2">
                    <button type="submit" class="btn btn-primary" title="@lang('save')" name="submitter" value="save">@lang('Lưu')</button>
                </div>
                
                    <button type="button" class="btn btn-danger open-modal-delete" data-route="{{ route('sales.order.delete', $order->id) }}"  data-target="#modalDelete">
                        <i class="ti ti-trash"></i>
                    </button>
            </div>
        @endif
    </div>

    <div class="card mt-3">
        <div class="card-header">
            @lang('Trạng thái')
        </div>
        <div class="card-body p-2">
            <x-core_base::select name="order[status]" :required="true">
                @foreach ($status as $key => $value)
                    <x-core_base::select.option :selected="$order->status->value" :value="$key" :title="$value" />
                @endforeach
            </x-core_base::select>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            @lang('Ưu tiên')
        </div>
        <div class="card-body p-2">
            <x-core_base::select name="order[priority]" :required="true">
                @foreach ($priority as $key => $value)
                    <x-core_base::select.option :selected="$order->priority->value" :value="$key" :title="$value" />
                @endforeach
            </x-core_base::select>
        </div>
    </div>

    @if (get_auth_admin()->hasManagerShipRoleSales())
        <div class="card mt-3">
            <div class="card-header">
                @lang('Phân công team')
            </div>
            <div class="card-body p-2">
                <x-core_base::select class="select2-bs5-ajax-many select2-condition" data-condition="select[name='assigns[]']" name="order[team_id]" :data-url="route('sales.select_team')">
                    <x-core_base::select.option :selected="$order->team_id" :value="$order->team_id" :title="$order->teamSale->name" />
                </x-core_base::select>
            </div>
        </div>
    @endif
    @if (get_auth_admin()->hasLeaderShipRoleSales())
    <div class="card mt-3">
        <div class="card-header">
            @lang('Phân công')
        </div>
        <div class="card-body p-2">
            <x-core_base::select class="select2-bs5-ajax-many" name="assigns[]" :data-url="route('sales.select_employee', $order->team_id ?: 0)" :multiple="true">
                @foreach ($order->assigns as $employee)
                    <x-core_base::select.option :selected="$employee->id" :value="$employee->id" :title="$employee->fullname" />
                @endforeach
            </x-core_base::select>
        </div>
    </div>
    @endif

    <div class="card mt-3">
        <div class="card-header">
            @lang('Kỹ thuật phụ trách')
        </div>
        <div class="card-body p-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Dự án')</th>
                        <th>@lang('Phụ trách')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>
                                {{ $project->name }}
                                <span @class(['badge', $project->status->badge()])>{{ $project->status->description() }}</span>
                            </td>
                            <td>
                                {{ $project->getTeam()->name }}
                                ( <strong>{{ $project->assigns->pluck('fullname')->implode(', ') }}</strong> )
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted text-center">@lang('Chưa có dữ liệu.')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
