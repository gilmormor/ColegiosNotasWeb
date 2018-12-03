<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planificacion extends Model
{
  protected $table="planificacion";
  protected $fillable =[
    'id',
    'pla_docente',
    'pla_secion',
    'pla_mat',
    'pla_por',
    'pla_fecha',
    'pla_lapso',
    'pla_des',
    'pla_ins',
    'pla_tipo',
    'pal_sts'
  ];
}
