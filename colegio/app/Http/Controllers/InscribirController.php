<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterSeccion;
use App\Estudiante;
use App\MatInscrita;

class InscribirController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::OrderBy('est_nombres','asc')->get();
        $secciones  = MaterSeccion::OrderBy('codsec','asc')
                                  ->join('materias','materseccion.codmat','=','materias.cod')
                                  ->select('materseccion.*', 'materias.cod', 'materias.des','materias.año')
                                  ->get();
        return view('academicos.inscribir')
                   ->with('secciones',$secciones)
                   ->with('estudiantes',$estudiantes);
    }

    public function store(Request $request)
    {
        $seccion    = MaterSeccion::find($request->sec);
        $inscribir = new MatInscrita();
        $inscribir->periescolar = $seccion->lapso;
        $inscribir->ced_alum    = $request->est;
        $inscribir->cod_mat = $seccion->codmat;
        $inscribir->cod_sec = $seccion->codsec;
        $inscribir->cond_materia = "RG";
        $inscribir->nota1_1 = 0;
        $inscribir->nota1_1_112 = 0;
        $inscribir->nota1_2 = 0;
        $inscribir->nota1_2_112 = 0;
        $inscribir->nota1_3 = 0;
        $inscribir->nota1_3_112 = 0;
        $inscribir->nota1_4 = 0;
        $inscribir->nota1_4_112 = 0;
        $inscribir->nota1_5 = 0;
        $inscribir->nota1_5_112 = 0;
        $inscribir->letra1 = "0";
        $inscribir->nota1_70 = 0;
        $inscribir->nota1_fl = 0;
        $inscribir->nota1_fl112 = 0;
        $inscribir->nota1_30 = 0;
        $inscribir->nota1_deflap = 0;
        $inscribir->inasis1 = 0;
        $inscribir->nota2_1 = 0;
        $inscribir->nota2_1_112 = 0;
        $inscribir->nota2_2 = 0;
        $inscribir->nota2_2_112 = 0;
        $inscribir->nota2_3 = 0;
        $inscribir->nota2_3_112 = 0;
        $inscribir->nota2_4 = 0;
        $inscribir->nota2_4_112 = 0;
        $inscribir->nota2_5 = 0;
        $inscribir->nota2_5_112 = 0;
        $inscribir->letra2 = "0";
        $inscribir->nota2_70 = 0;
        $inscribir->nota2_fl = 0;
        $inscribir->nota2_fl112 = 0;
        $inscribir->nota2_30 = 0;
        $inscribir->nota2_deflap = 0;
        $inscribir->inasis2 = 0;
        $inscribir->nota3_1 = 0;
        $inscribir->nota3_1_112 = 0;
        $inscribir->nota3_2 = 0;
        $inscribir->nota3_2_112 = 0;
        $inscribir->nota3_3 = 0;
        $inscribir->nota3_3_112 = 0;
        $inscribir->nota3_4 = 0;
        $inscribir->nota3_4_112 = 0;
        $inscribir->nota3_5 = 0;
        $inscribir->nota3_5_112 = 0;
        $inscribir->letra3 = "0";
        $inscribir->nota3_70 = 0;
        $inscribir->nota3_fl = 0;
        $inscribir->nota3_fl112 = 0;
        $inscribir->nota3_30 = 0;
        $inscribir->nota3_deflap = 0;
        $inscribir->inasis3 = 0;
        $inscribir->def = 0;
        $inscribir->save();
        return redirect()->route('inscribir.index');
    }
    public function indexS()
    {
      $estudiantes = Estudiante::OrderBy('est_nombres','asc')->get();
      $secciones  = MaterSeccion::OrderBy('codsec','asc')
                                ->join('materias','materseccion.codmat','=','materias.cod')
                                ->select('materseccion.*', 'materias.cod', 'materias.des','materias.año')
                                ->get();
      return view('academicos.seccion')
                 ->with('secciones',$secciones)
                 ->with('estudiantes',$estudiantes);
    }

    public function seccion(Request $request)
    {
      $this->validate($request, [
      //  'Estudiante'  =>  'required|unique:matinscritas,ced_alum',
        'Seccion'  =>  'required'
      ]);
      $secciones  = MaterSeccion::where('codsec',$request->Seccion)
                                ->join('materias','materseccion.codmat','=','materias.cod')
                                ->select('materseccion.*', 'materias.cod', 'materias.des','materias.año')
                                ->get();
      foreach ($secciones as $materia) {
        $inscribir = new MatInscrita();
        $inscribir->periescolar = $materia->lapso;
        $inscribir->ced_alum    = $request->Estudiante;
        $inscribir->cod_mat = $materia->codmat;
        $inscribir->cod_sec = $request->Seccion;
        $inscribir->cond_materia = "RG";
        $inscribir->nota1_1 = 0;
        $inscribir->nota1_1_112 = 0;
        $inscribir->nota1_2 = 0;
        $inscribir->nota1_2_112 = 0;
        $inscribir->nota1_3 = 0;
        $inscribir->nota1_3_112 = 0;
        $inscribir->nota1_4 = 0;
        $inscribir->nota1_4_112 = 0;
        $inscribir->nota1_5 = 0;
        $inscribir->nota1_5_112 = 0;
        $inscribir->letra1 = "0";
        $inscribir->nota1_70 = 0;
        $inscribir->nota1_fl = 0;
        $inscribir->nota1_fl112 = 0;
        $inscribir->nota1_30 = 0;
        $inscribir->nota1_deflap = 0;
        $inscribir->inasis1 = 0;
        $inscribir->nota2_1 = 0;
        $inscribir->nota2_1_112 = 0;
        $inscribir->nota2_2 = 0;
        $inscribir->nota2_2_112 = 0;
        $inscribir->nota2_3 = 0;
        $inscribir->nota2_3_112 = 0;
        $inscribir->nota2_4 = 0;
        $inscribir->nota2_4_112 = 0;
        $inscribir->nota2_5 = 0;
        $inscribir->nota2_5_112 = 0;
        $inscribir->letra2 = "0";
        $inscribir->nota2_70 = 0;
        $inscribir->nota2_fl = 0;
        $inscribir->nota2_fl112 = 0;
        $inscribir->nota2_30 = 0;
        $inscribir->nota2_deflap = 0;
        $inscribir->inasis2 = 0;
        $inscribir->nota3_1 = 0;
        $inscribir->nota3_1_112 = 0;
        $inscribir->nota3_2 = 0;
        $inscribir->nota3_2_112 = 0;
        $inscribir->nota3_3 = 0;
        $inscribir->nota3_3_112 = 0;
        $inscribir->nota3_4 = 0;
        $inscribir->nota3_4_112 = 0;
        $inscribir->nota3_5 = 0;
        $inscribir->nota3_5_112 = 0;
        $inscribir->letra3 = "0";
        $inscribir->nota3_70 = 0;
        $inscribir->nota3_fl = 0;
        $inscribir->nota3_fl112 = 0;
        $inscribir->nota3_30 = 0;
        $inscribir->nota3_deflap = 0;
        $inscribir->inasis3 = 0;
        $inscribir->def = 0;
        $inscribir->save();
      }

      return redirect()->route('inscribir.seccion');
    }
}
