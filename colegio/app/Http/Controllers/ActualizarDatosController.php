<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Estudiante;
use App\Plantel;
use App\Pais;
use App\Estado;
use App\Repest;
use App\Representante;
use App\Cod_Filtro;
use App\Inscripcion;
use App\Oferta;
use App\MatInscrita;
use App\MaterSeccion;
use App\Materia;
use App\Colegio;
use Illuminate\Support\Facades\Auth;

class ActualizarDatosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiantes = Estudiante::orderBy('est_ced', 'ASC')->get();
        $paises = Pais::orderBy('nombre', 'ASC')->get();
        $estados = Estado::orderBy('nombre', 'ASC')->get();
        $repres = Repest::where('rep_cedrep', Auth::user()->cedula)
            ->join('estudiantes', 'repest.rep_cedalum', '=', 'estudiantes.est_ced')
            ->get();
        $filtros = Cod_Filtro::all();
        $sec = MaterSeccion::orderBy('codsec', 'ASC')->get();
        $colegio  = Colegio::all();
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        return view('actualizardatos.index')
          ->with('estudiantes', $estudiantes)
          ->with('paises', $paises)
          ->with('estados', $estados)
          ->with('repres', $repres)
          ->with('filtros', $filtros)
          ->with('colegio', $colegio)
          ->with('fecha_pdf',$fecha)
          ->with('secciones', $sec);
    }

    public function table(Request $request, $id){
      if($request->ajax()){
        $estudiante = Estudiante::where('est_ced', $id)
              ->join('planteles', 'estudiantes.est_placoddea', '=', 'planteles.est_codigo')
              ->get();
        $repests = Repest::where('rep_cedalum', $id)->get();
        if (sizeof($repests) > 0 ) {
          $padre = Representante::where('rep_ced', $repests[0]->rep_cedpad)->get();
          $madre = Representante::where('rep_ced', $repests[0]->rep_cedmad)->get();
          $repre = Representante::where('rep_ced', $repests[0]->rep_cedrep)->get();
        }else {
          $padre = null;
          $madre = null;
          $repre = null;
        }
        $oferta = Oferta::where('ofac_cedula', $id)
              ->join('materias', 'oferta.ofac_codmat', '=', 'materias.cod')
              ->get();
        $inscri = Inscripcion::where('insc_codusu', $id)->get();
        if (sizeof($inscri) == 0) {
          $inscri = null;
        }
        $sinfoerta = MatInscrita::where('ced_alum', $id)
                                ->join('materias', 'matinscritas.cod_mat', '=', 'materias.cod')
                                ->get();
        $notas = MatInscrita::where('ced_alum',$id)
                                      ->OrderBy('ced_alum','asc')
                                      ->get();
        $seccion = "no";
        if (sizeof($notas) > 0) {
          $seccion = "".$notas[0]->cod_sec;
        }

        return response()->json([
          'estudiante' => $estudiante,
           'padre' => $padre,
           'madre' => $madre,
           'repre' => $repre,
           'inscri' => $inscri,
           'oferta' => $oferta,
           'seccion' => $seccion,
           'sinfoerta' => $sinfoerta
         ]);
      }
    }

    public function store(Request $request)
    {
      $this->validate($request, [
        //Datos del estudiante
        'FechaNacimientoEstudiante'          =>  'required|date',
        'Pais'                               =>  'required',
        'Estado'                             =>  'required',
        'EmailEstudiante'                    =>  'required|min:3|max:100|email',
        //Datos de la madre
        'NombreMadre'                        =>  'required|min:3|max:50|string',
        'DireccionMadre'                     =>  'required|min:3|string',
        'TelefonoCelularMadre'               =>  'required|min:11|numeric',
        'TelefonoHabitacionMadre'            =>  'required|min:11|numeric',
        'LugarTrabajoMadre'                  =>  'required|min:3|max:80|string',
        'DireccionTrabjoMadre'               =>  'required|min:3|max:80|string',
        'TelefonoTrabajoMadre'               =>  'required|min:11|numeric',
        'ProfecionMadre'                     =>  'required|min:3|max:150|string',
        'EmailMadre'                         =>  'required|min:3|max:100|email',
        //Datos del padre
        'NombrePadre'                        =>  'required|min:3|max:50|string',
        'DireccionPadre'                     =>  'required|min:3|string',
        'TelefonoCelularPadre'               =>  'required|min:11|numeric',
        'TelefonoHabitacionPadre'            =>  'required|min:11|numeric',
        'LugarTrabajoPadre'                  =>  'required|min:3|max:80|string',
        'DireccionTrabjoPadre'               =>  'required|min:3|max:80|string',
        'TelefonoTrabajoPadre'               =>  'required|min:12|numeric',
        'ProfecionPadre'                     =>  'required|min:3|max:150|string',
        'EmailPadre'                         =>  'required|min:3|max:100|email',
        //Datos del representante
        'NombreRepresentante'                =>  'required|min:3|max:50|string',
        'DireccionRepresentante'             =>  'required|min:3|string',
        'TelefonoCelularRepresentante'       =>  'required|min:11|numeric',
        'TelefonoHabitacionRepresentante'    =>  'required|min:11|numeric',
        'LugarTrabajoRepresentante'          =>  'required|min:3|max:80|string',
        'DireccionTrabjoRepresentante'       =>  'required|min:3|max:80|string',
        'TelefonoTrabajoRepresentante'       =>  'required|min:11|numeric',
        'ProfecionRepresentante'             =>  'required|min:3|max:150|string',
        'EmailRepresentante'                 =>  'required|min:3|max:100|email',
        //Datos emergencia
        'ParentescoRepresentante'            =>  'required|min:3|max:15|string',
        'NombreEmergencia'                   =>  'required|min:3|max:150|string',
        'TelefonoEmergencia'                 =>  'required|min:11|numeric',
        'GradoFamiliarEmergencia'            =>  'required|min:3|max:20|string',
        'TransporteEmergencia'               =>  'required',
        'ViveConEmergencia'                  =>  'required',
        'NombreViveEmergencia'               =>  'required|min:3|max:150|string'
      ]);
        //Guardando los datos del estudiante
        $time = strtotime($request->FechaNacimientoEstudiante);
        $newformat = date('Y-m-d',$time);
        $estudiante = Estudiante::where('est_ced', $request->cedulaE)->get();
        $estudiante[0]->est_fecnac = $newformat;
        $estudiante[0]->est_codpais = $request->Pais;
        $estudiante[0]->est_estnac = $request->Estado;
        $estudiante[0]->est_email = $request->EmailEstudiante;
        $estudiante[0]->est_callemer = $request->NombreEmergencia;
        $estudiante[0]->est_telfemer = $request->TelefonoEmergencia;
        $estudiante[0]->est_grafam = $request->GradoFamiliarEmergencia;
        $estudiante[0]->est_vivecon = $request->ViveConEmergencia;
        $estudiante[0]->est_medtras = $request->TransporteEmergencia;
        $estudiante[0]->rep_vivecondes = $request->NombreViveEmergencia;
        $estudiante[0]->save();

        $repests = Repest::where('rep_cedalum', $request->cedulaE)->get();
        //Cuando existan los datos de la madre, padre y representante
        if (sizeof($repests) > 0 ) {
          $madre = Representante::where('rep_ced', $repests[0]->rep_cedmad)->get();
          $padre = Representante::where('rep_ced', $repests[0]->rep_cedpad)->get();
          //Guardando los datos de la madre
          $madre[0]->rep_nomrep = $request->NombreMadre;
          $madre[0]->rep_dirhabrep = $request->DireccionMadre;
          $madre[0]->rep_telcel = $request->TelefonoCelularMadre;
          $madre[0]->rep_telhabrep = $request->TelefonoHabitacionMadre;
          $madre[0]->rep_lugtrarep = $request->LugarTrabajoMadre;
          $madre[0]->rep_dirtrarep = $request->DireccionTrabjoMadre;
          $madre[0]->rep_teltrarep = $request->TelefonoTrabajoMadre;
          $madre[0]->rep_profrep = $request->ProfecionMadre;
          $madre[0]->rep_email = $request->EmailMadre;
          $madre[0]->save();

          //Guardando los datos del padre
          $padre[0]->rep_nomrep = $request->NombrePadre;
          $padre[0]->rep_dirhabrep = $request->DireccionPadre;
          $padre[0]->rep_telcel = $request->TelefonoCelularPadre;
          $padre[0]->rep_telhabrep = $request->TelefonoHabitacionPadre;
          $padre[0]->rep_lugtrarep = $request->LugarTrabajoPadre;
          $padre[0]->rep_dirtrarep = $request->DireccionTrabjoPadre;
          $padre[0]->rep_teltrarep = $request->TelefonoTrabajoPadre;
          $padre[0]->rep_profrep = $request->ProfecionPadre;
          $padre[0]->rep_email = $request->EmailPadre;
          $padre[0]->save();

          //Guardando los datos del Representante siempre y cuando sea distinto al padre o madre
          if ($request->CedulaRepresentante != $request->CedulaPadre && $request->CedulaRepresentante != $request->CedulaMadre) {
            $repre = Representante::where('rep_ced', $repests[0]->rep_cedrep)->get();
            $repre[0]->rep_nomrep = $request->NombreRepresentante;
            $repre[0]->rep_dirhabrep = $request->DireccionRepresentante;
            $repre[0]->rep_telcel = $request->TelefonoCelularRepresentante;
            $repre[0]->rep_telhabrep = $request->TelefonoHabitacionRepresentante;
            $repre[0]->rep_lugtrarep = $request->LugarTrabajoRepresentante;
            $repre[0]->rep_dirtrarep = $request->DireccionTrabjoRepresentante;
            $repre[0]->rep_teltrarep = $request->TelefonoTrabajoRepresentante;
            $repre[0]->rep_profrep = $request->ProfecionRepresentante;
            $repre[0]->rep_email = $request->EmailRepresentante;
            $repre[0]->rep_parentesco = $request->ParentescoRepresentante;
            $repre[0]->save();
            //Guardando los datos del representante cuando sea igual al padre o a la madre
            }else {
              if ($request->CedulaRepresentante == $request->CedulaPadre) {
                $padre[0]->rep_parentesco = $request->ParentescoRepresentante;
                $padre[0]->save();
              }else {
                $madre[0]->rep_parentesco = $request->ParentescoRepresentante;
                $madre[0]->save();
              }
            }
        }else{//Cuando no existan datos de la madre, padre y representante
          //Datos de la madre
          $madre = Representante::where('rep_ced', $request->CedulaMadre)->get();
          if (sizeof($madre) == 0) {
            $this->Validate($request,[
              //Datos de la madre
              'CedulaMadre'                  =>  'required|min:|numeric',
              'NacionalidadMadre'            =>  'required'
            ]);
            $madre = new Representante();
            $madre->rep_ced = $request->CedulaMadre;
            $madre->rep_nac = $request->NacionalidadMadre;
            $madre->rep_nomrep = $request->NombreMadre;
            $madre->rep_dirhabrep = $request->DireccionMadre;
            $madre->rep_telcel = $request->TelefonoCelularMadre;
            $madre->rep_telhabrep = $request->TelefonoHabitacionMadre;
            $madre->rep_lugtrarep = $request->LugarTrabajoMadre;
            $madre->rep_dirtrarep = $request->DireccionTrabjoMadre;
            $madre->rep_teltrarep = $request->TelefonoTrabajoMadre;
            $madre->rep_profrep = $request->ProfecionMadre;
            $madre->rep_email = $request->EmailMadre;
            $madre->save();
          }
          //Datos del padre
          $padre = Representante::where('rep_ced', $request->CedulaPadre)->get();
          if (sizeof($padre) == 0) {
            $this->Validate($request,[
              //Datos del padre
              'CedulaPadre'                  =>  'required|min:|numeric',
              'NacionalidadPadre'            =>  'required'
            ]);
            $padre = new Representante();
            $padre->rep_ced = $request->CedulaPadre;
            $padre->rep_nac = $request->NacionalidadPadre;
            $padre->rep_nomrep = $request->NombrePadre;
            $padre->rep_dirhabrep = $request->DireccionPadre;
            $padre->rep_telcel = $request->TelefonoCelularPadre;
            $padre->rep_telhabrep = $request->TelefonoHabitacionPadre;
            $padre->rep_lugtrarep = $request->LugarTrabajoPadre;
            $padre->rep_dirtrarep = $request->DireccionTrabjoPadre;
            $padre->rep_teltrarep = $request->TelefonoTrabajoPadre;
            $padre->rep_profrep = $request->ProfecionPadre;
            $padre->rep_email = $request->EmailPadre;
            $padre->save();
          }
          //datos del representante
          if ($request->CedulaRepresentante != $request->CedulaPadre && $request->CedulaRepresentante != $request->CedulaMadre) {
            $repre = Representante::where('rep_ced', $request->CedulaRepresentante)->get();
            if (sizeof($repre) == 0) {
              $this->Validate($request,[
                //datos del representante
                'CedulaRepresentante'          =>  'required|min:6|numeric',
                'NacionalidadRepresentante'    =>  'required'
              ]);
              $repre = new Representante();
              $repre->rep_ced = $request->CedulaRepresentante;
              $repre->rep_nac = $request->NacionalidadRepresentante;
              $repre->rep_nomrep = $request->NombreRepresentante;
              $repre->rep_dirhabrep = $request->DireccionRepresentante;
              $repre->rep_telcel = $request->TelefonoCelularRepresentante;
              $repre->rep_telhabrep = $request->TelefonoHabitacionRepresentante;
              $repre->rep_lugtrarep = $request->LugarTrabajoRepresentante;
              $repre->rep_dirtrarep = $request->DireccionTrabjoRepresentante;
              $repre->rep_teltrarep = $request->TelefonoTrabajoRepresentante;
              $repre->rep_profrep = $request->ProfecionRepresentante;
              $repre->rep_email = $request->EmailRepresentante;
              $repre->rep_parentesco = $request->ParentescoRepresentante;
              $repre->save();
            }
          }else {
            if ($request->CedulaRepresentante == $request->CedulaPadre) {
              $padre->rep_parentesco = $request->ParentescoRepresentante;
            }else {
              $madre->rep_parentesco = $request->ParentescoRepresentante;
            }
          }
          //Creando el respest
          $repests = new Repest();
          $repests->rep_cedalum = $request->cedulaE;
          $repests->rep_cedmad = $request->CedulaMadre;
          $repests->rep_cedpad = $request->CedulaPadre;
          $repests->rep_cedrep = $request->CedulaRepresentante;
          $repests->save();
        }
        //Inscripcion
        $date = getdate();
        $fecha = "".$date["year"]."-".$date["mon"]."-".$date["mday"]." ".$date["hours"].":".$date["minutes"].":".$date["seconds"];
        $inscri = Inscripcion::where('insc_codusu', $request->cedulaE)->get();
        $filtro = Cod_Filtro::all();
        if (sizeof($inscri) > 0) {
          if (Auth::user()->tipo_id != 6) {
            $oferta = Oferta::where('ofac_cedula', $request->cedulaE)->get();
            if (sizeof($oferta) > 0) {
              $inscri[0]->insc_tipo = $oferta[0]->ofac_condalum;
            }else {
              $inscri[0]->insc_tipo = "N";
            }
            $inscri[0]->insc_semestre = $request->Grado[1];
            $inscri[0]->insc_turno = $request->Grado[2];
            if ($request->Grado[0] == 'M') {
              $inscri[0]->insc_codcarr = 1;
            }
            elseif ($request->Grado[0] == 'P') {
              $inscri[0]->insc_codcarr = 2;
            }
            elseif ($request->Grado[0] == '0') {
              $inscri[0]->insc_codcarr = 3;
            }
            elseif ($request->Grado[0] == 'D') {
            $inscri[0]->insc_codcarr = 4;
            }
            $inscri[0]->insc_codlapso = $filtro[0]->codlapso;
            $inscri[0]->insc_fechor = $fecha;
            $inscri[0]->insc_bajar = 0;
          }
          else{
              $inscri[0]->insc_bajar = 1;
          }
          $inscri[0]->save();
        }else {
          if (Auth::user()->tipo_id != 6) {
            $inscri = new Inscripcion();
            $inscri->insc_codusu = $request->cedulaE;
            $inscri->insc_semestre = $request->Grado[1];
            $inscri->insc_turno = $request->Grado[2];
            if ($request->Grado[0] == 'M') {
              $inscri->insc_codcarr = 1;
            }
            elseif ($request->Grado[0] == 'P') {
              $inscri->insc_codcarr = 2;
            }
            elseif ($request->Grado[0] == '0') {
              $inscri->insc_codcarr = 3;
            }
            elseif ($request->Grado[0] == 'D') {
            $inscri->insc_codcarr = 4;
            }
            $inscri->insc_tipo = "N";
            $inscri->insc_codlapso = $filtro[0]->codlapso;
            $inscri->insc_status = 0;
            $inscri->insc_fechor = $fecha;
            $inscri->insc_bajar = 0;
          }
          else{
              $inscri->insc_bajar = 1;
          }
          $inscri->save();
        }
        //Inscribir materias
        $oferta = Oferta::where('ofac_cedula', $request->cedulaE)->get();
        if (sizeof($oferta) > 0) {
          $mate_ins = MatInscrita::where('ced_alum', $request->cedulaE)->get();
          if (sizeof($mate_ins) > 0) {
            for ($i=0; $i<sizeof($mate_ins) ; $i++) {
              $mate_ins[$i]->delete();
            }
          }
          for ($i=0; $i<sizeof($oferta) ; $i++) {
            $mat = new MatInscrita();
            $mat->periescolar = $filtro[0]->codlapso;
            $mat->ced_alum = $request->cedulaE;
            $mat->cod_mat = $oferta[$i]->ofac_codmat;
            $mat->cod_sec = $oferta[$i]->ofac_seccion;
            $mat->cond_materia = $oferta[$i]->ofac_condalum;
            $mat->nota1_1 = 0;
            $mat->nota1_1_112 = 0;
            $mat->nota1_2 = 0;
            $mat->nota1_2_112 = 0;
            $mat->nota1_3 = 0;
            $mat->nota1_3_112 = 0;
            $mat->nota1_4 = 0;
            $mat->nota1_4_112 = 0;
            $mat->nota1_5 = 0;
            $mat->nota1_5_112 = 0;
            $mat->letra1 = "0";
            $mat->nota1_70 = 0;
            $mat->nota1_fl = 0;
            $mat->nota1_fl112 = 0;
            $mat->nota1_30 = 0;
            $mat->nota1_deflap = 0;
            $mat->inasis1 = 0;
            $mat->nota2_1 = 0;
            $mat->nota2_1_112 = 0;
            $mat->nota2_2 = 0;
            $mat->nota2_2_112 = 0;
            $mat->nota2_3 = 0;
            $mat->nota2_3_112 = 0;
            $mat->nota2_4 = 0;
            $mat->nota2_4_112 = 0;
            $mat->nota2_5 = 0;
            $mat->nota2_5_112 = 0;
            $mat->letra2 = "0";
            $mat->nota2_70 = 0;
            $mat->nota2_fl = 0;
            $mat->nota2_fl112 = 0;
            $mat->nota2_30 = 0;
            $mat->nota2_deflap = 0;
            $mat->inasis2 = 0;
            $mat->nota3_1 = 0;
            $mat->nota3_1_112 = 0;
            $mat->nota3_2 = 0;
            $mat->nota3_2_112 = 0;
            $mat->nota3_3 = 0;
            $mat->nota3_3_112 = 0;
            $mat->nota3_4 = 0;
            $mat->nota3_4_112 = 0;
            $mat->nota3_5 = 0;
            $mat->nota3_5_112 = 0;
            $mat->letra3 = "0";
            $mat->nota3_70 = 0;
            $mat->nota3_fl = 0;
            $mat->nota3_fl112 = 0;
            $mat->nota3_30 = 0;
            $mat->nota3_deflap = 0;
            $mat->inasis3 = 0;
            $mat->def = 0;
            $mat->save();
          }
        }
        elseif(Auth::user()->tipo_id != 6){
          $this->Validate($request, [
            'Grado'    => 'required'
          ]);
          $cod = $request->Grado[0].$request->Grado[1].$request->Grado[2];
          $mat = Materia::where('año', $cod)->get();
          for ($i=0; $i<sizeof($mat) ; $i++) {
            $ins = new MatInscrita();
            $ins->periescolar = $filtro[0]->codlapso;
            $ins->ced_alum = $request->cedulaE;
            $ins->cod_mat = $mat[$i]->cod;
            $ins->cod_sec = $request->Grado;
            $ins->cond_materia = "RG";
            $ins->nota1_1 = 0;
            $ins->nota1_1_112 = 0;
            $ins->nota1_2 = 0;
            $ins->nota1_2_112 = 0;
            $ins->nota1_3 = 0;
            $ins->nota1_3_112 = 0;
            $ins->nota1_4 = 0;
            $ins->nota1_4_112 = 0;
            $ins->nota1_5 = 0;
            $ins->nota1_5_112 = 0;
            $ins->letra1 = "0";
            $ins->nota1_70 = 0;
            $ins->nota1_fl = 0;
            $ins->nota1_fl112 = 0;
            $ins->nota1_30 = 0;
            $ins->nota1_deflap = 0;
            $ins->inasis1 = 0;
            $ins->nota2_1 = 0;
            $ins->nota2_1_112 = 0;
            $ins->nota2_2 = 0;
            $ins->nota2_2_112 = 0;
            $ins->nota2_3 = 0;
            $ins->nota2_3_112 = 0;
            $ins->nota2_4 = 0;
            $ins->nota2_4_112 = 0;
            $ins->nota2_5 = 0;
            $ins->nota2_5_112 = 0;
            $ins->letra2 = "0";
            $ins->nota2_70 = 0;
            $ins->nota2_fl = 0;
            $ins->nota2_fl112 = 0;
            $ins->nota2_30 = 0;
            $ins->nota2_deflap = 0;
            $ins->inasis2 = 0;
            $ins->nota3_1 = 0;
            $ins->nota3_1_112 = 0;
            $ins->nota3_2 = 0;
            $ins->nota3_2_112 = 0;
            $ins->nota3_3 = 0;
            $ins->nota3_3_112 = 0;
            $ins->nota3_4 = 0;
            $ins->nota3_4_112 = 0;
            $ins->nota3_5 = 0;
            $ins->nota3_5_112 = 0;
            $ins->letra3 = "0";
            $ins->nota3_70 = 0;
            $ins->nota3_fl = 0;
            $ins->nota3_fl112 = 0;
            $ins->nota3_30 = 0;
            $ins->nota3_deflap = 0;
            $ins->inasis3 = 0;
            $ins->def = 0;
            $ins->save();
          }
        }
        return redirect()->route('actualizardatos.index');
    }
}
