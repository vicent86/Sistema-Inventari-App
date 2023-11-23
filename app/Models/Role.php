<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->hasMany('App\Models\Usuario');
    }

    public function permisos()
    {
        return $this->belongsToMany('App\Models\Permiso');
    }

}
