<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'ইমেইল ঠিকানা প্রয়োজন',
            'email.email' => 'সঠিক ইমেইল ঠিকানা দিন',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', 'পাসওয়ার্ড রিসেট লিংক আপনার ইমেইলে পাঠানো হয়েছে।');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => $this->getErrorMessage($status)]);
    }

    /**
     * Get error message based on status.
     */
    protected function getErrorMessage(string $status): string
    {
        return match($status) {
            Password::INVALID_USER => 'এই ইমেইল ঠিকানা দিয়ে কোন ব্যবহারকারী খুঁজে পাওয়া যায়নি।',
            Password::RESET_THROTTLED => 'অনেক চেষ্টা করা হয়েছে। কিছুক্ষণ পর আবার চেষ্টা করুন।',
            default => 'পাসওয়ার্ড রিসেট লিংক পাঠাতে সমস্যা হয়েছে।',
        };
    }
}