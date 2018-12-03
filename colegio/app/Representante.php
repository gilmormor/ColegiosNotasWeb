<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
  protected $table="representantes";
  protected $fillable =[
    'id',
    'rep_ced',
    'rep_nac',
    'rep_nomrep',
    'rep_direcalum',
    'rep_dirhabrep',
    'rep_telhabrep',
    'rep_telcel',
    'rep_lugtrarep',
    'rep_dirtrarep',
    'rep_teltrarep',
    'rep_profrep',
    'rep_email',
    'rep_parentesco'
  ];
}
