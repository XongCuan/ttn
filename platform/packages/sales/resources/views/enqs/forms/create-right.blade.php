<div class="col-12 col-md-2">
    <div id="blockSubmit" class="card">
        <div class="card-header">
            @lang('Hành động')
        </div>
        <div class="card-body p-2">
            <div class="d-flex align-items-center h-100 gap-2">
                <button type="submit" class="btn btn-primary" title="@lang('Lưu')" name="submitter"
                    value="save">@lang('Lưu')</button>
            </div>
        </div>
    </div>
    {{-- @if (get_auth_admin()->hasManagerShipRoleSales())
    <div class="card mt-3">
        <div class="card-header">
            @lang('Phân công team')
        </div>
        <div class="card-body p-2">
            <x-core_base::select class="select2-bs5-ajax-many select2-condition"
                data-condition="select[name='assigns[]']" name="team_id" :data-url="route('sales.select_team')">
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
            <x-core_base::select class="select2-bs5-ajax-many" name="assigns[]"
                :data-url="route('sales.select_employee', 0)" :multiple="true">
            </x-core_base::select>
        </div>
    </div>
    @endif --}}
</div>