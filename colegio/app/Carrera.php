<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
  protected $table="carreras";
  protected $fillable =[
    'id',
    'cod',
    'nombre',
    'codsede',
    'status',
    'nomcorto',
    'inscrip'
  ];

  public function matercarreras()
  {
    return $this->hasMany('App\MaterCarrera', 'carrera_id');
  }
}
