<div class="col-12 col-md-3">
    <div id="blockSubmit" class="card">
        <div class="card-header">
            @lang('Hành động')
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center gap-1 flex-wrap">
                <small>@lang('Người tạo:')</small>
                @if($data->creator->fullname())
                    {{ $data->creator->fullname() }}
                    {!! $data->creator->getTeamBadge() !!}
                    {!! $data->creator->getRoleBadge() !!}
                    {!! $data->creator->getDepartmentBadge() !!}
                @endif
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <button type="submit" class="btn btn-primary" title="@lang('Lưu')" name="submitter" value="save">@lang('Lưu')</button>
            </div>
            @if (get_auth_admin()->hasLeaderShipRoleMkt())
                <button type="button" class="btn btn-danger open-modal-delete" data-route="{{ route('marketing.contact.delete', $data->id) }}"  data-target="#modalDelete">
                    <i class="ti ti-trash"></i>
                </button>
            @endif
        </div>
    </div>
    @if (get_auth_admin()->hasManagerShipRoleMkt())
        <div class="card mt-3">
            <div class="card-header">
                @lang('Phân công team')
            </div>
            <div class="card-body p-2">
                <x-core_base::select class="select2-bs5-ajax-many select2-condition" data-condition="select[name='assigns[]']" name="team_id" :data-url="route('marketing.select_team')">
                    <x-core_base::select.option :selected="$data->team_id" :value="$data->team_id" :title="$data->teamMkt->name" />
                </x-core_base::select>
            </div>
        </div>
    @endif
    @if (get_auth_admin()->hasLeaderShipRoleMkt())
    <div class="card mt-3">
        <div class="card-header">
            @lang('Phân công')
        </div>
        <div class="card-body p-2">
            <x-core_base::select class="select2-bs5-ajax-many" name="assigns[]" :data-url="route('marketing.select_employee', $data->team_id ?: 0)" :multiple="true">
                @foreach ($data->assigns as $employee)
                    <x-core_base::select.option :selected="$employee->id" :value="$employee->id" :title="$employee->fullname" />
                @endforeach
            </x-core_base::select>
        </div>
    </div>
    @endif
</div>
