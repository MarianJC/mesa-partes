<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTramitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->string('tipo_tramite');
            $table->string('codigo_seguimiento')->unique();
            $table->string('especialidad');
            $table->string('dni');
            $table->string('correo');
            $table->text('descripcion')->nullable();
            $table->string('archivo'); // nombre del archivo PDF
            $table->enum('estado', ['pendiente', 'rechazado', 'derivado', 'atendido', 'reasignado'])->default('pendiente');
            $table->timestamp('fecha_derivacion')->nullable();
            $table->timestamp('fecha_rechazo')->nullable();
            $table->string('area_destino')->nullable();
            $table->string('area_origen')->nullable();
            $table->string('derivado_por')->nullable();
            $table->text('respuesta')->nullable(); // observaciones o documento generado
            $table->timestamps();

            // Relación con estudiante (si existe)
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tramites');
    }
}
