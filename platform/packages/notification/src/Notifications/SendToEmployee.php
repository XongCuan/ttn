<?php

namespace TCore\Notification\Notifications;

use App\Models\NotificationContent;
use TCore\Support\Notifications\BaseNotification;

class SendToEmployee extends BaseNotification
{
    protected NotificationContent $nContent;

    public function __construct(NotificationContent $nContent)
    {
        $this->nContent = $nContent;
    }

    protected function setTitle(): void
    {
        $this->title = $this->nContent->title;
    }

    protected function setUrl(): void
    {
        $this->url = str_replace(url('/'), '', route('notification.notification_content.show', $this->nContent->id));
    }

    protected function setThumbnail(): void
    {
        $this->thumbnail = 'public/images/icon-notification.png';
    }

    public function via($notifiable)
    {
        return ['database'];
    }
}