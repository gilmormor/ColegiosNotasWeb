<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CliAlum extends Model
{
  protected $table="clialum";
  protected $fillable =[
    'id',
    'ced_alum',
    'cli_cedrif'
  ];
}
