<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatInscrita extends Model
{
  protected $table="matinscritas";
  protected $fillable =[
    'id',
    'periescolar',
    'ced_alum',
    'cod_mat',
    'cod_sec',
    'cond_materia',
    'nota1_1',
    'nota1_1_112',
    'nota1_2',
    'nota1_2_112',
    'nota1_3',
    'nota1_3_112',
    'nota1_4',
    'nota1_4_112',
    'nota1_5',
    'nota1_5_112',
    'letra1',
    'nota1_70',
    'nota1_fl',
    'nota1_fl112',
    'nota1_30',
    'nota1_deflap',
    'inasis1',
    'nota2_1',
    'nota2_1_112',
    'nota2_2',
    'nota2_2_112',
    'nota2_3',
    'nota2_3_112',
    'nota2_4',
    'nota2_4_112',
    'nota2_5',
    'nota2_5_112',
    'letra2',
    'nota2_70',
    'nota2_fl',
    'nota2_fl112',
    'nota2_30',
    'nota2_deflap',
    'inasis2',
    'nota3_1',
    'nota3_1_112',
    'nota3_2',
    'nota3_2_112',
    'nota3_3',
    'nota3_3_112',
    'nota3_4',
    'nota3_4_112',
    'nota3_5',
    'nota3_5_112',
    'letra3',
    'nota3_70',
    'nota3_fl',
    'nota3_fl112',
    'nota3_30',
    'nota3_deflap',
    'inasis3',
    'def'
  ];
  public function cods_ingreso()
  {
      return $this->belongsTo('App\Cod_Ingreso');
  }
  public function materia()
  {
      return $this->belongsTo('App\Materia');
  }
  public function estudiante()
  {
      return $this->belongsTo('App\Estudiante');
  }
}
