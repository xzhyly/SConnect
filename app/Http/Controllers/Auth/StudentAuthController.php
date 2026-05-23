<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|min:8|confirmed',
            'municipality' => 'required|string',
            'course'       => 'required|string',
            'gwa'          => 'required|numeric|min:1.00|max:5.00',
            'year_level'   => 'required|integer|min:1|max:5',
        ]);

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'municipality' => $request->municipality,
            'course'       => $request->course,
            'gwa'          => $request->gwa,
            'year_level'   => $request->year_level,
            'is_admin'     => false,
        ]);

        // Auto-notify new user with all active matching scholarships
        // Runs immediately after account creation — no need to wait for next sync
        app(NotificationService::class)->dispatchAlertsForUser($user);

        return redirect()->route('login')->with('success', 'Account created! You can now log in.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}