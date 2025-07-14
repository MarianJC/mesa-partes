<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tramite;

class Estudiante extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'estudiantes';

    protected $fillable = [
        'codigo_estudiante',
        'nombre',
        'correo',
        'password',
        'especialidad',
        'dni',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'genero',
    ];

    protected $hidden = ['password'];

    public function tramites()
    {
        return $this->hasMany(Tramite::class);
    }

    public static function generarCodigoEstudiante()
    {
        // Obtener todos los códigos y extraer sus números
        $codigos = self::pluck('codigo_estudiante')->filter()->map(function ($codigo) {
            // Extrae el número: AR-0149 => 149
            return (int) substr($codigo, 3);
        });

        $max = $codigos->max() ?? 0;
        $nuevoNumero = $max + 1;

        return 'AR-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
    }

}
