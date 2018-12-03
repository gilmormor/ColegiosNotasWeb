<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;
use App\MaterSeccion;
use App\Materia;
use App\Planificacion;
use Illuminate\Support\Facades\Auth;

class Planificacion2Controller extends Controller
{

    public function index()
    {
        $user     = Auth::user();
        $profesor = Profesor::where('cedula',$user->cedula)->get();
        $secciones  = MaterSeccion::where('cedprof',$user->cedula)
                                  ->join('materias','materseccion.codmat','=','materias.cod')
                                  ->get();

        return view('evaluaciones.planificacion2')
                  ->with('materias',$secciones);

    }

    public function tabla(Request $request,$id)
    {
      if ($request->ajax()) {
          $user     = Auth::user();
          $array = explode("-", $id);
          $planificacion = Planificacion::where('pla_docente',$user->cedula)
                                        ->where('pla_secion',$array[0])
                                        ->where('pla_mat',$array[1])
                                        ->where('pla_lapso',$array[2])
                                        ->get();
          return response()->json($planificacion);
      }
    }

    public function store(Request $request)
    {
        $user     = Auth::user();
        $array = explode("-", $request->ids);
        $planificaciones = Planificacion::where('pla_docente',$user->cedula)
                                      ->where('pla_secion',$array[0])
                                      ->where('pla_mat',$array[1])
                                      ->where('pla_lapso',$array[2])
                                      ->get();
        if (sizeof($planificaciones) == sizeof($request->ins)) {
          for ($i=0; $i < sizeof($planificaciones) ; $i++) {
            $planificaciones[$i]->pla_docente = $user->cedula;
            $planificaciones[$i]->pla_secion  = $array[0];
            $planificaciones[$i]->pla_mat     = $array[1];
            $planificaciones[$i]->pla_lapso   = $array[2];
            $planificaciones[$i]->pla_ins     = $request->ins[$i];
            $planificaciones[$i]->save();
          }
        }
        if (sizeof($planificaciones) < sizeof($request->ins)) {
          for ($i=0; $i < sizeof($request->ins) ; $i++) {
            if ($i < sizeof($planificaciones)) {
              $planificaciones[$i]->pla_docente = $user->cedula;
              $planificaciones[$i]->pla_secion  = $array[0];
              $planificaciones[$i]->pla_mat     = $array[1];
              $planificaciones[$i]->pla_lapso   = $array[2];
              $planificaciones[$i]->pla_ins     = $request->ins[$i];
              $planificaciones[$i]->save();
            }
            else {
              $planificacion = new Planificacion();
              $planificacion->pla_docente = $user->cedula;
              $planificacion->pla_secion  = $array[0];
              $planificacion->pla_mat     = $array[1];
              $planificacion->pla_lapso   = $array[2];
              $planificacion->pla_ins     = $request->ins[$i];
              $planificacion->save();
            }
          }
        }
        if (sizeof($planificaciones) > sizeof($request->ins)) {
          for ($i=0; $i < sizeof($planificaciones) ; $i++) {
            if ($i < sizeof($request->ins)) {
              $planificaciones[$i]->pla_docente = $user->cedula;
              $planificaciones[$i]->pla_secion  = $array[0];
              $planificaciones[$i]->pla_mat     = $array[1];
              $planificaciones[$i]->pla_lapso   = $array[2];
              $planificaciones[$i]->pla_ins     = $request->ins[$i];
              $planificaciones[$i]->save();
            }
            else {
              $planificaciones[$i]->delete();
            }
          }
        }
        return redirect()->route('planificacion_primaria.index');
    }
}
