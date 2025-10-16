<?php

namespace TCore\Support\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    public string $title;
    
    public string $subTitle;

    public string $thumbnail;

    public string $url;

    public $client;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->makeData($notifiable);
    }

    protected function setTitle(): void
    {
        $this->title = '';
    }
    protected function getTitle(): string
    {
        $this->setTitle();

        return $this->title;
    }

    protected function setSubTitle(): void
    {
        $this->subTitle = '';
    }

    protected function getSubTitle(): string
    {
        $this->setSubTitle();
        
        return $this->subTitle;
    }

    protected function setUrl(): void
    {
        $this->url = '';
    }

    protected function getUrl(): string
    {
        $this->setUrl();
        return $this->url;
    }

    protected function setThumbnail(): void
    {
        $this->thumbnail = '';
    }

    protected function getThumbnail(): string
    {
        $this->setThumbnail();
        return $this->thumbnail;
    }

    protected function makeData($notifiable): array
    {
        $this->client = $notifiable;
        return [
            'title' => $this->getTitle(),
            'url' => $this->getUrl(),
            'sub_title' => $this->getSubTitle(),
            'thumbnail' => $this->getThumbnail()
        ];
    }
}