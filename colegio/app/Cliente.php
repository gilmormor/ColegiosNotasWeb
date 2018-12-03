<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
  protected $table="clientes";
  protected $fillable =[
    'id',
    'cedrif',
    'apenom',
    'direc',
    'telf'
  ];

  public function estudiantes()
  {
    return $this->belongsToMany('App\Estudiante', 'clialum','cli_cedrif','ced_alum');
  }
}
