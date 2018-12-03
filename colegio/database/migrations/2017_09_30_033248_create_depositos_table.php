<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dep_banco')->comment('codigo del banco emitido por la superintendencia');
            $table->string('dep_cuenta',20)->comment('codigo del banco emitido por la superintendencia');
            $table->string('dep_referencia',10)->comment('Número de la referencia');
            $table->date('dep_fecha')->comment('Fecha en que realizo el deposito');
            $table->double('dep_monto',12,2)->comment('Monto efectivo del depósito');
            $table->double('dep_montocheque',12,2);
            $table->string('dep_neumonico',3)->comment('Código Neumonico del depósito');
            $table->date('dep_fecinscrip')->comment('Fecha en que el estudiante usó el depósito');
            $table->date('dep_fecfact')->comment('Fecha en que se generó la factura');
            $table->Integer('dep_status')->comment('Status del depósito 0: No Utilizado 1: Utilizado en registro 2:Utilizado en la inscripcion.');
            $table->Integer('dep_exp')->comment('Expediente del alumno');
            $table->bigInteger('dep_cedula')->comment('Cédula del estudiante')->nullable();
            $table->foreign('dep_cedula')->references('est_ced')->on('estudiantes')->onDelete('cascade');
            $table->Integer('dep_bajada')->comment('estatus de bajada 0= a no se a bajado; 1= ya se bajo');
            $table->string('dep_lote',9)->comment('numero de lote');
            $table->string('dep_clavconf',6)->comment('clave de conformacion');
            $table->Integer('dep_formapago')->comment('1 Efectivo, 2 Cheque, 3 Depósito, 4 Tarjeta Crédito, 5 Tarjeta Débito, 6 Nota de Crédito, 7 Cuentas por Cobrar, 8 Devolución, 9 Descuento por Nómina, 12 Convenio Sofitasa, 13 Transferencia Electronica');
            $table->date('dep_fechavalor')->nullable()->comment('fecha del movimiento hecho por el usuario');
            $table->string('dep_cajero',10)->nullable()->comment('Num de Cajero: para operaciones por Sofinet (Home Banking) puede ser 0897 u 8048. Todo lo demás es taquilla , cajero automático o punto de venta.');
            $table->Integer('dep_nofacturar')->comment('Estatus para no generar factura en proceso por lotes. 0=Genarar Factura, 1=No se debe Generar Factura');
            $table->decimal('dep_saldo',14,2);
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
        Schema::dropIfExists('depositos');
    }
}
