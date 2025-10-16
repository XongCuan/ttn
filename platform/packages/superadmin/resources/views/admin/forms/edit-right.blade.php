<div class="col-12 col-md-3">
    <div id="blockSubmit" class="card">
        <div class="card-header">
            @lang('Hành động')
        </div>
        <div class="card-body p-2 d-flex gap-1">
            {!! $admin->getRoleBadge() !!}
            {!! $admin->getDepartmentBadge() !!}
        </div>
        <div class="card-footer d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <button type="submit" class="btn btn-primary" title="@lang('Lưu')" name="submitter" value="save">@lang('Lưu')</button>
                <button type="submit" class="btn" name="submitter" value="saveAndExit">
                    @lang('Lưu và thoát')
                </button>
            </div>
            <button type="button" class="btn btn-danger open-modal-delete" data-route="{{ route('superadmin.admin.delete', $admin->id) }}"  data-target="#modalDelete">
                <i class="ti ti-trash"></i>
            </button>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            @lang('Mức lương/Tháng')
        </div>
        <div class="card-body p-2">
            <x-core_base::input.number name="admin[salary]" min="0" :value="$admin->salary" :placeholder="trans('Mức lương/Tháng')" />
        </div>
    </div>
    @if($admin->canAssignSuperDepartment())
        <div class="card mt-3">
            <div class="card-header">
                @lang('Quản lý cấp cao')
            </div>
            <div class="card-body">
                <small class="text-danger">@lang('Trường này sẽ bỏ qua khi chọn superadmin.')</small>
                <x-core_base::select class="select2-bs5" name="admin[super_department]">
                    @foreach ($super_department as $key => $value)
                        <x-core_base::select.option :selected="$admin->super_department->value" :value="$key" :title="$value" />
                    @endforeach
                </x-core_base::select>
            </div>
        </div>
    @endif

    @if ($admin->canAssignManager())
        <div class="card mt-3">
            <div class="card-header">
                @lang('Quản lý')
            </div>
            <div class="card-body">
                <small class="text-danger">@lang('Trường này sẽ bỏ qua khi chọn quản lý cấp cao hoặc superadmin.')</small>
                <x-core_base::select class="select2-bs5" name="department[]" :multiple="true">
                    @foreach ($departments as $key => $value)
                        <x-core_base::select.option :selected="$manager_departments->toArray()" :value="$key" :title="$value" />
                    @endforeach
                </x-core_base::select>
            </div>
        </div>
    @endif
</div>
