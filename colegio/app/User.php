<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'id','nombre', 'email', 'password','clave','tipo_id','cedula','apellido','telefono','est'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tipo()
    {
        return $this->belongsTo('App\Tipo_User');
    }

    public function scopeSearch($query,$name)
    {
      return $query->where('nombre','LIKE',"%$name%");
    }
}
