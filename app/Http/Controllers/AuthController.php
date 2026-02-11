<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate login input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Get authenticated user
            $user = Auth::user();

            // Redirect based on role
            return match ($user->role) {
                'admin' => redirect('/dashboard-admin'),
                'petugas' => redirect('/dashboard-petugas'),
                'peminjam' => redirect('/dashboard-peminjam'),
                default => redirect('/dashboard-peminjam'),
            };
        }

        // Authentication failed - redirect back with error
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email or password is incorrect.'
            ]);
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Validate registration input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Create user
        $user = User::create($validated);

        // Automatically login the user
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Redirect to peminjam dashboard
        return match ($user->role) {
                'admin' => redirect('/dashboard-admin'),
                'petugas' => redirect('/dashboard-petugas'),
                'peminjam' => redirect('/dashboard-peminjam'),
                default => redirect('/dashboard-peminjam'),
            };
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
