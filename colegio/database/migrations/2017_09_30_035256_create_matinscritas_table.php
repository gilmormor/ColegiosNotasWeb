<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatinscritasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matinscritas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('periescolar',9)->comment('Año escolar');
            $table->bigInteger('ced_alum')->comment('Cédula de Estudiante');
            $table->foreign('ced_alum')->references('est_ced')->on('estudiantes')->onDelete('cascade');
            $table->string('cod_mat',9)->comment('Codigo de Materia');
            $table->foreign('cod_mat')->references('cod')->on('materias')->onDelete('cascade');
            $table->string('cod_sec',100)->comment('Codigo de Seccion');
            $table->string('cond_materia',2)->comment('Condición de Inscripcion de Materia. RG=Regular, MP= Materia Pendiente, RP=Repitiente');
            $table->foreign('cond_materia')->references('cod')->on('cods_ingreso')->onDelete('cascade');
            $table->Integer('nota1_1')->comment('Lapso 1 Nota Parcial 1ra Evaluacion');
            $table->Integer('nota1_1_112')->comment('Lapso 1 Nota Parcial 1ra Evaluacion');
            $table->Integer('nota1_2')->comment('Lapso 1 Nota Parcial 2da Evaluacion');
            $table->Integer('nota1_2_112')->comment('Lapso 1 Nota Parcial 2da Evaluacion');
            $table->Integer('nota1_3')->comment('Lapso 1 Nota Parcial 3ra Evaluacion');
            $table->Integer('nota1_3_112')->comment('Lapso 1 Nota Parcial 3ra Evaluacion');
            $table->Integer('nota1_4')->comment('Lapso 1 Nota Parcial 4ta Evaluacion');
            $table->Integer('nota1_4_112')->comment('Lapso 1 Nota Parcial 4ta Evaluacion');
            $table->Integer('nota1_5')->comment('Lapso 1 Nota Parcial 5ta Evaluacion');
            $table->Integer('nota1_5_112')->comment('Lapso 1 Nota Parcial 5ta Evaluacion');
            $table->string('letra1',3)->comment('Rasgos de Personalidad 1er Lapso');
            $table->double('nota1_70',5,2)->comment('Nota del 70% 1er Lapso');
            $table->Integer('nota1_fl')->comment('Evaluacion final de 1er lapso');
            $table->Integer('nota1_fl112')->comment('Evaluacion final de 1er lapso 112');
            $table->double('nota1_30',5,2)->comment('30% 1er Lapso');
            $table->Integer('nota1_deflap')->comment('Nota Definitiva 1er Lapso');
            $table->Integer('inasis1')->comment('Inasistensias 1er Lapso');
            $table->Integer('nota2_1')->comment('Lapso 2 Nota Parcial 1ra Evaluacion');
            $table->Integer('nota2_1_112')->comment('Lapso 2 Nota Parcial 1ra Evaluacion');
            $table->Integer('nota2_2')->comment('Lapso 2 Nota Parcial 2da Evaluacion');
            $table->Integer('nota2_2_112')->comment('Lapso 2 Nota Parcial 2da Evaluacion');
            $table->Integer('nota2_3')->comment('Lapso 2 Nota Parcial 3ra Evaluacion');
            $table->Integer('nota2_3_112')->comment('Lapso 2 Nota Parcial 3ra Evaluacion');
            $table->Integer('nota2_4')->comment('Lapso 2 Nota Parcial 4ta Evaluacion');
            $table->Integer('nota2_4_112')->comment('Lapso 2 Nota Parcial 4ta Evaluacion');
            $table->Integer('nota2_5')->comment('Lapso 2 Nota Parcial 5ta Evaluacion');
            $table->Integer('nota2_5_112')->comment('Lapso 2 Nota Parcial 5ta Evaluacion');
            $table->string('letra2',3)->comment('Rasgos de Personalidad 2do lapso');
            $table->double('nota2_70',5,2)->comment('Nota del 70% 2do Lapso');
            $table->Integer('nota2_fl')->comment('Evaluacion final de 2do lapso');
            $table->Integer('nota2_fl112')->comment('Evaluacion final de 2do lapso 112');
            $table->double('nota2_30',5,2)->comment('30% 2do Lapso');
            $table->Integer('nota2_deflap')->comment('Nota Definitiva 2do Lapso');
            $table->Integer('inasis2')->comment('Inasistensias 2do Lapso');
            $table->Integer('nota3_1')->comment('Lapso 3 Nota Parcial 1ra Evaluacion');
            $table->Integer('nota3_1_112')->comment('Lapso 3 Nota Parcial 1ra Evaluacion');
            $table->Integer('nota3_2')->comment('Lapso 3 Nota Parcial 2da Evaluacion');
            $table->Integer('nota3_2_112')->comment('Lapso 3 Nota Parcial 2da Evaluacion');
            $table->Integer('nota3_3')->comment('Lapso 3 Nota Parcial 3ra Evaluacion');
            $table->Integer('nota3_3_112')->comment('Lapso 3 Nota Parcial 3ra Evaluacion');
            $table->Integer('nota3_4')->comment('Lapso 3 Nota Parcial 4ta Evaluacion');
            $table->Integer('nota3_4_112')->comment('Lapso 3 Nota Parcial 4ta Evaluacion');
            $table->Integer('nota3_5')->comment('Lapso 3 Nota Parcial 5ta Evaluacion');
            $table->Integer('nota3_5_112')->comment('Lapso 3 Nota Parcial 5ta Evaluacion');
            $table->string('letra3',3)->comment('Rasgos de Personalidad 3er lapso');
            $table->double('nota3_70',5,2)->comment('Nota del 70% 3er Lapso');
            $table->Integer('nota3_fl')->comment('Evaluacion final de 3er lapso');
            $table->Integer('nota3_fl112')->comment('Evaluacion final de 3er lapso 112');
            $table->double('nota3_30',5,2)->comment('30% 3er Lapso');
            $table->Integer('nota3_deflap')->comment('Nota Definitiva 3er Lapso');
            $table->Integer('inasis3')->comment('Inasistensias 3er Lapso');
            $table->Integer('def')->comment('Nota Definitiva');
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
        Schema::dropIfExists('matinscritas');
    }
}
