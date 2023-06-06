<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculacion', function (Blueprint $table) {
            $table->integer('estudiante_id');
            $table->integer('materia_id');
            $table->year('gestion', 4)->nullable();
            $table->enum('periodo', ['i', 'ii'])->nullable();
            $table->integer('primer_parcial')->nullable();
            $table->integer('segundo_parcial')->nullable();
            $table->integer('examen_final')->nullable();
            $table->integer('segundo_turno')->nullable();
            
            $table->primary(['estudiante_id', 'materia_id']);
            $table->foreign('estudiante_id', 'fk_Estudiante_has_Materia_Estudiante')->references('id')->on('estudiante')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('materia_id', 'fk_Estudiante_has_Materia_Materia1')->references('id')->on('materia')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculacion');
    }
}
