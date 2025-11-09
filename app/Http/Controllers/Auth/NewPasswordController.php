<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required'],
        ], [
            'token.required' => 'অবৈধ টোকেন',
            'email.required' => 'ইমেইল ঠিকানা প্রয়োজন',
            'email.email' => 'সঠিক ইমেইল ঠিকানা দিন',
            'password.required' => 'নতুন পাসওয়ার্ড প্রয়োজন',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না',
            'password_confirmation.required' => 'পাসওয়ার্ড নিশ্চিতকরণ প্রয়োজন',
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'আপনার পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে।');
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
            Password::INVALID_TOKEN => 'অবৈধ টোকেন। নতুন পাসওয়ার্ড রিসেট লিংক চান।',
            default => 'পাসওয়ার্ড পরিবর্তন করতে সমস্যা হয়েছে।',
        };
    }
}