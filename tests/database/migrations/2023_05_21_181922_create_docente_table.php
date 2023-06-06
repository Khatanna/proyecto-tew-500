<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docente', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('nombres', 45)->nullable();
            $table->string('apellido_paterno', 30)->nullable();
            $table->string('apellido_materno', 30)->nullable();
            $table->string('ci', 10)->nullable();
            $table->enum('extension_ci', ['lp', 'or', 'pt', 'cb', 'sc', 'bn', 'pa', 'tj', 'ch'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docente');
    }
}
