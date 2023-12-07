<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Usuario extends Model
{
    use HasFactory;
    use Notifiable;


    protected $fillable = [
        'nombre', 'email', 'password','role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
