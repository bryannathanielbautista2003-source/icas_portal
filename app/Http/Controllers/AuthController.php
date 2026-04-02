<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin(): View
    {
        return view('login');
    }

    /**
     * Show the registration form.
     */
    public function showRegister(): View
    {
        return view('register');
    }

    /**
     * Handle the registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:student,faculty,admin'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('login')
            ->with('status', 'Registration successful! Please log in with your new account.')
            ->withInput(['email' => $data['email'], 'role' => $data['role']]);
    }

    /**
     * Handle the authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $request->merge(['email' => trim($request->email)]);

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'role'     => ['required', 'in:student,faculty,admin']
        ]);

        $selectedRole = $credentials['role'];
        unset($credentials['role']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== $selectedRole) {
                Auth::logout();
                return back()->withErrors([
                    'email' => "This account is a " . ucfirst($user->role) . ", not a " . ucfirst($selectedRole) . ".",
                ])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->intended($selectedRole . '/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}