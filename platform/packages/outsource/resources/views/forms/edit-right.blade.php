<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            @lang('Hành động')
        </div>
        @if (get_auth_admin()->hasLeaderShipRoleOutsource())
            <div class="card-body p-2">
                <div class="d-flex align-items-center h-100 gap-2">
                    <button type="submit" class="btn btn-primary" title="@lang('save')" name="submitter"
                        value="save">@lang('Lưu')</button>
                </div>
            </div>
        @endif
    </div>

    <div class="card mt-3">
        <div class="card-header">
            @lang('Trạng thái')
        </div>
        <div class="card-body p-2">
            <x-core_base::select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-core_base::select.option :value="$key" :title="$value" :selected="$project->status->value" />
                @endforeach
            </x-core_base::select>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            @lang('Ưu tiên')
        </div>
        <div class="card-body p-2">
            <x-core_base::select name="priority" :required="true">
                @foreach ($priority as $key => $value)
                    <x-core_base::select.option :value="$key" :title="$value" :selected="$project->priority->value" />
                @endforeach
            </x-core_base::select>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            @lang('Phân công team')
        </div>
        <div class="card-body p-2">
            <x-core_base::select class="select2-bs5-ajax-many select2-condition"
                data-condition="select[name='assigns[]']" name="team_id" :data-url="route('outsource.select_team')" :required="true">
                <x-core_base::select.option :selected="$project->team_id" :value="$project->team_id" :title="$project->teamOutsource->name" />
            </x-core_base::select>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            @lang('Phân công')
        </div>
        <div class="card-body p-2">
            <x-core_base::select class="select2-bs5-ajax-many" name="assigns[]" :data-url="route('outsource.select_employee', $project->team_id ?: 0)" :multiple="true">
                @foreach ($project->assigns as $employee)
                    <x-core_base::select.option :selected="$employee->id" :value="$employee->id" :title="$employee->fullname" />
                @endforeach
            </x-core_base::select>
        </div>
    </div>
</div>
