<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->string('titulo');            // "Tu solicitud fue atendida"
            $table->text('mensaje');             // Texto detallado
            $table->string('tipo');              // rechazado, atendido, derivado, etc.
            $table->boolean('leido')->default(false);
            $table->string('link')->nullable();  // Si hay enlace a trámite, respuesta, etc.
            $table->timestamps();

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
        Schema::dropIfExists('notificaciones');
    }
}
