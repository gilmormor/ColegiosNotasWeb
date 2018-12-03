<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
  protected $table="cuotas";
  protected $fillable =[
    'cuo_cedula',
    'cuo_id',
    'cuo_plan',
    'cuo_cuota',
    'cuo_trans',
    'cuo_feccemi',
    'cuo_fecvnto',
    'cuo_feccan',
    'cuo_monto',
    'cuo_abono',
    'cuo_saldo',
    'cuo_statusex',
    'cuo_montoex',
    'cuo_tipoest',
    'cuo_codcarre',
    'cuo_lapso',
    'cuo_codsed',
    'cuo_fecing'
  ];
}
