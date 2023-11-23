<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Usuario extends Model
{
    use HasFactory;
    use Notifiable;

    public function stock(){
        return $this->hasMany('App\Models\Stock');
    }

    public function venta(){
        return $this->hasMany('App\Models\Venta');
    }

    public function pago(){
        return $this->hasMany('App\Models\Pago');
    }

    public function venta_detalles(){
        return $this->hasMany('App\Models\VentaDetalles', 'stock_id');
    }

    public function role() {
        return $this->belongsTo('App\Models\Role')->withDefault([
            'id' => 0,
            'nombre_role' => 'Rol de Invitado',
        ]);
    }


    protected $fillable = [
        'nombre', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
