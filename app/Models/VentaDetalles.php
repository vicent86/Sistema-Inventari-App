<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalles extends Model
{
    use HasFactory;
    protected $fillable = [
        'venta_id',
        'producto_id',
        'precio_productio',
        'cantidad',
        'subtotal',
    ];

    public function stock() {
        return $this->belongsTo('App\Models\Stock', 'stock_id');
    }

    public function producto(){
        return $this->belongsTo('App\Models\Producto');
    }

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
