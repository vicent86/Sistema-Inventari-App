<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ConfiguracionController extends Controller
{
    public function index()
    {
        //return view('configuracion.change_password');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([

            'old_password'=>'required',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',

        ]);

        $old_password = Auth::user()->password;

        if (Hash::check($request->old_password, $old_password)) {

            $user = Usuario::find(Auth::user()->id);

            $user->password = Hash::make($request->password);

            $user->update();

            Session::flash('message','Configuración de contraseña actualizada');

            return redirect()->back();


        }
        else{

            Session::flash('message','Old Password Does Not Match Try Again');
            return redirect()->back();

        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
