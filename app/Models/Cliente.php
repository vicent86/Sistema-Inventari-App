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
        'CIF',
        'estado',
    ];

    public function venta(){
        return $this->hasMany('App\Models\Venta','cliente_id');
    }
}
