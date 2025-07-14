<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Personal extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'personales';

    protected $fillable = [
        'usuario',
        'nombre',
        'password',
        'rol',
        'dni',
        'telefono',
        'direccion',
        'correo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
