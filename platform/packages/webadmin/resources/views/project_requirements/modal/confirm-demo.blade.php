<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-core_base::form class="ajax-modal-form" :action="route('webadmin.project_requirement.handle_confirm_demo')" type="put" :validate="true"
                data-load-dt="true" data-table-id="pRequirementTable">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="modal-header">
                    <div class="modal-title">@lang('Xác nhận')</div>
                </div>
                <div class="modal-body">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">@lang('Hủy')</button>
                    <button type="submit" class="btn btn-primary">
                        @lang('Xác nhận')
                    </button>
                </div>
            </x-core_base::form>
        </div>
    </div>
</div>
