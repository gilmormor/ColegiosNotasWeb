<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cod_Ingreso extends Model
{
  protected $table="cods_ingreso";
  protected $fillable =[
    'id',
    'cod',
    'desc'
  ];
  public function inscripcion()
  {
    return $this->hasOne('App\Inscripcion','insc_tipo');
  }
  public function materInscritas()
  {
    return $this->hasMany('App\MatInscrita','cond_materia');
  }
}
