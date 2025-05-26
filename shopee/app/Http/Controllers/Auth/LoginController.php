<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request): RedirectResponse
    {
        $input = $request->all();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $userType = Auth::user()->type;

            return match ($userType) {
                'admin' => redirect()->route('adminHome'),
                'manager' => redirect()->route('manager.home'),
                default => redirect()->route('home'),
            };
        } else {
            return redirect()->route('login')
                ->with('error', 'Email atau password salah.');
        }
        
    }
}
