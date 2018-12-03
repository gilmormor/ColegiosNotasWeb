<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cod_Filtro;
use App\Estudiante;
use App\Repest;
use App\Colegio;
use Illuminate\Support\Facades\Auth;
class Constancias extends Controller
{
  public function index()
  {

    $estudiantes = Estudiante::orderBy('est_ced', 'ASC')
                   ->join('matinscritas','estudiantes.est_ced','=','matinscritas.ced_alum')
                   ->get();
    $filtros     = Cod_Filtro::all();
    $repres = Repest::where('rep_cedrep', Auth::user()->cedula)
        ->join('estudiantes', 'repest.rep_cedalum', '=', 'estudiantes.est_ced')
        ->join('matinscritas','repest.rep_cedalum','=','matinscritas.ced_alum')
        ->get();
    $secciones = array();
    $colegio  = Colegio::all();
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

    return view('reportes.constancias')
                    ->with('estudiantes', $estudiantes)
                    ->with('repres', $repres)
                    ->with('colegio', $colegio)
                    ->with('fecha',$fecha)
                    ->with('filtros', $filtros);
  }
}
