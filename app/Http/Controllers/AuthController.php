<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        return view('auth.login');
    }

    public function showRegister(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'user',
        ]);

        Auth::login($user);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('login')
            ]);
        }

        return redirect()->route('index');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $redirectPath = ($user->user_type === 'admin')
                ? route('admin.dashboard')
                : route('index');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectPath
                ]);
            }
            if ($user->user_type !== 'admin') {
                $request->session()->forget('url.intended');
                return redirect()->route('index');
            }

            return redirect()->intended($redirectPath);
        }

        if ($request->ajax()) {
            return response()->json([
                'errors' => [
                    'email' => ['These credentials do not match our records.']
                ]
            ], 422);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }


    public function dashboard()
    {
        $userCount = User::count();

        return view('admin.dashboard', compact('userCount'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
