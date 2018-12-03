<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cod_Filtro;
use App\Deposito;

class InscripcionesPuntoVenta extends Controller
{
    public function index(){
      $filtros = Cod_Filtro::all();
      return view('Inscripciones.punto_venta')->with('filtros', $filtros);
    }

    public function store (Request $request){

      $filtros = Cod_Filtro::all();
      if ($filtros[0]->depsoftservi == 1) {
        $this->validate($request, [
          'NumeroCuentaSoftservica'        =>  'required|min:20|numeric',
          'NumeroReferenciaSoftservica'    =>  'required|min:8|numeric',
          'FechaDepositoSoftservica'       =>  'required|date',
          'MontoDepositoSoftservica'       =>  'required|min:1|numeric',
          'CedulaEstudianteSoftservica'    =>  'required|min:7|numeric',
          'FormaPagoSoftservica'           =>  'required'
        ]);
        $time = strtotime($request->FechaDepositoSoftservica);
        $newformat = date('Y-m-d',$time);
        $deposito = new Deposito();
        $deposito->dep_banco = 1;
        $deposito->dep_cuenta = (string)$request->NumeroCuentaSoftservica;
        $deposito->dep_referencia = (string)$request->NumeroReferenciaSoftservica;
        $deposito->dep_fecha = $newformat;
        $deposito->dep_monto = $request->MontoDepositoSoftservica;
        $deposito->dep_montocheque = 0.00;
        $deposito->dep_neumonico = "PV";
        $deposito->dep_fecinscrip = $newformat;
        $deposito->dep_fecfact = $newformat;
        $deposito->dep_status = 2;
        $deposito->dep_exp = 0;
        $deposito->dep_cedula = $request->CedulaEstudianteSoftservica;
        $deposito->dep_bajada = 0;
        $deposito->dep_lote = " ";
        $deposito->dep_clavconf = " ";
        $deposito->dep_formapago = $request->FormaPagoSoftservica;
        $deposito->dep_nofacturar = 0;
        $deposito->dep_saldo = 0.00;
        $deposito->save();
      }
      if ($filtros[0]->depcolegio == 1) {
        $this->validate($request, [
          'NumeroCuentaColegio'            =>  'required|min:20|max:20|numeric',
          'NumeroReferenciaColegio'        =>  'required|min:8|max:10|numeric',
          'FechaDepositoColegio'           =>  'required|date',
          'MontoDepositoColegio'           =>  'required|digits_between:min=1,max=12,2',
          'CedulaEstudianteColegio'        =>  'required|min:7|numeric',
          'FormaPagoColegio'               =>  'required'
        ]);
        $time = strtotime($request->FechaDepositoColegio);
        $newformat = date('Y-m-d',$time);
        $deposito2 = new Deposito();
        $deposito2->dep_banco = 1;
        $deposito2->dep_cuenta = (string)$request->NumeroCuentaColegio;
        $deposito2->dep_referencia = (string)$request->NumeroReferenciaColegio;
        $deposito2->dep_fecha = $request->$newformat;
        $deposito2->dep_monto = $request->MontoDepositoColegio;
        $deposito2->dep_montocheque = 0.00;
        $deposito2->dep_neumonico = "PV";
        $deposito2->dep_fecinscrip = $request->$newformat;
        $deposito2->dep_fecfact = $request->$newformat;
        $deposito2->dep_status = 2;
        $deposito2->dep_exp = 0;
        $deposito2->dep_cedula = $request->CedulaEstudianteColegio;
        $deposito2->dep_bajada = 0;
        $deposito2->dep_lote = " ";
        $deposito2->dep_clavconf = " ";
        $deposito2->dep_formapago = $request->FormaPagoColegio;
        $deposito2->dep_nofacturar = 0;
        $deposito2->dep_saldo = 0.00;
        $deposito2->save();
      }
      if ($filtros[0]->depconpadres == 1) {
        $this->validate($request, [
          'NumeroCuentaJuntaRepre'         =>  'required|min:20|max:20|numeric',
          'NumeroReferenciaJuntaRepre'     =>  'required|min:8|max:10|numeric',
          'FechaDepositoJuntaRepre'        =>  'required|date',
          'MontoDepositoJuntaRepre'        =>  'required|digits_between:min=1,max=12,2',
          'CedulaEstudianteJuntaRepre'     =>  'required|min:7|numeric',
          'FormaPagoJuntaRepre'            =>  'required'
        ]);
        $time = strtotime($request->FechaDepositoJuntaRepre);
        $newformat = date('Y-m-d',$time);
        $deposito3 = new Deposito();
        $deposito3->dep_banco = 1;
        $deposito3->dep_cuenta = (string)$request->NumeroCuentaJuntaRepre;
        $deposito3->dep_referencia = (string)$request->NumeroReferenciaJuntaRepre;
        $deposito3->dep_fecha = $newformat;
        $deposito3->dep_monto = $request->MontoDepositoJuntaRepre;
        $deposito3->dep_montocheque = 0.00;
        $deposito3->dep_neumonico = "PV";
        $deposito3->dep_fecinscrip = $newformat;
        $deposito3->dep_fecfact = $newformat;
        $deposito3->dep_status = 2;
        $deposito3->dep_exp = 0;
        $deposito3->dep_cedula = $request->CedulaEstudianteJuntaRepre;
        $deposito3->dep_bajada = 0;
        $deposito3->dep_lote = " ";
        $deposito3->dep_clavconf = " ";
        $deposito3->dep_formapago = $request->FormaPagoJuntaRepre;
        $deposito3->dep_nofacturar = 0;
        $deposito3->dep_saldo = 0.00;
        $deposito3->save();
      }
      return view('Inscripciones.punto_venta')->with('filtros', $filtros);
    }
}
