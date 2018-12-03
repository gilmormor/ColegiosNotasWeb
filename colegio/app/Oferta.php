<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
  protected $table="oferta";
  protected $fillable =[
    'ofac_numcor',
    'ofac_cedula',
    'ofac_codcar',
    'ofac_codmat',
    'ofac_codalt',
    'ofac_condalum',
    'ofac_condinsc',
    'ofac_seccion',
    'ofac_planest',
    'ofac_semestre',
    'ofac_turno',
    'ofac_anocursa'
  ];
}
