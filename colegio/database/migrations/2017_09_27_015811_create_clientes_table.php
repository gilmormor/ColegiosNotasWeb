<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedrif',12)->unique()->comment('cedula o rif del cliente');
            $table->string('apenom',55)->comment('nombre y apellido del cliente');
            $table->string('direc',150)->comment('Direccion del cliente');
            $table->string('telf',11)->comment('telefono o rif del cliente');
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
        Schema::dropIfExists('clientes');
    }
}
