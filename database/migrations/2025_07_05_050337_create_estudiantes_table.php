<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_estudiante')->unique();
            $table->string('nombre');
            $table->string('dni', 15)->nullable(); // agregado
            $table->string('telefono', 20)->nullable(); // agregado
            $table->string('direccion', 255)->nullable(); // agregado
            $table->date('fecha_nacimiento')->nullable(); // agregado
            $table->enum('genero', ['masculino', 'femenino'])->nullable();
            $table->string('correo')->unique();
            $table->string('password');
            $table->string('especialidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
}
