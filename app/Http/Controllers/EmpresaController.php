<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{
    public function index()
    {
        //$empresa = Empresa::find(1);
        //return view('setting.company_setting',['empresa'=>$empresa]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([

            'nombre' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',

        ]);

        $company = Empresa::find(1);

        $company->nombre = $request->nombre;
        $company->direccion = $request->direccion;
        $company->telefono = $request->telefono;
        $company->update();
        Session::flash('message','Información de la empresa actualizada');
        return redirect()->back();
    }

    public function show(Empresa $empresa)
    {
        //
    }


    public function edit(Empresa $empresa)
    {
        //
    }

    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    public function destroy(Empresa $empresa)
    {
        //
    }
}
