<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodsFiltrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filtros', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecinicio')->nullable();
            $table->date('fecfin')->nullable();
            $table->decimal('semestres',10,0)->nullable();
            $table->decimal('sem1',10,0)->nullable();
            $table->decimal('sem2',10,0)->nullable();
            $table->decimal('sem3',10,0)->nullable();
            $table->decimal('sem4',10,0)->nullable();
            $table->decimal('sem5',10,0)->nullable();
            $table->decimal('sem6',10,0)->nullable();
            $table->decimal('sem7',10,0)->nullable();
            $table->decimal('sem8',10,0)->nullable();
            $table->decimal('sem9',10,0)->nullable();
            $table->decimal('sem10',10,0)->nullable();
            $table->decimal('materias',10,0)->nullable();
            $table->decimal('nopendientes',10,0)->nullable();
            $table->decimal('pendientes',10,0)->nullable();
            $table->decimal('estudiantes',10,0)->nullable();
            $table->decimal('nueing',10,0)->nullable();
            $table->decimal('regulares',10,0)->nullable();
            $table->decimal('reingreso',10,0)->nullable();
            $table->string('codlapso',255)->nullable();
            $table->decimal('mtoinsc',10,2)->nullable()->comment('monto minimo de inscripcion');
            $table->decimal('mtoinscmax',10,2)->nullable()->comment('Monto maximo de Inscripcion');
            $table->decimal('mtoconpadres',10,2)->nullable()->comment('Monto minimo Consejo de Padres');
            $table->decimal('mtoconpadresmax',10,2)->nullable()->comment('Monto maximo Consejo de Padres');
            $table->decimal('mtoseguroescolar',10,2)->nullable()->comment('Monto seguro escolar');
            $table->decimal('mntoweb',10,2)->nullable()->comment('Monto minimo inscripcion web');
            $table->decimal('mntowebmax',10,2)->nullable()->comment('Monto maximo inscripcion web');
            $table->decimal('carnet',10,2)->nullable()->comment('Monto minimo carnet');
            $table->decimal('carnetmax',10,2)->nullable()->comment('Monto maximo carnet');
            $table->integer('fechprog')->nullable()->comment('fecha de prorroga o inscripcion fuera de lapso');
            $table->integer('maxuc')->nullable()->comment('Maximas unidades de credito a inscribir');
            $table->integer('choques')->nullable()->comment('permite choques de horarios 0= si , 1=no');
            $table->integer('maxmat')->nullable()->comment('cantidad maxima de materias a inscribir');
            $table->decimal('unidtrib',10,2)->nullable()->comment('precio actual de la unidad tributaria (Seniat)');
            $table->decimal('mtoreing',10,2)->nullable()->comment('Monto por Reingreso');
            $table->date('fecha_dep')->nullable()->comment('A partir de esta fecha busca en depositos');
            $table->dateTime('fecfininsc')->nullable()->comment('Fecha fin inscripciones');
            $table->integer('depsoftservi')->nullable()->comment('Estatus para activar o desactivar pantalla de deposito a Softservica monto de uso de plataforma');
            $table->integer('depcolegio')->nullable()->comment('Estatus para pantalla activar o desactivar pantalla de deposito de inscripcion del colegio');
            $table->integer('depconpadres')->nullable()->comment('Estatus para pantalla activar o desactivar pantalla de deposito sociedad de padres y representantes');
            $table->string('numcuentasoft',20)->nullable()->comment('Num Cuenta Softservi');
            $table->string('numcuentacol',20)->nullable()->comment('Num Cuenta Colegio');
            $table->string('numcuentapad',20)->nullable()->comment('Num Cuante Consejo de Padres');
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
        Schema::dropIfExists('filtros');
    }
}
