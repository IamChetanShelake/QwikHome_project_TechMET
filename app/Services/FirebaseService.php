<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $credentialsPath = base_path(config('firebase.projects.app.credentials'));

        \Log::info('FirebaseService: Initializing Firebase messaging service', [
            'credentials_file' => $credentialsPath,
            'credentials_config' => config('firebase.projects.app.credentials'),
            'project_id' => config('firebase.projects.app.database.url') ?? 'default'
        ]);

        try {
            $factory = (new Factory)
                ->withServiceAccount($credentialsPath);

            $this->messaging = $factory->createMessaging();
            \Log::info('FirebaseService: Firebase messaging service initialized successfully');
        } catch (\Exception $e) {
            \Log::error('FirebaseService: Failed to initialize Firebase messaging service', [
                'error' => $e->getMessage(),
                'credentials_file' => $credentialsPath,
                'file_exists' => file_exists($credentialsPath)
            ]);
            throw $e;
        }
    }

    public function sendPush($token, $title, $body)
    {
        \Log::info('FirebaseService: Preparing to send push notification', [
            'title' => $title,
            'body' => $body,
            'token_length' => strlen($token),
            'token_prefix' => substr($token, 0, 20) . '...'
        ]);

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification);

            \Log::info('FirebaseService: Sending push notification to Firebase');

            $result = $this->messaging->send($message);

            \Log::info('FirebaseService: Push notification sent successfully', [
                'result' => $result,
                'title' => $title,
                'token_prefix' => substr($token, 0, 20) . '...'
            ]);

            return $result;

        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error('FirebaseService: Firebase Messaging Exception', [
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'title' => $title,
                'token_prefix' => substr($token, 0, 20) . '...'
            ]);
            throw $e;

        } catch (\Kreait\Firebase\Exception\FirebaseException $e) {
            \Log::error('FirebaseService: Firebase General Exception', [
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'title' => $title,
                'token_prefix' => substr($token, 0, 20) . '...'
            ]);
            throw $e;

        } catch (\Throwable $th) {
            \Log::error('FirebaseService: Unexpected error sending push notification', [
                'error' => $th->getMessage(),
                'error_type' => get_class($th),
                'title' => $title,
                'token_prefix' => substr($token, 0, 20) . '...',
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
}