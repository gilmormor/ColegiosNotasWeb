<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cuotas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('cuotas', function (Blueprint $table) {
          $table->increments('id');
          $table->bigInteger('cuo_cedula');
          $table->Integer('cuo_id');
          $table->Integer('cuo_plan');
          $table->double('cuo_cuota');
          $table->Integer('cuo_trans');
          $table->date('cuo_feccemi');
          $table->date('cuo_fecvnto');
          $table->date('cuo_feccan');
          $table->double('cuo_monto');
          $table->Integer('cuo_status');
          $table->double('cuo_abono');
          $table->double('cuo_saldo');
          $table->Integer('cuo_statusex');
          $table->double('cuo_montoex');
          $table->Integer('cuo_tipoest');
          $table->Integer('cuo_codcarre');
          $table->string('cuo_lapso');
          $table->Integer('cuo_codsed');
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
        //
    }
}
