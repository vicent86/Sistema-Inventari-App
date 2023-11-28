<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


    public function usuario()
    {
        return $this->hasMany('App\Models\User');
    }

    public function permisos()
    {
        return $this->belongsToMany('App\Models\Permiso');
    }

}
