<?php

namespace App\Http\Controllers;
use App\Tipo_User;
use App\User;
use App\Inscripcion;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
  public function index()
  {
    $cant =Inscripcion::all()->count();
    $users = Inscripcion::join('estudiantes', 'inscripciones.insc_codusu', '=', 'estudiantes.est_ced')
                  ->join('matinscritas','inscripciones.insc_codusu','=','matinscritas.ced_alum')
                  ->orderBy('cod_sec', 'ASC')
                  ->orderBy('insc_codusu', 'ASC')
                //  ->groupBy('matinscritas.cod_sec')
                //  ->groupBy('ced_alum')
                  ->paginate(200);
                //  dd($users[0]);
    return view('reportes.reporte')->with('users', $users)->with('cant', $cant);
  }
}
