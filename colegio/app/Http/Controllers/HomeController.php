<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cod_Filtro;
use App\Cuota;
use App\Repest;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $filtros = Cod_Filtro::all();
      $date = getdate();
      $time = "".$date['year']."-".$date['mon']."-".$date['mday'];
      $cuotas = 0;
      $repest = Repest::where('rep_cedrep', Auth::user()->cedula)->get();
      for ($i=0; $i<sizeof($repest) ; $i++) {
        $deuda = Cuota::where('cuo_cedula', $repest[$i]->rep_cedalum)
                        ->where('cuo_saldo', '>', '0')
                        ->where('cuo_fecvnto', '<', $time)
                        ->get();
        if (sizeof($deuda) > 0) {
          for ($j=0; $j<sizeof($deuda) ; $j++) {
            $cuotas += $deuda[$j]->cuo_saldo;
          }
        }
      }
      if ($cuotas > 0) {
        Auth::user()->pago = 0;
        Auth::user()->save();
      }
    else {
      Auth::user()->pago = 1;
      Auth::user()->save();
    }
      return view('home')->with('filtros', $filtros);

    }
}
