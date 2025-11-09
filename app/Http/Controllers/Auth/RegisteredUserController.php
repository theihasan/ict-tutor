<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9+\-\s\(\)]+$/', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required'],
            'institution' => ['nullable', 'string', 'max:255'],
            'class' => ['nullable', 'string', 'max:50'],
            'hsc_year' => ['nullable', 'integer', 'min:2020', 'max:2030'],
            'district' => ['nullable', 'string', 'max:100'],
            'division' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'নাম প্রয়োজন',
            'username.required' => 'ব্যবহারকারীর নাম প্রয়োজন',
            'username.unique' => 'এই ব্যবহারকারীর নাম ইতিমধ্যে ব্যবহৃত হয়েছে',
            'username.regex' => 'ব্যবহারকারীর নামে শুধুমাত্র অক্ষর, সংখ্যা এবং আন্ডারস্কোর ব্যবহার করুন',
            'email.required' => 'ইমেইল প্রয়োজন',
            'email.email' => 'সঠিক ইমেইল ঠিকানা দিন',
            'email.unique' => 'এই ইমেইল ইতিমধ্যে নিবন্ধিত',
            'phone.regex' => 'সঠিক ফোন নম্বর দিন',
            'password.required' => 'পাসওয়ার্ড প্রয়োজন',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না',
            'password_confirmation.required' => 'পাসওয়ার্ড নিশ্চিতকরণ প্রয়োজন',
            'hsc_year.min' => 'HSC বছর ২০২০ বা তার পরে হতে হবে',
            'hsc_year.max' => 'HSC বছর ২০৩০ বা তার আগে হতে হবে',
            'date_of_birth.before' => 'জন্ম তারিখ আজকের আগে হতে হবে',
            'terms.required' => 'শর্তাবলী গ্রহণ করতে হবে',
            'terms.accepted' => 'শর্তাবলী গ্রহণ করতে হবে',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'institution' => $request->institution,
            'class' => $request->class,
            'hsc_year' => $request->hsc_year,
            'district' => $request->district,
            'division' => $request->division,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'level' => 1, // Start at level 1
            'total_points' => 0,
            'current_streak' => 0,
            'longest_streak' => 0,
            'is_active' => true,
            'is_verified' => false,
            'email_notifications' => true,
            'language' => 'bn',
            'timezone' => 'Asia/Dhaka',
            'last_activity_at' => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('student-dashboard')->with('success', 'সফলভাবে নিবন্ধন সম্পন্ন হয়েছে! স্বাগতম!');
    }
}