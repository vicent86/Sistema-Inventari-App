<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'precio',
        'stock',
        'estado',
    ];
    public function categoria(){
        return $this->belongsTo('App\Models\Categoria')->withDefault([
            'id' => 0,
            'nombre' => 'Categoria Desconocida',
        ]);
    }

    public function stock(){
        return $this->hasMany('App\Models\Stock');
    }

    public function venta_detalles(){
        return $this->hasMany('App\Models\VentaDetalles');
    }
}
