<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tipo_User;
use App\Menu;
use App\permiso;
class PermisoController extends Controller
{

    public function index()
    {

        $usuarios = User::where('tipo_id','<>', 4)->where('tipo_id', '<>', 6)->get();
        $tipos = Tipo_User::all();
        $menus = Menu::OrderBy('enabled','desc')->OrderBy('parent','asc')->OrderBy('order','asc')->get();

        return view('permisos.index')
        ->with('padres',$menus)
        ->with("usuarios",$usuarios)
        ->with("tipos",$tipos);
    }


    public function menus(Request $request,$id,$tipo)
    {
      if ($request->ajax()) {
          $m = Menu::menu($id,$tipo);
          return response()->json($m);
      }
    }

    public function store(Request $request)
    {
        if ($request->activar) {
          $permisos = permiso::where('user_id', $request->user)->get();
        }
        else {
          $permisos = permiso::where('rol_id', $request->rol)->get();
        }
        $menus =$request->menus;
        for ($i = 0; $i < sizeof($permisos) ; $i++) {
          $borrar = true;
          for ($j = 0; $j < sizeof($menus); $j++) {
            if ($permisos[$i]->menu_id == $menus[$j]) {
              $borrar = false;
            }
          }
          if ($borrar) {
            $permisos[$i]->delete();
          }
        }
        for ($i = 0; $i < sizeof($menus) ; $i++) {
          $agregar = true;
          for ($j = 0; $j < sizeof($permisos); $j++) {
            if ($menus[$i] == $permisos[$j]->menu_id) {
              $agregar = false;
            }
          }
          if ($agregar) {
            $permiso = new permiso();
            if ($request->activar) {
              $permiso->user_id =$request->user;
            }
            else {
              $permiso->rol_id =$request->rol;
            }
            $permiso->menu_id = $menus[$i];
            $permiso->save();
          }
        }
        return redirect()->route('home');
    }
}
