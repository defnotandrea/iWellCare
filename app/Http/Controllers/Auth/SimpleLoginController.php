<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SimpleLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.simple-login');
    }

    public function login(Request $request)
    {
        $data = $request->only('username', 'password', 'remember');

        $validator = Validator::make($data, [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->only('username', 'remember'));
        }

        $loginInput = trim((string) $request->input('username'));
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $loginInput,
            'password' => (string) $request->input('password'),
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            Log::warning('Simple login failed', [
                'identifier_field' => $field,
                'identifier' => $loginInput,
                'has_password' => $request->filled('password'),
                'session_id' => $request->session()->getId(),
            ]);
            return back()
                ->withErrors(['username' => 'Invalid username/email or password.'])
                ->withInput($request->only('username', 'remember'));
        }

        $request->session()->regenerate();

        $user = Auth::user();
        Log::info('Simple login success', [
            'user_id' => $user->id,
            'role' => $user->role,
            'session_id' => $request->session()->getId(),
        ]);

        // Redirect to intended URL or unified /dashboard
        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Logged out successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}


