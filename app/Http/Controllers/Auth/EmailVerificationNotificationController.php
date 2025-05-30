<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Log;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        Log::log(Log::ACTION_EMAIL_VERIFICATION_NOTIFICATION, [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ], $request->user()->id);

        return back()->with('status', 'verification-link-sent');
    }
}
