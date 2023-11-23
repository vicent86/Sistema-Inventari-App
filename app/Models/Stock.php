<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'cantidad',
        'ultima_actualizacion',
        'localizacion',
    ];

    public function producto(){
        return $this->belongsTo('App\Models\Producto');
    }

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\Categoria')->withDefault([
            'id' => 0,
            'nombre' => 'Usuario Desconocido'
        ]);
    }

    public function proveedor(){
        return $this->belongsTo('App\Models\Proveedor');
    }

    public function venta_detalles(){
        return $this->hasMany('App\Models\VentaDetalles', 'stock_id');
    }
}
