<?php
namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Maskapai;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    use AuthorizesRequests, ValidatesRequests;
}
