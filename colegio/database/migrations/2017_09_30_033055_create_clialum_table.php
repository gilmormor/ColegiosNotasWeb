<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClialumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clialum', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('ced_alum')->nullable()->comment('Cedula del estudiante');
            $table->foreign('ced_alum')->references('est_ced')->on('estudiantes')->onDelete('cascade');
            $table->string('cli_cedrif',12)->nullable()->comment('Cedula o RIF del Cliente');
            $table->foreign('cli_cedrif')->references('cedrif')->on('clientes')->onDelete('cascade');
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
        Schema::dropIfExists('clialum');
    }
}
