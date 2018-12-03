<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colegio extends Model
{
  protected $table="colegios";
  protected $fillable =[
    'id',
    'rif',
    'nombre',
    'nomcorto',
    'codigodea',
    'convenioavec',
    'direccion',
    'telefono',
    'email',
    'localidad',
    'municipio',
    'zonaeducativa',
    'cedjefeze',
    'nomjefeze',
    'cedsupervisorze',
    'nomsupervisorze',
    'ceddirector',
    'nomdirector',
    'cedevaluador',
    'nomevaluador',
    'peresc_act'
  ];
}
