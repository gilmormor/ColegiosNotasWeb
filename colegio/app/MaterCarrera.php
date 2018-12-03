<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterCarrera extends Model
{
  protected $table="matercarrera";
  protected $fillable =[
    'id',
    'carrera_id',
    'mac_pensum',
    'mac_consecutivo',
    'materia',
    'mac_comun',
    'mac_tipomat',
    'mac_tiponota',
    'mac_prelacreditos',
    'mac_corteunico',
    'mac_ucredito',
    'mac_horasem',
    'mac_horasprac',
    'mac_codsoft',
    'mac_status'
  ];
  public function carrera()
  {
      return $this->belongsTo('App\Carrera');
  }
  public function materia()
  {
      return $this->belongsTo('App\Materia');
  }

}
