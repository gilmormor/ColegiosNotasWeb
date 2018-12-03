<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('pla_docente')->nullable()->comment('id del docente');
            $table->string('pla_secion',50)->nullable()->comment('id de la seccion');
            $table->string('pla_mat',50)->nullable()->comment('materia');
            $table->string('pla_por',50)->nullable()->comment('porcentaje de examen');
            $table->datetime('pla_fecha')->nullable()->comment('fecha de la evalucion');
            $table->string('pla_lapso',2)->nullable()->comment('corte del examen');
            $table->string('pla_des',50)->nullable()->comment('objetivo evaluado');
            $table->string('pla_ins',50)->nullable()->comment('instrumento de evaluacion');
            $table->Integer('pla_tipo')->nullable()->comment('1 acumulativa 2 parcial, 3 cuantificativa');
            $table->Integer('pal_sts')->nullable()->comment('0 exite 1 no exite 2 cerrado lapso');
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
        Schema::dropIfExists('planificacion');
    }
}
