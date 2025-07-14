<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;

class Tramite extends Model
{
    use HasFactory;
    protected $fillable = [
        'estudiante_id',
        'tipo_tramite',
        'especialidad',
        'dni',
        'correo',
        'descripcion',
        'archivo',
        'estado',
        'respuesta',
        'fecha_derivacion', // 👈
        'fecha_rechazo'
    ];

    protected $casts = [
        'fecha_derivacion' => 'datetime',
        'fecha_rechazo' => 'datetime',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

}
