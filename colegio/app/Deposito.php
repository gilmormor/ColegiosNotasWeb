<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
  protected $table="depositos";
  protected $fillable =[
    'id',
    'dep_banco',
    'dep_cuenta',
    'dep_referencia',
    'dep_fecha',
    'dep_monto',
    'dep_montocheque',
    'dep_neumonico',
    'dep_fecinscrip',
    'dep_fecfact',
    'dep_status',
    'dep_exp',
    'dep_cedula',
    'dep_bajada',
    'dep_lote',
    'dep_clavconf',
    'dep_formapago',
    'dep_fechavalor',
    'dep_cajero',
    'dep_nofacturar',
    'dep_saldo'
  ];

  public function estudiante()
  {
    return $this->belongsTo('App\Estudiante');
  }
}
