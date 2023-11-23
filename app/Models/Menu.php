<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'nombre',
        'pariente_id',
        'menu_url',
        'icono',
        'orden',
        'descripcion'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Menu', 'parent_id');
    }


    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id');
    }
}
