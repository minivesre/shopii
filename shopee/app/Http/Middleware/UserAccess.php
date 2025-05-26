<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAccess
{
    public function handle(Request $request, Closure $next, $userType): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (!in_array(Auth::user()->type, explode(',', $userType))) {
            // Redirect daripada langsung JSON
            return redirect('/login')->with('error', 'Kamu tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
