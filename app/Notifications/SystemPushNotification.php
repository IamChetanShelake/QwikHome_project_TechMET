<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Services\FirebaseService;

class SystemPushNotification extends Notification
{
    use Queueable;

    public $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->notification->title,
            'description' => $this->notification->description,
        ];
    }

    public function sendFirebase($notifiable)
    {
        if ($notifiable->fcm_token) {
            $firebase = new FirebaseService();
            $firebase->sendPush(
                $notifiable->fcm_token,
                $this->notification->title,
                $this->notification->description
            );
        }
    }
}
