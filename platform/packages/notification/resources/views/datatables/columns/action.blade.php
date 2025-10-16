<div style="white-space: nowrap;">
    <button type="button" data-route="{{ route('notification.notification_content.edit', $id) }}"
        class="btn btn-icon btn-success open-modal-form" data-load-dt="true" data-table-id="notificationContent">
        <i class="ti ti-eye"></i>
    </button>
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="notificationContent"
        data-route="{{ route('notification.notification_content.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
</div>
