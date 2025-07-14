<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class MesaPartes extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'personales';

    protected $fillable = [
        'usuario', 'nombre', 'password', 'rol',
    ];

    protected $hidden = ['password'];
}
