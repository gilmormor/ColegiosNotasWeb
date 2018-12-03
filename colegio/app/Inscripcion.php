<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
  protected $table="inscripciones";
  protected $fillable =[
    'id',
    'insc_codusu',
    'insc_codexp',
    'insc_pensum',
    'insc_semestre',
    'insc_turno',
    'insc_ucred',
    'insc_tipo',
    'insc_stanueing',
    'insc_codplan',
    'insc_codsede',
    'insc_codlapso',
    'insc_codcarr',
    'insc_impresion',
    'insc_rifempresa',
    'insc_codbeca',
    'insc_fecretiro',
    'insc_convenio',
    'insc_documentos',
    'insc_status',
    'insc_fechorbajado',
    'insc_fechor',
    'insc_seguro',
    'insc_bajar'
  ];

  public function Estudiante()
  {
    return $this->hasOne('App\Estudiante');
  }
  public function cod_ingreso()
  {
    return $this->hasOne('App\Cod_Ingreso');
  }
}
