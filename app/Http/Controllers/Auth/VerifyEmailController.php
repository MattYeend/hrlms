<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Log;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(
        EmailVerificationRequest $request
    ): RedirectResponse {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                route(
                    'dashboard',
                    absolute: false
                ).'?verified=1'
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            /** @var \Illuminate\Contracts\Auth\MustVerifyEmail $user */
            $user = $request->user();
            event(new Verified($user));
        }

        Log::log(Log::ACTION_EMAIL_VERIFICATION, [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ], $request->user()->id);

        return redirect()->intended(
            route('dashboard', absolute: false).'?verified=1'
        );
    }
}
