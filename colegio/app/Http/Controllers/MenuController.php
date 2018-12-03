<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
class MenuController extends Controller
{

    public function index()
    {
        $menus = Menu::OrderBy('enabled','desc')->OrderBy('parent','asc')->OrderBy('order','asc')->get();
        return view('menus.index')->with('padres',$menus);
    }

    public function iconos()
    {
      return view('menus.iconos');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'Nombre'    =>  'required|min:4|max:150|string',
          'Icono'     =>  'required|min:8|max:50|string',
          'Ruta'      =>  'required|min:1|max:150|string',
          'Orden'     =>  'required|min:0|numeric',
          'Padre'     =>  'required'
        ]);
        $menu = new Menu();
        $menu->name   = $request->Nombre;
        $menu->icon   = $request->Icono;
        $menu->slug   = $request->Ruta;
        $menu->order  = $request->Orden;
        $menu->parent = $request->Padre;
        if ($request->activar) {
          $menu->enabled = "1";
        }
        else {
          $menu->enabled = "0";
        }
        $menu->save();
        return redirect()->route('menus.index');
    }

    public function update(Request $request, $id)
    {
      $this->validate($request,[
        'Nombre'    =>  'required|min:4|max:150|string',
        'Icono'     =>  'required|min:8|max:50|string',
        'Ruta'      =>  'required|min:1|max:150|string',
        'Orden'     =>  'required|min:0|numeric',
        'Padre'     =>  'required'
      ]);
      //dd($request);
        $menu = Menu::find($id);
        $menu->name   = $request->Nombre;
        $menu->icon   = $request->Icono;
        $menu->slug   = $request->Ruta;
        $menu->order  = $request->Orden;
        $menu->parent = $request->Padre;
        if ($request->activar) {
          $menu->enabled = "1";
        }
        else {
          $menu->enabled = "0";
        }
        $menu->save();
        return redirect()->route('menus.index');
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        $menu->delete();
        return redirect()->route('menus.index');
    }
}
