<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected  $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'estado',
        'id_proveedor',
        'IVA',
    ];


    public function categoria(){
        return $this->hasMany('App\Models\Categoria', 'categoria_id');
    }

    public function proveedor(){
        return $this->hasMany('App\Models\Proveedor', 'id_proveedor');
    }
    public function ventaDetalles(){
        return $this->hasMany('App\Models\VentaDetalles');
    }

    public function stock() {
        return $this->hasMany('App\Models\Stock');
    }


}
