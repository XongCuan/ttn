<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên'):</label>
                    <x-core_base::input name="name" :value="$team->name" :required="true"
                        :placeholder="__('Tên team')" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Phòng ban'):</label>
                    <x-core_base::select name="department">
                        @foreach ($departments as $key => $value)
                            <x-core_base::select.option :selected="$team->department->value" :value="$key" :title="$value" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Leader'):</label>
                    <x-core_base::select name="leader_id" class="select2-bs5-ajax" data-url="{{ route('superadmin.select_search.admin.employee') }}">
                        @if($team->getLeader())
                            <x-core_base::select.option :selected="$team->leader_id" :value="$team->leader_id" :title="$team->getLeader()->fullname" />
                        @endif
                    </x-core_base::select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-label">@lang('Nhân viên'):</div>
                <div class="row">
                    @foreach ($team->members as $member)
                        @if ($team->isLeader($member) == false)
                            <div class="col-6 col-md-3">
                                <x-core_base::input.checkbox name="member[]" :checked="true" :value="$member->id" :label="$member->fullname" />    
                            </div>                   
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                <div class="form-label">@lang('Chọn thêm nhân viên'):</div>
                <div class="row">
                    @foreach ($employees as $employee)
                        <div class="col-6 col-md-3">
                            <x-core_base::input.checkbox name="member[]" :value="$employee->id" :label="$employee->fullname" />    
                        </div>                   
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>