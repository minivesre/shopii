<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function signout()
    {
        Auth::logout(); // Logout user
        Session::flush(); // Clear session data
        return redirect()->route('login'); // Redirect ke halaman login
    }
}
