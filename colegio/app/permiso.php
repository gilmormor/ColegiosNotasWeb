<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class permiso extends Model
{
    protected $table="permisos";
    protected $fillable =['id','user_id','rol_id','menu_id'];



    public function rol($id)
    {
        return $this->where('rol_id', $id)
            ->get();
    }
    public function user($id)
    {
        return $this->where('user_id', $id)
            ->get();
    }

}
