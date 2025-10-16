<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            @lang('Hành động')
        </div>
        <div class="card-body p-2">
            <div class="d-flex align-items-center h-100 gap-2">
                <button type="submit" class="btn btn-primary" title="@lang('save')" name="submitter"
                    value="save">@lang('Lưu')</button>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            @lang('Trạng thái')
        </div>
        <div class="card-body p-2">
            <x-core_base::select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-core_base::select.option :value="$key" :title="$value" :selected="$data->status->value" />
                @endforeach
            </x-core_base::select>
        </div>
    </div>

    @if (get_auth_admin()->hasLeaderShipRoleWebadmin())
        <div class="card mt-3">
            <div class="card-header">
                @lang('Phân công team')
            </div>
            <div class="card-body p-2">
                <x-core_base::select class="select2-bs5-ajax-many select2-condition"
                    data-condition="select[name='assigned_by']" name="team_id" :data-url="route('webadmin.select_team')" :required="true">
                    <x-core_base::select.option :selected="$data->team_id" :value="$data->team_id" :title="$data->team->name" />
                </x-core_base::select>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                @lang('Phân công')
            </div>
            <div class="card-body p-2">
                <x-core_base::select class="select2-bs5-ajax-many" name="assigned_by" :data-url="route('webadmin.select_employee', $data->team_id ?: 0)">
                    @if ($data->assigned_by)
                        <x-core_base::select.option :selected="$data->assigned_by" :value="$data->assigned_by" :title="$data->assign->fullname" />
                    @endif
                </x-core_base::select>
            </div>
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-header">
            @lang('Kỹ thuật phụ trách')
        </div>
        <div class="card-body p-2">
            
            @if ($data->project?->isDemo())
                <button type="button" class="btn btn-success open-modal-form mb-3" data-route="{{ route('webadmin.project_requirement.confirm_demo', $data->id) }}">@lang('Duyệt demo')</button>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Dự án')</th>
                        <th>@lang('Phụ trách')</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->project->name)
                    <tr>
                        <td>
                            {{ $data->project->name }}
                            <span @class(['badge', $data->project->status?->badge()])>{{ $data->project->status?->description() }}</span>
                        </td>
                        <td>
                            {{ $data->project->getTeam()->name }}
                            ( <strong>{{ $data->project->assigns?->pluck('fullname')->implode(', ') }}</strong> )
                        </td>
                    </tr>
                    @else
                    <tr>
                       <td colspan="2" class="text-center">@lang('Chưa có thông tin')</td> 
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
