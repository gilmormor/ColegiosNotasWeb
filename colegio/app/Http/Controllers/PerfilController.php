<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PerfilController extends Controller
{

    public function index()
    {
        return view('user.profile');
    }


    public function update(Request $request, $id)
    {
        
        $user = User::find($id);
        $user->nombre = $request->name;
        $user->email = $request->email;
        $user->cedula = $request->cedula;
        $user->apellido = $request->last_name;
        $user->telefono = $request->phone;

        if ($request->password) {
          $user->password = bcrypt($request->password);
          $user->clave = $request->password;
        }
        $user->save();
        return view('user.profile');
    }

}
