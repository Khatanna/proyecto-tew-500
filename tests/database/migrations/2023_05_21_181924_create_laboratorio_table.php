<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio', function (Blueprint $table) {
            $table->integer('id');
            $table->string('nombre', 100)->nullable();
            $table->integer('nota')->nullable();
            $table->date('fecha')->nullable();
            $table->integer('matriculacion_estudiante_id');
            $table->integer('matriculacion_materia_id');
            
            $table->primary(['id', 'matriculacion_estudiante_id', 'matriculacion_materia_id']);
            $table->index(['matriculacion_estudiante_id', 'matriculacion_materia_id'], 'fk_Laboratorio_Matriculacion1');
            $table->foreign(['matriculacion_estudiante_id', 'matriculacion_materia_id'], 'fk_Laboratorio_Matriculacion1')->references(['estudiante_id', 'materia_id'])->on('matriculacion')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratorio');
    }
}
