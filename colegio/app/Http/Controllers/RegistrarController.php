<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Representante;
use App\User;

class RegistrarController extends Controller
{
  public function index(){
    $error = 0;
    return view('auth.register')->with('error',$error);
  }
  public function store(Request $request){
    $this->validate($request, [
      'cedula'      =>  'required|min:7|max:9|string',
      'password'    =>  'required|min:6|string',
    ]);
    $representante  = Representante::where('rep_ced',$request->cedula)->get();
    $users  = User::where('cedula',$request->cedula)->get();
    //dd($users);
    if (sizeof($representante) != 0  && sizeof($users) == 0 ) {
      $user = new User();
      $user->password = bcrypt($request->password);
      $user->clave = $request->password;
      $user->nombre = $representante[0]->rep_nomrep;
      $user->email = $representante[0]->rep_email;
      $user->cedula = $representante[0]->rep_ced;
      $user->apellido = " ";
      $user->telefono = $representante[0]->rep_teltrarep;
      $user->tipo_id = 6;
      $user->est = 'A';
      $user->save();
      return redirect()->route('registro.datos',$user->cedula);
    }else {
      if (sizeof($representante) == 0) {
        $error = 1;
        return view('auth.register')->with('error',$error);
      }
      if (sizeof($users) > 0) {
        $error = 2;
        return view('auth.register')->with('error',$error);
      }
    }
  }

  public function datos($id)
  {
    //dd($id);
    $u = User::where('cedula',$id)->get();
    //dd($u);
    return view('auth.datos')->with('user',$u);
  }

}
