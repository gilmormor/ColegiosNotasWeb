<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
  protected $table="estudiantes";
  protected $fillable =[
    'id',
    'est_exp',
    'est_nacionalidad',
    'est_apellidos',
    'est_nombres',
    'est_ced',
    'est_edocivil',
    'est_feing',
    'est_sexo',
    'est_lugnac',
    'est_fecnac',
    'est_retirado',
    'est_asegurado',
    'est_solvencia',
    'est_solbib',
    'est_email',
    'est_codpais',
    'est_estnac',
    'est_codmun',
    'est_status',
    'est_staemail',
    'est_tipoparto',
    'est_placod',
    'est_placoddea',
    'est_paren',
    'est_callemer',
    'est_telfemer',
    'est_familia',
    'est_grafam',
    'est_medtras',
    'est_vivecon',
    'rep_vivecondes'
  ];

  public function plantel()
  {
    return $this->belongsTo('App\Plantel');
  }

  public function clientes()
  {
    return $this->belongsToMany('App\Cliente', 'clialum','ced_alum','cli_cedrif');
  }
  public function depositos()
  {
    return $this->hasMany('App\Deposito','dep_cedula');
  }

  public function inscripcion()
  {
    return $this->hasOne('App\Inscripcion','insc_codusu');
  }
  public function materInscritas()
  {
    return $this->hasMany('App\MatInscrita','ced_alum');
  }
  

}
