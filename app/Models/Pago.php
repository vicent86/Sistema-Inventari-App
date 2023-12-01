<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_venta',
        'Importe',
        'fecha_pago',
        'metodo_pago',
    ];

    public function venta(){
        return $this->hasMany('App\Models\Venta', 'id_venta');
    }
}
