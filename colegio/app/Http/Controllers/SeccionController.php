<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterSeccion;
use App\Materia;
use App\Profesor;
use App\Planificacion;

class SeccionController extends Controller
{
    public function index(Request $request)
    {
        //dd($request->name);
        $secciones  = MaterSeccion::search($request->name)
                                  ->OrderBy('codsec','asc')
                                  ->join('materias','materseccion.codmat','=','materias.cod')
                                  ->join('profesores','materseccion.cedprof','=','profesores.cedula')
                                  ->select('materseccion.*', 'materias.cod', 'materias.des','materias.año','profesores.cedula','profesores.nombre','profesores.apellido')
                                  ->paginate(15);
        $materias = Materia::OrderBy('año','asc')->get();
        $profesor = Profesor::OrderBy('nombre','asc')->get();
//        dd($secciones);
        return view('academicos.asignar')
        ->with('profesor',$profesor)
        ->with('materias',$materias)
        ->with('secciones',$secciones);
    }

    public function store(Request $request)
    {
        $letra = strtoupper($request->seccion);
        $sec = $request->año ."".$letra;
        $materias = Materia::where('año',$request->año)->OrderBy('año','asc')->get();
        //dd($materias);

        foreach ($materias as $materia) {
          $seccion  = new MaterSeccion();
          $seccion->codsec    = $sec;
          $seccion->cedprof   = "20717282";
          $seccion->codmat    = $materia->cod;
          $seccion->lapso     = $request->lapso;
          $seccion->capacidad = $request->cap;
          $seccion->save();
        }

        return redirect()->route('secciones.index');
    }

    public function update(Request $request, $id)
    {
      $seccion  =  MaterSeccion::find($id);
      $seccion->lapso     = $request->lapso;
      if ($seccion->cedprof != $request->profesor ) {

        $planificacion = Planificacion::where('pla_docente',$seccion->cedprof)
                                      ->where('pla_secion',$seccion->codsec)
                                      ->where('pla_mat',$seccion->codmat)
                                      ->get();
        for ($i=0; $i <sizeof($planificacion) ; $i++) {
          $planificacion[$i]->pla_docente = $request->profesor;

          $planificacion[$i]->save();
        }
        $seccion->cedprof   = $request->profesor;
      }

      $seccion->capacidad = $request->cap;
      $seccion->save();
      return redirect()->route('secciones.index');
    }

    public function destroy($id)
    {
        $seccion  = MaterSeccion::find($id);
        $seccion->delete();
        return redirect()->route('secciones.index');
    }
}
