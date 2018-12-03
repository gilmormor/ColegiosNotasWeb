<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguridad extends Model
{
    protected $table="seguridad";
    protected $fillable =['id','user_email','operacion_id'];
}
