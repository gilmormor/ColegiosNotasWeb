<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
  protected $table="materias";
  protected $fillable =['id','cod','des','año'];

  public function carreras()
  {
    return $this->belongsToMany('App\Carrera', 'matercarrera','materia','carrera_id');
  }

  public function materCarreras()
  {
    return $this->hasMany('App\MaterCarrera', 'materia');
  }

  public function materSeccion()
  {
    return $this->hasMany('App\MaterSeccion', 'codmat');
  }

  public function materInscritas()
  {
    return $this->hasMany('App\MatInscrita','cod_mat');
  }
}
