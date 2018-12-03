<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
  protected $table="profesores";
  protected $fillable =[
    'id',
    'cedula',
    'nombre',
    'apellido',
    'nacionalidad',
    'lugnaci',
    'sexo',
    'fechnaci',
    'dirhabi',
    'tlfhabi',
    'edocivil',
    'menstitu',
    'anogrado',
    'tiplantel',
    'nomplantel',
    'fechingre',
    'status',
    'email'
  ];

  public function materSeccion()
  {
    return $this->hasMany('App\MaterSeccion', 'cedprof');
  }
}
