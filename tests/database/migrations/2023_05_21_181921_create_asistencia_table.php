<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencia', function (Blueprint $table) {
            $table->integer('id');
            $table->date('Fecha')->nullable();
            $table->enum('asistencia', ['a', 'f', 'p'])->nullable();
            $table->integer('matriculacion_estudiante_id');
            $table->integer('matriculacion_materia_id');
            
            $table->primary(['id', 'matriculacion_estudiante_id', 'matriculacion_materia_id']);
            $table->index(['matriculacion_estudiante_id', 'matriculacion_materia_id'], 'fk_Asistencia_Matriculacion1');
            $table->foreign(['matriculacion_estudiante_id', 'matriculacion_materia_id'], 'fk_Asistencia_Matriculacion1')->references(['estudiante_id', 'materia_id'])->on('matriculacion')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistencia');
    }
}
