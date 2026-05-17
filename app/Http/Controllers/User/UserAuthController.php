<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserAuthController extends Controller
{
    /**
     * Show the onboarding screen.
     */
    public function showOnboarding()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('pwa.onboarding');
    }

    /**
     * Show the user login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('pwa.auth.login');
    }

    /**
     * Show the user registration form.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('pwa.auth.register');
    }

    /**
     * Handle a user registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    /**
     * Handle a user login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Check if user is actually a 'user' role
            if (Auth::user()->isUser()) {
                return redirect()->intended(route('user.dashboard'));
            }

            // If an admin tries to login here, we can allow it but redirect to admin dashboard 
            // OR we can restrict this login to only 'user' role.
            // For now, let's allow it but redirect appropriately.
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }
}
