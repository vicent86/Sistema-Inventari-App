<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'email',
        'CIF',
        'estado',
        'cualificacion'
    ];

    public function producto() {
        return $this->hasMany('App\Models\Producto','id_proveedor');
    }
}
