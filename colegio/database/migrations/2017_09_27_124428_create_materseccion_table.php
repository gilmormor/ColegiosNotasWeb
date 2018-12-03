<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterseccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materseccion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codsec',100)->default('0')->comment('codigo de la seccion');
            $table->string('codmat',9)->default('132011010')->comment('codigo de la materia');
            $table->foreign('codmat')->references('cod')->on('materias')->onDelete('cascade');
            $table->string('lapso',10)->default('0')->comment('codigo del lapso');
            $table->string('codsede',3)->default('0')->comment('codigo de sede');
            $table->date('fechini')->nullable()->comment('fecha de inicio de la clase');
            $table->date('fechfin')->nullable()->comment('fecha de finalizacion de la clase');
            $table->integer('cedprof')->nullable()->comment('cedula de identidad del profesor asignado a la clase');
            $table->foreign('cedprof')->references('cedula')->on('profesores')->onDelete('cascade');
            $table->integer('capacidad')->nullable()->comment('capacidad de alumnos de la seccion (cupo)');
            $table->integer('activa')->default('1')->comment('Determina si la seccion esta disponible en el proceso de Inscripcion');
            $table->integer('statusvirtual')->default('0')->comment('1=Virtual, 0=Presencial');
            $table->integer('matpen')->default('0')->comment('Status marcar las Sec que solo son para estudiantes con Mat. pediente 0=materia regular, 1=materia pendiente');
            $table->integer('cod_activ')->default('0')->comment('Codigo de ACTIVIDADES COMPLEMENTARIAS');
            $table->integer('nuevoing')->default('0')->comment('Determina si la sección es o no para nuevo ingreso (1 si, 0 no)');
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
        Schema::dropIfExists('materseccion');
    }
}
