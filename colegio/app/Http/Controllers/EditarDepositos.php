<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deposito_sof;
use App\Deposito;
use App\Colegio;

class EditarDepositos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paso = 0;
        return view('administrativo.editarsof')->with('paso', $paso);
    }

    public function tables(Request $request, $id){
      if ($request->ajax()) {
        $falla = 0;
        $refe = Deposito_sof::where('dep_referencia', $id)
                            ->where('dep_montocheque', '>', 0)
                            ->get();
        if (sizeof($refe) == 0) {
          $falla = 1;
          $refe = null;
        }
        return response()->json([
          'refe'   =>  $refe,
          'falla'  =>  $falla
        ]);
      }
    }

    public function softservi(Request $request){
      $this->Validate($request, [
        'NumeroDeposito'  =>  'required|numeric'
      ]);
      $dep = Deposito_sof::where('dep_referencia', $request->NumeroDeposito)->get();
      $dep[0]->dep_monto = $dep[0]->dep_montocheque;
      $dep[0]->dep_montocheque = 0;
      $dep[0]->save();
      $paso = 1;
      return view('administrativo.editarsof')->with('paso', $paso);
    }
//------------------------------------------------colegio---------------------------------------------------------------------------
    public function index2(){
      $colegio = Colegio::all();
      $paso = 0;
      return view('administrativo.editarcol')
            ->with('colegio', $colegio)
            ->with('paso', $paso);
    }

    public function tablec(Request $request, $id){
      if ($request->ajax()) {
        $falla = 0;
        $refe = Deposito::where('dep_referencia', $id)
                        ->where('dep_montocheque', '>', 0)
                        ->get();
        if (sizeof($refe) == 0) {
          $falla = 1;
          $refe = null;
        }
        return response()->json([
          'refe'   =>  $refe,
          'falla'  =>  $falla
        ]);
      }
    }

    public function colegio(Request $request){
      $this->Validate($request, [
        'NumeroDeposito'  =>  'required|numeric'
      ]);
      $colegio = Colegio::all();
      $dep = Deposito::where('dep_referencia', $request->NumeroDeposito)->get();
      $dep[0]->dep_monto = $dep[0]->dep_montocheque;
      $dep[0]->dep_montocheque = 0;
      $dep[0]->save();
      $paso = 1;
      return view('administrativo.editarsof')
            ->with('colegio', $colegio)
            ->with('paso', $paso);
    }
}
