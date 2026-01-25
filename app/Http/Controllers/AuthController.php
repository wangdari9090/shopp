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
        'role' => 'user',
    ]);

    Auth::login($user);

    // Check if the request is AJAX
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
    // 1. Validate inputs
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 2. Attempt Login
    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        // 3. Determine redirect path based on user role
        // Note: Make sure 'role' matches your database column name
        $redirectUrl = Auth::user()->role === 'admin' 
                        ? route('admin.dashboard') 
                        : route('index');

        // 4. Return JSON for AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl
            ], 200);
        }

        return redirect()->intended($redirectUrl);
    }


    // Inside login() after Auth::attempt is successful:
if (Auth::user()->cart_data) {
    session()->put('cart', Auth::user()->cart_data);
}

// Inside logout() before Auth::logout():
if (Auth::check()) {
    $user = Auth::user();
    $user->cart_data = session()->get('cart'); // Save current session to DB
    $user->save();
}
    // 5. Handle Failed Login for AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => false,
            'errors' => [
                'email' => ['The provided credentials do not match our records.']
            ]
        ], 422);
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}
    public function dashboard()
    {
        // Example: count users for dashboard
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
