<?php

namespace App\Notifications;

use App\Models\PushNotification as PushNotificationModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemPushNotification extends Notification
{
    use Queueable;

    public PushNotificationModel $push;

    public function __construct(PushNotificationModel $push)
    {
        $this->push = $push;
    }

    public function via($notifiable): array
    {
        // Database channel for in-app notifications
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->push->title,
            'description' => $this->push->description,
            'image' => $this->push->image ? asset('Notification_images/' . $this->push->image) : null,
            'audience' => $this->push->audience,
            'notification_id' => $this->push->id,
        ];
    }
}
