<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cod_Filtro extends Model
{
  protected $table="filtros";
  protected $fillable =[
    'id',
    'fecinicio',
    'fecfin',
    'semestres',
    'sem1',
    'sem2',
    'sem3',
    'sem4',
    'sem5',
    'sem6',
    'sem7',
    'sem8',
    'sem9',
    'sem10',
    'materias',
    'nopendientes',
    'pendientes',
    'estudiantes',
    'nueing',
    'regulares',
    'reingreso',
    'codlapso',
    'mtoinsc',
    'mtoinscmax',
    'mtoconpadres',
    'mtoconpadresmax',
    'mtoseguroescolar',
    'mntoweb',
    'mntowebmax',
    'carnet',
    'carnetmax',
    'fechprog',
    'maxuc',
    'choques',
    'maxmat',
    'unidtrib',
    'mtoreing',
    'fecha_dep',
    'fecfininsc',
    'depsoftservi',
    'depcolegio',
    'depconpadres',
    'numcuentasoft',
    'numcuentacol',
    'numcuentapad'
  ];
}
