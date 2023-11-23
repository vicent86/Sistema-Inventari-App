<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    public function logout()
    {
        Auth::logout();
        Session::forget('side_menu');
        return redirect('/');
    }
}
