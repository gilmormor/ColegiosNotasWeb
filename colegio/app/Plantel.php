<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plantel extends Model
{
  protected $table="planteles";
  protected $fillable =[
    'id',
    'est_codigo',
    'nombre'
  ];

  public function estudiantes()
  {
      return $this->hasMany('App\Estudiante','est_placoddea');
  }
}
