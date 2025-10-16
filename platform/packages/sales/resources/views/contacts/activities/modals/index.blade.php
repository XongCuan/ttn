<div class="modal modal-blur fade modal-load-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">@lang('Danh sách hoạt động')</div>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>@lang('Thời gian')</td>
                            <td>@lang('Mô tả')</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ format_datetime($item->date_time) }}</td>
                                <td>{{ $item->desc }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">@include('core_base::common.norecord')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">@lang('Đóng')</button>
                <button type="button" class="btn btn-primary open-modal-form" data-bs-dismiss="modal" data-route="{{ route('sales.contact.activity.create', $contact_id) }}">
                    @lang('Thêm')
                </button>
            </div>
        </div>
    </div>
</div>