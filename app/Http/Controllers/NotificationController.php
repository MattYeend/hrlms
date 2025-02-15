<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class NotificationController extends Controller
{
    public function index() 
    {
        $notifications = auth()->user()->notifications;
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id) 
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead() 
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function sendNotification(Request $request) 
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->notify(new UserNotification('custom', $request->title, null, null, ['message' => $request->message]));

        return redirect()->back()->with('success', 'Notification sent successfully.');
    }
}
