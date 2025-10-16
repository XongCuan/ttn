<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">@lang('Thông tin')</div>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>@lang('Tên dự án')</th>
                            <th>@lang('Trạng thái')</th>
                            <th>@lang('Team')</th>
                            <th>@lang('Người phụ trách')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td><span @class(['badge', $item->status->badge()])>{{ $item->status->description() }}</span></td>
                                <td>{{ $item->getTeam()->name }}</td>
                                <td>{{ $item->assigns->pluck('fullname')->implode(', ') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted text-center">@lang('Chưa có dữ liệu.')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">@lang('Hủy')</button>
            </div>
        </div>
    </div>
</div>