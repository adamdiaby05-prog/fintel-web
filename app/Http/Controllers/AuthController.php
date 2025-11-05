<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'email' => 'nullable|email|max:255|unique:users,email',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'password' => 'required|string|min:6|confirmed',
            'terms_accepted' => 'required|boolean',
        ]);

        try {
            $user = User::create([
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'hashed_password' => Hash::make($request->password),
                'terms_accepted' => $request->has('terms_accepted'),
                'is_active' => true,
                'is_verified' => false,
            ]);

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Inscription réussie !');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de l\'inscription: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find user by phone_number
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user || !Hash::check($request->password, $user->hashed_password)) {
            throw ValidationException::withMessages([
                'phone_number' => 'Les identifiants sont incorrects.',
            ]);
        }

        if (!$user->is_active) {
            return back()->withErrors(['phone_number' => 'Votre compte est désactivé.'])->withInput();
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))->with('success', 'Connexion réussie !');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnexion réussie !');
    }
}

