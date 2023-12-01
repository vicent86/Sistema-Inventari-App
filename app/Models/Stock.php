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

    public function producto() {
        return $this->hasMany('App\Models\Producto', 'producto_id');
    }
}
