<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColegiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colegios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rif',20)->unique()->comment('RIF del colegio');
            $table->string('nombre',100)->comment('nombre del colegio');
            $table->string('nomcorto',100)->comment('nombre corto del colegio');
            $table->string('codigodea',50)->comment('codigo dea');
            $table->string('convenioavec',50)->comment('convenio con avec');
            $table->string('direccion',200)->comment('direccion del colegio');
            $table->string('telefono',40)->comment('telefono del colegio');
            $table->string('email',100)->comment('email del colegio');
            $table->string('localidad',100)->comment('localidad del colegio');
            $table->string('municipio',100)->comment('municipio del colegio');
            $table->string('zonaeducativa',100)->comment('zonaeducativa del colegio');
            $table->string('cedjefeze',11)->comment('Cedula Jefe Zona Educativa');
            $table->string('nomjefeze',50)->comment('nombre Jefe Zona Educativa');
            $table->string('cedsupervisorze',11)->comment('Cedula Supervisor Zona Educativa');
            $table->string('nomsupervisorze',50)->comment('nombre Supervisor Zona Educativa');
            $table->string('ceddirector',11)->comment('Cedula Director(a) Colegio');
            $table->string('nomdirector',50)->comment('Nombre Director(a) Colegio');
            $table->string('cedevaluador',11)->comment('Cedula de Evaluador Colegio');
            $table->string('nomevaluador',50)->comment('Nombre de Evaluador Colegio');
            $table->string('peresc_act',11)->comment('Periodo Escolar Actual Ejm: 2016-17');
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
        Schema::dropIfExists('colegios');
    }
}
