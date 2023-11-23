<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'estado'
    ];

    public function venta()
    {
        return $this->hasMany('App\Models\Venta');
    }

    public function venta_detalles()
    {
        return $this->hasMany('App\Models\VentaDetalles');
    }
}
