<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
  protected $table="planestudio";
  protected $fillable =[
    'id',
    'estu_cod',
    'ESTU_NOMBRE',
    'ESTU_MENCION',
    'estu_letra',
    'estu_orden',
    'cod_plan',
    'clasif_ano',
  ];
}
