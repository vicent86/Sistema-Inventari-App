<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioManagementController extends Controller
{
    public function index()
    {
        //return view('usuario.usuario');
    }


    public function UsuarioLista(Request $request)
    {

        $nombre = $request->nombre;
        $email = $request->email;

        $users = Usuario::with('role:id,role_nombre')
            ->orderBy('nombre', 'ASC');

        if ($nombre != '') {

            $users->where('nombre', 'LIKE', '%' . $nombre . '%');
        }

        if ($email != '') {

            $users->where('email', 'LIKE', '%' . $email . '%');
        }

        $users = $users->paginate(10);

        return $users;

    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'nombre_role' => 'required',
            'descripcion' => 'required',
            'role' => 'required',
        ]);

        try {

            $user = new Usuario;

            $user->nombre = $request->nombre;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->nombre_role;
            $user->branch_id = 1;
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Usuario creado']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return $user =  Usuario::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|unique:users,email,'.$id,

        ]);

        try {

            $user =  Usuario::find($id);
            $user->nombre = $request->nombre;
            $user->email = $request->email;
            $user->update();

            return response()->json(['status' => 'success', 'message' => 'Usuario actualizado']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Usuario::find($id);
            $user->delete();
            return response()->json(['status' => 'success', 'message' => 'User Deleted']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);

        }
    }
}
