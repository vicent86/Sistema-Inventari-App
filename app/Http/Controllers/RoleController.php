<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Permiso;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    public function  index () {
        //return view('usuario.role');
    }

    public function RoleList()
    {

        $role = Role::all();

        return $role;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {


        $request->validate([
            'nombre_role' => 'required|unique:roles,role_name'
        ]);

        $role = new Role;

        $role->nombre_role = $request->nombre_role;

        $role->save();

        return response()->json(['status' => 'success', 'message' => 'Rol creado']);
    }

    public function show($id)
    {

        $menu = Menu::select('id', 'name', 'parent_id')->orderBy('parent_id', 'asc')->get()->toArray();
        $permission = Permiso::where('role_id', '=', $id)->pluck('menu_id')->toArray();



        $menus = [];


        foreach ($menu as $key => $value) {

            if (in_array($value['id'], $permission)) {

                $value['check'] = true;

            } else {

                $value['check'] = false;
            }




            array_push($menus, $value);


        }

        // retorna el menu segun la herencia

        return makeNested($menus);

    }

    public function Permission(Request $request)
    {

        try {

            DB::beginTransaction();
            Permiso::where('role_id', '=', $request->id)->delete();

            // Insertamos el permiso a la tabla permiso
            foreach ($request->menus as $key => $value) {
                //Aqui el menus tiene un submenu
                if (count($value['sub_menu']) > 0) {

                    $flag = 0;

                    foreach ($value['sub_menu'] as $sub_menu) {


                        // sí child es permitido entonces parent tiene que permitirlo
                        if ($sub_menu['check'] == true) {

                            $sub = new Permiso;

                            $sub->role_id = $request->id;
                            $sub->menu_id = $sub_menu['id'];

                            $sub->save();

                            $flag = 1;

                        }

                    }

                    // flag determina si el parent insertará o no el permiso
                    if ($flag == 1) {
                        $menu_per = new Permiso;
                        $menu_per->role_id = $request->id;
                        $menu_per->menu_id = $value['id'];
                        $menu_per->save();

                        $flag = 0;

                    }

                } else {

                    if ($value['check'] == true) {

                        $parent_per = new Permiso;
                        $parent_per->role_id = $request->id;
                        $parent_per->menu_id = $value['id'];
                        $parent_per->save();
                    }

                }

            }

            DB::commit();

            if (Auth::usuario()->role_id == $request->id) {

                Session::forget('side_menu');
                $permited_menu = sideMenu(Auth::usuario()->role_id);
                Session::push('side_menu', $permited_menu);

            }


            return response()->json(['status' => 'success', 'message' => 'New Permission Given']);

        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);



        }

    }

    public function edit(Role $role)
    {
        return $role;
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'role_name' => 'required|unique:roles,role_name'
        ]);

        try {
            $role = Role::find($id);
            $role->role_name = $request->role_name;

            $role->save();

            return response()->json(['status' => 'success', 'message' => 'Rol actualizado']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);

        }

    }

    public function destroy($id)
    {

        try {

            $role = Role::find($id);

            $role->delete();

            return response()->json(['status' => 'success', 'Delete Success!']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'error', '¡Algo salió mal!']);


        }

    }


    // solo para pruebas
    public function userRole()
    {
        $role_id = Auth::usuario()->role_id;


        echo "<pre>";
        print_r(sideMenu($role_id));

        echo "</pre>";
    }
}
