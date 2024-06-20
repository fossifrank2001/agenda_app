<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Utils\ClassUtil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            // Determine if the login is an email or a phone number
            $isEmail = filter_var($request->login, FILTER_VALIDATE_EMAIL);

            // Base validation rules
            $rules = [
                'login' => 'required|string',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&#]/',
                ],
            ];

            // Add specific validation rules based on login type
            if ($isEmail) {
                $rules['login'] .= '|email';
            } else {
                $rules['login'] .= '|regex:/^6\d{8}$/'; // Phone must start with 6 and be 9 digits long
            }

            $request->validate($rules);

            $credentials = [
                $isEmail ? 'email' : 'phone' => $request->login,
                'password' => $request->password,
            ];

            $userExist = ClassUtil::getUser($request, $isEmail);

            if (!Hash::check($request->password, $userExist->password)) {
                return back()->withErrors([
                    'password' => 'Invalid password.',
                ])->withInput();
            }

            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }

            return back()->withErrors([
                'login' => 'The provided credentials do not match our records.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'login' => 'An unexpected error occurred. Please try again later.',
            ])->withInput();
        }
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login');
    }
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
