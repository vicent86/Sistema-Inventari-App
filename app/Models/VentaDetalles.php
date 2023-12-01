<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalles extends Model
{
    use HasFactory;
    protected $fillable = [
        'producto_id',
        'precio_producto',
        'cantidad',
        'venta_id',
    ];

    public function venta() {
        return $this->hasMany('App\Models\Venta','venta_id');
    }
}
