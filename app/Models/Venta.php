<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'producto_id',
        'cantidad',
        'precio_total',
        'fecha_venta'
    ];

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\Usuario')->withDefault([
            'id' => 0,
            'nombre' => 'Usuario Desconocido'
        ]);
    }
}
