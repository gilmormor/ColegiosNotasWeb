<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cod_Filtro;
use App\Deposito;
use App\Deposito_sof;
use App\Plantel;
use App\Estado;
use App\Pais;
use App\Estudiante;
use App\Repest;
use App\Representante;
use App\Inscripcion;
use App\Cuota;
use Illuminate\Support\Facades\Auth;

class InscripcionesDeposito extends Controller
{
    public function index(){
      return $this->buscardepositos(0,0,0);
    }

    public function softservi(Request $request){
      $this->Validate($request, [
        'NumeroDepositoSotfservi'    =>  'required|numeric'
      ]);
      $sof = 0;
      $fil = Cod_Filtro::all();
      $dep = Deposito_sof::where('dep_referencia', $request->NumeroDepositoSotfservi)->get();
      if (sizeof($dep) == 0) {
        $sof = 1;
      }else {
        if ($dep[0]->dep_cuenta != $fil[0]->numcuentasoft) {
          $sof = 4;
        }elseif ($dep[0]->dep_fecha < $fil[0]->fecha_dep) {
          $sof = 3;
        }elseif ($dep[0]->dep_status != 0) {
          $sof = 2;
        }else {
          $dep[0]->dep_status = 1;
          $dep[0]->dep_cedula = Auth::user()->cedula;
          $dep[0]->save();
        }
      }
      return $this->buscardepositos($sof,0,0);
    }

    public function colegio(Request $request){
      $this->Validate($request, [
        'NumeroDepositoColegio'    =>  'required|numeric'
      ]);
      $col = 0;
      $fil = Cod_Filtro::all();
      $dep = Deposito::where('dep_referencia', $request->NumeroDepositoColegio)->get();
      if (sizeof($dep) == 0) {
        $col = 1;
      }else {
        if ($dep[0]->dep_cuenta != $fil[0]->numcuentacol) {
          $col = 4;
        }elseif ($dep[0]->dep_fecha < $fil[0]->fecha_dep) {
          $col = 3;
        }elseif ($dep[0]->dep_status != 0) {
          $col = 2;
        }else {
          $dep[0]->dep_status = 1;
          $dep[0]->dep_cedula = Auth::user()->cedula;
          $dep[0]->save();
        }
      }
      return $this->buscardepositos(0,$col,0);
    }

    public function padres(Request $request){
      $this->Validate($request, [
        'NumeroDepositoPadres'    =>  'required|numeric'
      ]);
      $pad = 0;
      $fil = Cod_Filtro::all();
      $dep = Deposito::where('dep_referencia', $request->NumeroDepositoPadres)->get();
      if (sizeof($dep) == 0) {
        $pad = 1;
      }else {
        if ($dep[0]->dep_cuenta != $fil[0]->numcuentapad) {
          $pad = 4;
        }elseif ($dep[0]->dep_fecha < $fil[0]->fecha_dep) {
          $pad = 3;
        }elseif ($dep[0]->dep_status != 0) {
          $pad = 2;
        }else {
          $dep[0]->dep_status = 1;
          $dep[0]->dep_cedula = Auth::user()->cedula;
          $dep[0]->save();
        }
      }
      return $this->buscardepositos(0,0,$pad);
    }

    public function siguiente(Request $request){
      if ($request->vald == 0) {
        Auth::user()->pago = 1;
        Auth::user()->save();
        $date = getdate();
        $time = "".$date['year']."-".$date['mon']."-".$date['mday'];
        $repest = Repest::where('rep_cedrep', Auth::user()->cedula)->get();
        for ($i=0; $i<sizeof($repest) ; $i++) {
          $deuda = Cuota::where('cuo_cedula', $repest[$i]->rep_cedalum)->get();
          for ($j=0; $j<sizeof($deuda) ; $j++) {
            $deuda[$j]->cuo_monto = $deuda[$j]->cuo_saldo;
            $deuda[$j]->cuo_saldo = 0;
            $deuda[$j]->save();
          }
        }
        return redirect()->route('home');
      }
    }

    public function buscardepositos($es, $ec, $ep){
      $filtros = Cod_Filtro::all();
      $hijos = Repest::where('rep_cedrep', Auth::user()->cedula)
          ->join('estudiantes', 'repest.rep_cedalum', '=', 'estudiantes.est_ced')
          ->get();
      //Depositos softservica
      $deps = Deposito_sof::where('dep_cedula', Auth::user()->cedula)
          ->where('dep_cuenta', $filtros[0]->numcuentasoft)
          ->where('dep_status', 1)
          ->where('dep_fecha', '>', $filtros[0]->fecha_dep)
          ->get();
      //Depositos colegio
      $depc = Deposito::where('dep_cedula', Auth::user()->cedula)
          ->where('dep_cuenta', $filtros[0]->numcuentacol)
          ->where('dep_status', 1)
          ->where('dep_fecha', '>', $filtros[0]->fecha_dep)
          ->get();
      //Depositos junta padres
      $depjp = Deposito::where('dep_cedula', Auth::user()->cedula)
          ->where('dep_cuenta', $filtros[0]->numcuentapad)
          ->where('dep_status', 1)
          ->where('dep_fecha', '>', $filtros[0]->fecha_dep)
          ->get();
      $sof = $es;
      $col = $ec;
      $pad = $ep;
      //Cuota
      $date = getdate();
      $time = "".$date['year']."-".$date['mon']."-".$date['mday'];
      $cuotas = 0;
      $repest = Repest::where('rep_cedrep', Auth::user()->cedula)->get();
      for ($i=0; $i<sizeof($repest) ; $i++) {
        $deuda = Cuota::where('cuo_cedula', $repest[$i]->rep_cedalum)->get();
        for ($j=0; $j<sizeof($deuda) ; $j++) {
          $cuotas += $deuda[$j]->cuo_saldo;
        }
      }
      return view('Inscripciones.deposito')
                        ->with('filtros', $filtros)
                        ->with('hijos', $hijos)
                        ->with('deps', $deps)
                        ->with('depc', $depc)
                        ->with('depjp', $depjp)
                        ->with('sof', $sof)
                        ->with('col', $col)
                        ->with('pad', $pad)
                        ->with('cuotas', $cuotas);
    }
}
