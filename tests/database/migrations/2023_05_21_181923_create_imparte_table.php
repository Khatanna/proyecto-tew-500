<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImparteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imparte', function (Blueprint $table) {
            $table->integer('docente_id');
            $table->integer('materia_id');
            
            $table->primary(['docente_id', 'materia_id']);
            $table->foreign('docente_id', 'fk_Docente_has_Materia_Docente1')->references('id')->on('docente')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('materia_id', 'fk_Docente_has_Materia_Materia1')->references('id')->on('materia')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imparte');
    }
}
