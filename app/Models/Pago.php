<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'orden_id',
        'importe',
        'fecha_pago',
        'metodo_pago'
    ];

    public function cliente() {
        return $this->belongsTo('App\Models\Cliente');
    }

    public function usuario() {
        return $this ->belongsTo('App\Models\Usuario')->withDefault([
            'id' => 0,
            'nombre' => 'Usuario Desconocido'
        ]);
    }

}
