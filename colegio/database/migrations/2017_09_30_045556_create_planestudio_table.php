<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanestudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planestudio', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('estu_cod')->comment('Copdigo de plan de estudio');
            $table->string('ESTU_NOMBRE',125)->nullable();
            $table->string('ESTU_MENCION',125)->nullable();
            $table->string('estu_letra',1)->comment('Letra que identifica a la Carrera')->nullable();
            $table->Integer('estu_orden')->comment('Orden en que aparecen los Planes')->nullable();
            $table->string('cod_plan',6)->nullable()->comment('Codigo de Plan de Estudio');
            $table->string('clasif_ano',8)->nullable()->comment('Clasificacion del Año: año, Grado, Nivel');
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
        Schema::dropIfExists('planestudio');
    }
}
