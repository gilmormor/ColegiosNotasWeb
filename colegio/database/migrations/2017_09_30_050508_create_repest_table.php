<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repest', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('rep_cedalum')->comment('Cedula de Estudiante');
            $table->foreign('rep_cedalum')->references('est_ced')->on('estudiantes')->onDelete('cascade');
            $table->Integer('rep_cedrep')->nullable()->comment('Cedula de Representante');
            $table->foreign('rep_cedrep')->references('rep_ced')->on('representantes')->onDelete('cascade');
            $table->Integer('rep_cedpad')->nullable()->comment('Cedula Padre');
            $table->foreign('rep_cedpad')->references('rep_ced')->on('representantes')->onDelete('cascade');
            $table->Integer('rep_cedmad')->nullable()->comment('Cedula Madre');
            $table->foreign('rep_cedmad')->references('rep_ced')->on('representantes')->onDelete('cascade');
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
        Schema::dropIfExists('repest');
    }
}
