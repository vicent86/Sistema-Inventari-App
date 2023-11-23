<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'CIF',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }
    public function producto()
    {
        return $this->hasMany('App\Models\Producto');
    }
    public function pago()
    {
        return $this->hasMany('App\Models\Pago');
    }
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }

}
