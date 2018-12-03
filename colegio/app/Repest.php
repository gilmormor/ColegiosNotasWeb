<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repest extends Model
{
  protected $table="repest";
  protected $fillable =[
    'id',
    'rep_cedalum',
    'rep_cedrep',
    'rep_cedpad',
    'rep_cedmad'
  ];
}
