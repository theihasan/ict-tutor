<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'], // Can be email or username
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'ইমেইল বা ব্যবহারকারীর নাম প্রয়োজন',
            'password.required' => 'পাসওয়ার্ড প্রয়োজন',
        ]);

        // Determine if login is email or username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        // Add is_active check to credentials
        $credentials['is_active'] = true;

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => 'ভুল ইমেইল/ব্যবহারকারীর নাম অথবা পাসওয়ার্ড।',
            ]);
        }

        $request->session()->regenerate();

        // Update last activity
        Auth::user()->update(['last_activity_at' => now()]);

        // Redirect based on user level or intended URL
        $intended = $request->session()->get('url.intended', $this->getRedirectPath());
        
        return redirect()->intended($intended)->with('success', 'সফলভাবে লগইন হয়েছে!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'সফলভাবে লগআউট হয়েছে!');
    }

    /**
     * Get the redirect path after login.
     */
    protected function getRedirectPath(): string
    {
        $user = Auth::user();
        
        // Redirect based on user level
        if ($user->isHighLevel()) {
            return route('admin.dashboard'); // Admin dashboard (if exists)
        }
        
        return route('student-dashboard');
    }
}