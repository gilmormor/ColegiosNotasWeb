<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_User extends Model
{

      protected $table="tipo_user";
      protected $fillable =['id','name','est'];

      public function usuarios()
      {
        return $this->hasMany('App\User','tipo_id');
      }
}
