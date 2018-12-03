<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterSeccion extends Model
{
  protected $table="materseccion";
  protected $fillable =[
    'id',
    'codsec',
    'codmat',
    'lapso',
    'codsede',
    'fechini',
    'fechfin',
    'cedprof',
    'capacidad',
    'activa',
    'statusvirtual',
    'matpen',
    'cod_activ',
    'nuevoing'
  ];
  public function materia()
  {
    return $this->belongsTo('App\Materia','cod');
  }
  public function profesor()
  {
    return $this->belongsTo('App\Profesor');
  }

  public function scopeSearch($query,$name)
  {
    return $query->where('codsec','LIKE',"%$name%");
  }
}
