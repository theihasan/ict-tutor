<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        return view('auth.profile', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id, 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'regex:/^[0-9+\-\s\(\)]+$/', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'institution' => ['nullable', 'string', 'max:255'],
            'class' => ['nullable', 'string', 'max:50'],
            'hsc_year' => ['nullable', 'integer', 'min:2020', 'max:2030'],
            'district' => ['nullable', 'string', 'max:100'],
            'division' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'email_notifications' => ['nullable', 'boolean'],
            'language' => ['nullable', 'in:bn,en'],
        ], [
            'name.required' => 'নাম প্রয়োজন',
            'username.required' => 'ব্যবহারকারীর নাম প্রয়োজন',
            'username.unique' => 'এই ব্যবহারকারীর নাম ইতিমধ্যে ব্যবহৃত হয়েছে',
            'username.regex' => 'ব্যবহারকারীর নামে শুধুমাত্র অক্ষর, সংখ্যা এবং আন্ডারস্কোর ব্যবহার করুন',
            'email.required' => 'ইমেইল প্রয়োজন',
            'email.email' => 'সঠিক ইমেইল ঠিকানা দিন',
            'email.unique' => 'এই ইমেইল ইতিমধ্যে ব্যবহৃত হয়েছে',
            'phone.regex' => 'সঠিক ফোন নম্বর দিন',
            'bio.max' => 'বায়ো সর্বোচ্চ ৫০০ অক্ষরের হতে পারে',
            'hsc_year.min' => 'HSC বছর ২০২০ বা তার পরে হতে হবে',
            'hsc_year.max' => 'HSC বছর ২০৩০ বা তার আগে হতে হবে',
            'date_of_birth.before' => 'জন্ম তারিখ আজকের আগে হতে হবে',
        ]);

        $user->fill($request->only([
            'name', 'username', 'email', 'phone', 'bio', 'institution', 
            'class', 'hsc_year', 'district', 'division', 'gender', 
            'date_of_birth', 'email_notifications', 'language'
        ]));

        // If email changed, mark as unverified
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->is_verified = false;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'প্রোফাইল সফলভাবে আপডেট হয়েছে।');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required'],
        ], [
            'current_password.required' => 'বর্তমান পাসওয়ার্ড প্রয়োজন',
            'current_password.current_password' => 'বর্তমান পাসওয়ার্ড ভুল',
            'password.required' => 'নতুন পাসওয়ার্ড প্রয়োজন',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না',
            'password_confirmation.required' => 'পাসওয়ার্ড নিশ্চিতকরণ প্রয়োজন',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে।');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'পাসওয়ার্ড নিশ্চিতকরণ প্রয়োজন',
            'password.current_password' => 'ভুল পাসওয়ার্ড',
        ]);

        $user = Auth::user();

        Auth::logout();

        // Soft delete user account by marking as inactive
        $user->update([
            'is_active' => false,
            'email' => $user->email . '_deleted_' . time(),
            'username' => $user->username . '_deleted_' . time(),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'আপনার অ্যাকাউন্ট সফলভাবে মুছে ফেলা হয়েছে।');
    }
}