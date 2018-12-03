<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresentantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rep_ced')->unique()->comment('cedula del representante');
            $table->string('rep_nac',1)->comment('Nacionalidad')->nullable();
            $table->string('rep_nomrep',50)->comment('Nombre')->nullable();
            $table->string('rep_direcalum',180)->comment('Direccion del Estudiante')->nullable();
            $table->text('rep_dirhabrep')->comment('Direccion de Habitacion');
            $table->text('rep_telhabrep')->comment('Telefono Habitacion');
            $table->string('rep_telcel',22)->comment('Telefono Celular')->nullable();
            $table->string('rep_lugtrarep',80)->comment('Lugar Trabajo')->nullable();
            $table->string('rep_dirtrarep',80)->comment('Direccion de Trabajo')->nullable();
            $table->string('rep_teltrarep',22)->comment('Telefono Trabajo')->nullable();
            $table->string('rep_profrep',150)->comment('Profesion')->nullable();
            $table->string('rep_email',100)->comment('Correo electronico')->nullable();
            $table->string('rep_parentesco',20)->nullable();
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
        Schema::dropIfExists('representantes');
    }
}
