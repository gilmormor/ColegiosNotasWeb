<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('est_exp')->comment('Expediente del alumno');
            $table->string('est_nacionalidad',1)->nullable()->comment('V/E para identificar la nacionalidad del alumno');
            $table->string('est_apellidos',60)->nullable()->comment('Apellidos del Alumno');
            $table->string('est_nombres',60)->nullable()->comment('nombres del Alumno');
            $table->bigInteger('est_ced')->unique()->comment('Cedula del alumno');
            $table->string('est_edocivil',1)->nullable()->comment('Estado Civil del alumno S:soltero C: Casado D: Divorciado V: Viudo O: Otro');
            $table->date('est_feing')->comment('fecha de ingreso a la institucion');
            $table->string('est_sexo',1)->nullable()->comment('sexo del alumno M: Masculino F: Femenino');
            $table->string('est_lugnac',30)->nullable()->comment('Lugar de nacimiento');
            $table->date('est_fecnac')->nullable()->comment('Fecha de Nacimiento');
            $table->integer('est_retirado')->nullable()->comment('Status de Retiro');
            $table->integer('est_asegurado')->nullable()->comment('Status de asegurado');
            $table->integer('est_solvencia')->nullable()->comment('Status de solvencia con el instituto');
            $table->integer('est_solbib')->nullable()->comment('Status de Solvencia con biblioteca');
            $table->string('est_email',100)->nullable()->comment('email');
            $table->string('est_codpais',30)->nullable()->comment('clave foranea del cod del pais de nacimiento');
            //$table->foreign('est_codpais')->references('id')->on('pais')->onDelete('cascade');
            $table->string('est_estnac',60)->nullable()->comment('clave foranea del estado de nacimiento del estudiante');
            //$table->foreign('est_estnac')->references('id')->on('estado')->onDelete('cascade');
            $table->string('est_codmun',100)->nullable()->comment('Clave foranea del cod del municipio');
            //$table->foreign('est_codmun')->references('id')->on('municipio')->onDelete('cascade');
            $table->integer('est_status')->nullable()->comment('estatus de sincronizacion con los dbf 1subido, 0 por bajar');
            $table->integer('est_staemail')->nullable()->comment('Estatus para controlar el envio de correo por lotes, seenvian 350 correos por hora');
            $table->integer('est_tipoparto')->nullable()->comment('Tipo de Parto');
            $table->string('est_placod',10)->nullable()->comment('Codigo Plantel de Procedencia');
            $table->string('est_placoddea',20)->nullable()->comment('Codigo DEA Plantel de Precedencia');
            $table->foreign('est_placoddea')->references('est_codigo')->on('planteles')->onDelete('cascade');
            $table->string('est_paren',15)->nullable()->comment('Parentesco del Representante');
            $table->string('est_callemer',150)->nullable()->comment('Parentesco del Representante');
            $table->string('est_telfemer',40)->nullable()->comment('Telefonos para llamar en caso de emergencia puede meter mas de un telefono');
            $table->integer('est_familia')->nullable();
            $table->string('est_grafam',20)->nullable()->comment('Grado de consanguinidad del familiar');
            $table->integer('est_medtras')->nullable()->comment('Medio de Transporte 1=Particular, 2=Transporte publico');
            $table->integer('est_vivecon')->nullable()->comment('Con quien Vive: 1=Papa, 2=Mama, 3=Otro');
            $table->string('rep_vivecondes',150)->nullable()->comment('Descripcion de la persona con quien vive si es otro');
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
        Schema::dropIfExists('estudiantes');
    }
}
