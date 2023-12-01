<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'precio_total',
        'fecha_venta',
    ];

    public function cliente() {
        return $this->hasMany('App\Models\Cliente','cliente_id');
    }

    public function pago() {
        return $this->hasMany('App\Models\Pago','id_venta');
    }

    public function ventaDetalles() {
        return $this->hasMany('App\Models\VentaDetalles', 'venta_id');
    }
}
