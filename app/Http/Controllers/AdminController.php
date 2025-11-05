<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Show admin registration form
     */
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    /**
     * Handle admin registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
        ]);

        try {
            $admin = Admin::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'is_active' => true,
            ]);

            Auth::guard('admin')->login($admin);

            return redirect()->route('admin.dashboard')->with('success', 'Inscription réussie !');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de l\'inscription: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Find admin by email
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => 'Les identifiants sont incorrects.',
            ]);
        }

        if (!$admin->is_active) {
            return back()->withErrors(['email' => 'Votre compte admin est désactivé.'])->withInput();
        }

        Auth::guard('admin')->login($admin);

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))->with('success', 'Connexion réussie !');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $verifiedUsers = User::where('is_verified', true)->count();
        $totalTransactions = Transaction::count();
        $totalBalance = \DB::table('wallets')->sum('balance');

        $recentUsers = User::orderBy('created_at', 'desc')->limit(10)->get();
        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'verifiedUsers',
            'totalTransactions',
            'totalBalance',
            'recentUsers',
            'recentTransactions'
        ));
    }

    /**
     * Show all users
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users', compact('users'));
    }

    /**
     * Show all transactions
     */
    public function transactions()
    {
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Transaction::count(),
            'completed' => Transaction::where('status', 'completed')->count(),
            'pending' => Transaction::where('status', 'pending')->count(),
            'failed' => Transaction::where('status', 'failed')->count(),
        ];

        return view('admin.transactions', compact('transactions', 'stats'));
    }

    /**
     * Show user details
     */
    public function showUser($id)
    {
        $user = User::with(['transactions', 'wallet'])->findOrFail($id);
        return view('admin.user-details', compact('user'));
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Déconnexion réussie !');
    }
}

