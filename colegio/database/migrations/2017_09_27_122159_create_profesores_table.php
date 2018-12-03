<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cedula')->unique();
            $table->string('nombre',50)->nullable();
            $table->string('apellido',50)->nullable();
            $table->string('nacionalidad',1)->nullable();
            $table->string('lugnaci',100)->nullable();
            $table->string('sexo',1)->nullable();
            $table->date('fechnaci')->nullable();
            $table->string('dirhabi',150)->nullable();
            $table->string('tlfhabi',50)->nullable();
            $table->string('edocivil',1)->nullable();
            $table->string('menstitu',50)->nullable();
            $table->date('anogrado')->nullable();
            $table->string('tiplantel',50)->nullable();
            $table->string('nomplantel',50)->nullable();
            $table->date('fechingre')->nullable();
            $table->integer('status')->nullable()->comment('1 activo 0 inactivo');
            $table->string('email',100)->nullable();
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
        Schema::dropIfExists('profesores');
    }
}
