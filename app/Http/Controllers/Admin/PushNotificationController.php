<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use App\Models\User;
use App\Notifications\SystemPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $audience = $request->get('audience');

        $query = PushNotification::query()->with('user')->latest();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($audience) {
            $query->where('audience', $audience);
        }

        $notifications = $query->paginate(15);

        return view('admin.notifications.index', compact('notifications', 'search', 'audience'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'audience' => 'required|in:vendor,serviceprovider,user,all',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|file|image|max:4096',
            'send_now' => 'nullable|boolean',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $destDir = public_path('Notification_images');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0777, true);
            }
            $file->move($destDir, $imageName);
        }

        $notification = PushNotification::create([
            'audience' => $validated['audience'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $imageName,
            'created_by' => Auth::id(),
        ]);

        if ($request->boolean('send_now')) {
            $this->dispatchToAudience($notification);
        }

        return redirect()->route('push-notifications.index')->with('success', 'Notification created successfully.');
    }

    public function show(PushNotification $push_notification)
    {
        return view('admin.notifications.show', [
            'notification' => $push_notification->load('creator')
        ]);
    }

    public function edit(PushNotification $push_notification)
    {
        return view('admin.notifications.edit', [
            'notification' => $push_notification
        ]);
    }

    public function update(Request $request, PushNotification $push_notification)
    {
        $validated = $request->validate([
            'audience' => 'required|in:vendor,serviceprovider,user,all',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|file|image|max:4096',
            'send_now' => 'nullable|boolean',
        ]);

        $data = [
            'audience' => $validated['audience'],
            'title' => $validated['title'],
            'description' => $validated['description'],
        ];

        if ($request->hasFile('image')) {
            // delete old file
            if ($push_notification->image) {
                $old = public_path('Notification_images/' . $push_notification->image);
                if (file_exists($old)) @unlink($old);
            }
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $destDir = public_path('Notification_images');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0777, true);
            }
            $file->move($destDir, $imageName);
            $data['image'] = $imageName;
        }

        $push_notification->update($data);

        if ($request->boolean('send_now')) {
            $this->dispatchToAudience($push_notification);
        }

        return redirect()->route('push-notifications.index')->with('success', 'Notification updated successfully.');
    }

    public function destroy(PushNotification $push_notification)
    {
        if ($push_notification->image) {
            $old = public_path('Notification_images/' . $push_notification->image);
            if (file_exists($old)) @unlink($old);
        }
        $push_notification->delete();
        return redirect()->route('push-notifications.index')->with('success', 'Notification deleted successfully.');
    }

    protected function dispatchToAudience(PushNotification $notification): void
    {
        $query = User::query();
        switch ($notification->audience) {
            case 'vendor':
                $query->where('role', 'vendor');
                break;
            case 'serviceprovider':
                $query->where('role', 'serviceprovider');
                break;
            case 'user':
                $query->where('role', 'user');
                break;
            case 'all':
                $query->whereIn('role', ['vendor', 'serviceprovider', 'user']);
                break;
        }

        $query->chunkById(500, function ($users) use ($notification) {
            foreach ($users as $user) {
                $user->notify(new SystemPushNotification($notification));
                (new \App\Notifications\SystemPushNotification($notification))->sendFirebase($user);
            }
        });
    }
}
