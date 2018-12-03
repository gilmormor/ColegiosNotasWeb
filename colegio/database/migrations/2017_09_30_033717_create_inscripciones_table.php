<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('insc_codusu')->nullable()->comment('clave foranea del codigo del usuario');
            $table->foreign('insc_codusu')->references('est_ced')->on('estudiantes')->onDelete('cascade');
            $table->Integer('insc_codexp')->nullable()->comment('codigo del expediente');
            $table->decimal('insc_pensum',10,0)->nullable()->comment('pensum de la carrera');
            $table->decimal('insc_semestre',10,0)->nullable()->comment('Semestre asignado (Donde tenga más créditos)');
            $table->string('insc_turno',2)->nullable()->comment('Turno asignado: M=Ma#ana T=Tarde N=Noche');
            $table->Integer('insc_ucred')->nullable()->comment('unidades de credito inscritas');
            $table->string('insc_tipo',2)->nullable()->comment('tipo de inscripcion (Nuevo ingr "N". Regular "R", Equiv Interna  "I", equiv Exter "E"');
            $table->foreign('insc_tipo')->references('cod')->on('cods_ingreso')->onDelete('cascade');
            $table->Integer('insc_stanueing')->nullable()->comment('Estatus si el estudiante es Nuevo Ingreso');
            $table->string('insc_codplan',2)->nullable()->comment('clave foranea del còdigo del plan');
            $table->decimal('insc_codsede',10,0)->nullable()->comment('clave foranea del codigo de la sede');
            $table->string('insc_codlapso',7)->nullable()->comment('clave foranea del cod de lapso');
            $table->Integer('insc_codcarr')->nullable()->comment('clave foranea del codigo de la carrera');
            //$table->foreign('insc_codcarr')->references('cod')->on('carreras')->onDelete('cascade');
            $table->Integer('insc_impresion')->nullable()->comment('Status para controlar la impresion del comprobante');
            $table->string('insc_rifempresa',9)->nullable()->comment('RIF de la empresa a la que se emite la factura por pago de cuotas de estudiante');
            $table->decimal('insc_codbeca',10,0)->nullable()->comment('clave fornanea del código de la beca, en caso de poseerla');
            $table->date('insc_fecretiro')->nullable()->comment('Fecha de retiro del semestre');
            $table->Integer('insc_convenio')->nullable()->comment('Estatus para saber si tiene convenio sofitasa');
            $table->decimal('insc_documentos',10,0)->nullable()->comment('Aplica para estudiantes nuevos. Al entregar los documentos se reflejará mediante este campo');
            $table->Integer('insc_status')->comment('Estatus de bajada a la base de datos VFP, 0= no se ha bajado, 1= ya se bajo');
            $table->datetime('insc_fechorbajado')->nullable();
            $table->datetime('insc_fechor')->nullable();
            $table->Integer('insc_seguro')->nullable()->comment('1 si pago seguro 2 no pago seguro');
            $table->integer('insc_bajar')->nullable()->comment('Estatus para bajar Inscripcion 1=bajar, 0=no bajar');
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
        Schema::dropIfExists('inscripciones');
    }
}
