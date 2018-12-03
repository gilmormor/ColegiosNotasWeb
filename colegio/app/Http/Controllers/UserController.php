<?php

namespace App\Http\Controllers;
use App\Tipo_User;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $type_users = Tipo_User::orderBy('name', 'ASC')->get();
        $users = User::search($request->name)->orderBy('nombre', 'ASC')->paginate(15);
        return view('user.index')->with('type_users', $type_users)->with('users', $users);
    }

    public function store(Request $request){
      $this->validate($request, [
        'Nombre'      =>  'required|min:3|max:50|string',
        'Apellido'    =>  'required|min:3|max:50|string',
        'Email'       =>  'required|min:3|max:50|email|unique:users,email',
        'Password'    =>  'required|min:6|string',
        'Telefono'    =>  'required|min:10|numeric',
        'Cedula'      =>  'required|min:7|numeric|unique:users,cedula',
        'TipoUsuario' =>  'required'
      ]);
      $user = new User();
      $user->nombre = $request->Nombre;
      $user->email = $request->Email;
      $user->password = bcrypt($request->Password);
      $user->clave = $request->Password;
      $user->tipo_id = $request->TipoUsuario;
      $user->cedula = $request->Cedula;
      $user->apellido = $request->Apellido;
      $user->telefono = $request->Telefono;
      $user->est = 'A';
    	$user->save();
      return redirect()->route('users.index');
    }

    public function update(Request $request, $id)
    {
      $user = User::find($id);
      $user->nombre = $request->Nombre;
      if ($request->Email != $user->email) {
        $user->email = $request->Email;
      }

      $user->password = bcrypt($request->Password);
      $user->clave = $request->Password;
      $user->tipo_id = $request->TipoUsuario;
      $user->cedula = $request->Cedula;
      $user->apellido = $request->Apellido;
      $user->telefono = $request->Telefono;
      $user->est = 'A';
      $user->save();
      return redirect()->route('users.index');
    }

    public function destroy($id)
    {
      $user = User::find($id);
      $user->delete();
      return redirect()->route('users.index');
    }
    public function claves()
    {
      $users = User::all();
      for ($i=301; $i <=400 ; $i++) {
        $users[$i]->password =  bcrypt($users[$i]->clave);
        $users[$i]->save();
      }
      return redirect()->route('home');
    }
    public function roles()
    {
      $users = User::all();
      for ($i=801; $i <=1000 ; $i++) {
        $users[$i]->tipo_id =  "6";
        $users[$i]->save();
      }
      return redirect()->route('home');
    }
}
