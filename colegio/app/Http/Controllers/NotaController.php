<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;
use App\MaterSeccion;
use App\Materia;
use App\MatInscrita;
use App\Planificacion;
use App\Colegio;
use App\Repest;
use App\Estudiante;

use Illuminate\Support\Facades\Auth;

class NotaController extends Controller{
    //funcion  encargada de guardar las notas para ser llamada en vario funciones
    public static function notas($array,$notas,$request,$i,$j){
      if ($array[2] == 1) {
        $notas[$i]->nota1_1     = $request->n1_1[$j]       === null ? 0 : $request->n1_1[$j];
        $notas[$i]->nota1_1_112 = $request->n1_1_112[$j]   === null ? 0 : $request->n1_1_112[$j];

        //condicion para saber si tiene 2 parciales
        if (intval($array[3]) >= 2) {
          $notas[$i]->nota1_2     = $request->n1_2[$j]     === null ? 0 : $request->n1_2[$j];
          $notas[$i]->nota1_2_112 = $request->n1_2_112[$j] === null ? 0 : $request->n1_2_112[$j];
        }
        //condicion para saber si tiene 3 parciales
        if (intval($array[3]) >= 3) {
          $notas[$i]->nota1_3     = $request->n1_3[$j]     === null ? 0 : $request->n1_3[$j];
          $notas[$i]->nota1_3_112 = $request->n1_3_112[$j] === null ? 0 : $request->n1_3_112[$j];
        }
        //condicion para saber si tiene 4 parciales
        if (intval($array[3]) >= 4) {
          $notas[$i]->nota1_4     = $request->n1_4[$j]     === null ? 0 : $request->n1_4[$j];
          $notas[$i]->nota1_4_112 = $request->n1_4_112[$j] === null ? 0 : $request->n1_4_112[$j];
        }
        //condicion para saber si tiene 5 parciales
        if (intval($array[3]) >= 5) {
          $notas[$i]->nota1_5     = $request->n1_5[$j]     === null ? 0 : $request->n1_5[$j];
          $notas[$i]->nota1_5_112 = $request->n1_5_112[$j] === null ? 0 : $request->n1_5_122[$j];
        }
        //condicion para saber si es con final o no
        if (intval($array[4]) == 1) {
          $notas[$i]->nota1_fl     = $request->n1_fl[$j]    === null ? 0 : $request->n1_fl[$j];
          $notas[$i]->nota1_fl112  = $request->n1_fl112[$j] === null ? 0 : $request->n1_fl112[$j];
          $notas[$i]->nota1_70     = $request->n1_70[$j];
          $notas[$i]->nota1_30     = $request->n1_30[$j];
          $notas[$i]->nota1_deflap = $request->n1_deflap[$j];
        }
        else {
          $notas[$i]->nota1_fl     = 0;
          $notas[$i]->nota1_fl112  = 0;
          $notas[$i]->nota1_70     = $request->n1_70[$j];
          $notas[$i]->nota1_30     = 0;
          $notas[$i]->nota1_deflap = $request->n1_70[$j];
        }
        $notas[$i]->letra1  = $request->letra1[$j];
        $notas[$i]->inasis1 = $request->ins[$j];
        $notas[$i]->Des1    = $request->DesObj[$j];
        $notas[$i]->dim1_1  = $request->Dim1Obj[$j];
        $notas[$i]->dim1_2  = $request->Dim2Obj[$j];
      }
      //condicion para las notas del segundo lapso
      if ($array[2] == 2) {

        $notas[$i]->nota2_1     = $request->n2_1[$j]       === null ? 0 : $request->n2_1[$j];
        $notas[$i]->nota2_2_112 = $request->n2_2_112[$j]   === null ? 0 : $request->n2_2_112[$j];

        //condicion para saber si tiene 2 parciales
        if (intval($array[3]) >= 2) {
          $notas[$i]->nota2_2     = $request->n2_2[$j]     === null ? 0 : $request->n2_2[$j];
          $notas[$i]->nota2_2_112 = $request->n2_2_112[$j] === null ? 0 : $request->n2_2_112[$j];
        }
        //condicion para saber si tiene 3 parciales
        if (intval($array[3]) >= 3) {
          $notas[$i]->nota2_3     = $request->n2_3[$j]     === null ? 0 : $request->n2_3[$j];
          $notas[$i]->nota2_3_112 = $request->n2_3_112[$j] === null ? 0 : $request->n2_3_112[$j];
        }
        //condicion para saber si tiene 4 parciales
        if (intval($array[3]) >= 4) {
          $notas[$i]->nota2_4     = $request->n2_4[$j]     === null ? 0 : $request->n2_4[$j];
          $notas[$i]->nota2_4_112 = $request->n2_4_112[$j] === null ? 0 : $request->n2_4_112[$j];
        }
        //condicion para saber si tiene 5 parciales
        if (intval($array[3]) >= 5) {
          $notas[$i]->nota2_5     = $request->n2_5[$j]     === null ? 0 : $request->n2_5[$j];
          $notas[$i]->nota2_5_112 = $request->n2_5_112[$j] === null ? 0 : $request->n2_5_112[$j];
        }
        //condicion para saber si es con final o no
        if (intval($array[4]) == 1) {
          $notas[$i]->nota2_fl     = $request->n2_fl[$j]    === null ? 0 : $request->n2_fl[$j];
          $notas[$i]->nota2_fl112  = $request->n2_fl112[$j] === null ? 0 : $request->n2_fl112[$j];
          $notas[$i]->nota2_70     = $request->n2_70[$j];
          $notas[$i]->nota2_30     = $request->n2_30[$j];
          $notas[$i]->nota2_deflap = $request->n2_deflap[$j];
        }
        else {
          $notas[$i]->nota2_fl     = 0;
          $notas[$i]->nota2_fl112  = 0;
          $notas[$i]->nota2_70     = $request->n2_70[$j];
          $notas[$i]->nota2_30     = 0;
          $notas[$i]->nota2_deflap = $request->n2_70[$j];
        }
        $notas[$i]->letra2  = $request->letra2[$j];
        $notas[$i]->inasis2 = $request->ins[$j];
        $notas[$i]->Des2    = $request->DesObj[$j];
        $notas[$i]->dim2_1  = $request->Dim1Obj[$j];
        $notas[$i]->dim2_2  = $request->Dim2Obj[$j];
      }
      //condicion para las notas del tercer lapso
      if ($array[2] == 3) {

        $notas[$i]->nota3_1     = $request->n3_1[$j]       === null ? 0 : $request->n3_1[$j];
        $notas[$i]->nota3_3_112 = $request->n3_3_112[$j]   === null ? 0 : $request->n3_3_112[$j];

        //condicion para saber si tiene 2 parciales
        if (intval($array[3]) >= 2) {
          $notas[$i]->nota3_2     = $request->n3_2[$j]     === null ? 0 : $request->n3_2[$j];
          $notas[$i]->nota3_2_112 = $request->n3_2_112[$j] === null ? 0 : $request->n3_2_112[$j];
        }
        //condicion para saber si tiene 3 parciales
        if (intval($array[3]) >= 3) {
          $notas[$i]->nota3_3     = $request->n3_3[$j]     === null ? 0 : $request->n3_3[$j];
          $notas[$i]->nota3_3_112 = $request->n3_3_112[$j] === null ? 0 : $request->n3_3_112[$j];
        }
        //condicion para saber si tiene 4 parciales
        if (intval($array[3]) >= 4) {
          $notas[$i]->nota3_4     = $request->n3_4[$j]     === null ? 0 : $request->n3_4[$j];
          $notas[$i]->nota3_4_112 = $request->n3_4_112[$j] === null ? 0 : $request->n3_4_112[$j];
        }
        //condicion para saber si tiene 5 parciales
        if (intval($array[3]) >= 5) {
          $notas[$i]->nota3_5     = $request->n3_5[$j]     === null ? 0 : $request->n3_5[$j];
          $notas[$i]->nota3_5_112 = $request->n3_5_112[$j] === null ? 0 : $request->n3_5_112[$j];
        }
        //condicion para saber si es con final o no
        if (intval($array[4]) == 1) {
          $notas[$i]->nota3_fl     = $request->n3_fl[$j]    === null ? 0 : $request->n3_fl[$j];
          $notas[$i]->nota3_fl112  = $request->n3_fl112[$j] === null ? 0 : $request->n3_fl112[$j];
          $notas[$i]->nota3_70     = $request->n3_70[$j];
          $notas[$i]->nota3_30     = $request->n3_30[$j];
          $notas[$i]->nota3_deflap = $request->n3_deflap[$j];
        }
        else {
          $notas[$i]->nota3_fl     = 0;
          $notas[$i]->nota3_fl112  = 0;
          $notas[$i]->nota3_70     = $request->n3_70[$j];
          $notas[$i]->nota3_30     = 0;
          $notas[$i]->nota3_deflap = $request->n3_70[$j];
        }
        $notas[$i]->letra3  = $request->letra3[$j];
        $notas[$i]->inasis3 = $request->ins[$j];
        $notas[$i]->Des3    = $request->DesObj[$j];
        $notas[$i]->dim3_1  = $request->Dim1Obj[$j];
        $notas[$i]->dim3_2  = $request->Dim2Obj[$j];
      }
      $notas[$i]->save();
    }

    //-----------------------------------------------------------
    //Controladores de Notas de secundaria
    public function index_Sec(){
        $user     = Auth::user();
        $profesor = Profesor::where('cedula',$user->cedula)->get();
        $secciones  = MaterSeccion::where('cedprof',$user->cedula)
                                  ->join('materias','materseccion.codmat','=','materias.cod')
                                  ->OrderBy('codsec','asc')
                                  ->OrderBy('des','asc')
                                  ->get();
        $colegio  = Colegio::all();
        return view('evaluaciones.notas')
            ->with('materias',$secciones)
            ->with('colegio',$colegio);
    }

    public function store_Sec_C(Request $request){
      $user     = Auth::user();
      $array = explode("-", $request->ids);
      //dd($array);
      
      $notas = MatInscrita::where('cod_sec',$array[0])
      ->where('cod_mat',$array[1])
      ->OrderBy('ced_alum','asc')
      ->get();
      //dd($notas);
      
      for ($i=0; $i < sizeof($notas); $i++) {
        $obj = new NotaController();
        $obj->notas($array,$notas,$request,$i,$i);
      }
      /* 
      //12/04/2018 12:30am
      //En comentario ya que esta dando error se sale del array
      //Segun lo que entiendo es que esta recalculando la nota de las materias madres
      //y no esta funcionando bien
      //Hermes esta asumiendo que todas las Materias Madres tienen solo 2 Hijas y eso no es asi
      //Aqui se esta dando el caso de una madre con 3 hijas

      $calcular = MatInscrita::where('cod_sec',$array[0])
      ->join('materias','matinscritas.cod_mat','=','materias.cod')
      ->where('tipo','<>','0')
      ->OrderBy('ced_alum','asc')
      ->OrderBy('tipo','asc')
      ->get();
      //dd($calcular);
      
      for ($i=0; $i < sizeof($calcular) ; $i=$i+3) {
        $nota = MatInscrita::where('cod_sec',$array[0])
        ->where('cod_mat',$calcular[$i]->cod_mat)
        ->where('ced_alum',$calcular[$i]->ced_alum)
        ->OrderBy('ced_alum','asc')
        ->get();
        $nota[0]->nota1_deflap = ($calcular[$i+1]->nota1_deflap + $calcular[$i+2]->nota1_deflap)/2;
        $nota[0]->nota2_deflap = ($calcular[$i+1]->nota2_deflap + $calcular[$i+1]->nota2_deflap)/2;
        $nota[0]->nota3_deflap = ($calcular[$i+2]->nota3_deflap + $calcular[$i+2]->nota3_deflap)/2;
        $nota[0]->save();
        ;
      }
      */
      return redirect()->route('notas.index');
    }

    public function store_Sec_N(Request $request){
      $user     = Auth::user();
      $array = explode("-", $request->ids);
      $notasO = MatInscrita::where('cod_sec',$array[0])
      ->where('cod_mat',$array[1])
      ->join('estudiantes','matinscritas.ced_alum','=','estudiantes.est_ced')
      ->OrderBy('est_apellidos','asc')
      ->OrderBy('est_nombres','asc')
      ->get();
      $notas = MatInscrita::where('cod_sec',$array[0])
      ->where('cod_mat',$array[1])
      ->OrderBy('ced_alum','asc')
      ->get();
       for ($j=0; $j < sizeof($notasO) ; $j++) {
        for ($i=0; $i < sizeof($notas); $i++) {
         if(strcmp($notasO[$j]->ced_alum,$notas[$i]->ced_alum)==0){
           $obj = new NotaController();
           $obj->notas($array,$notas,$request,$i,$j);
        }

       }
      }
      $calcular = MatInscrita::where('cod_sec',$array[0])
      ->join('materias','matinscritas.cod_mat','=','materias.cod')
      ->where('tipo','<>','0')
      ->OrderBy('ced_alum','asc')
      ->OrderBy('tipo','asc')
      ->get();

      for ($i=0; $i < sizeof($calcular) ; $i=$i+3) {
        $nota = MatInscrita::where('cod_sec',$array[0])
        ->where('cod_mat',$calcular[$i]->cod_mat)
        ->where('ced_alum',$calcular[$i]->ced_alum)
        ->OrderBy('ced_alum','asc')
        ->get();
        $nota[0]->nota1_deflap = ($calcular[$i+1]->nota1_deflap + $calcular[$i+2]->nota1_deflap)/2;
        $nota[0]->nota2_deflap = ($calcular[$i+1]->nota2_deflap + $calcular[$i+1]->nota2_deflap)/2;
        $nota[0]->nota3_deflap = ($calcular[$i+2]->nota3_deflap + $calcular[$i+2]->nota3_deflap)/2;
        $nota[0]->save();
      }

      return redirect()->route('notas.nombre.store');
    }

    //-----------------------------------------------------------
    //Controladores de Notas de primaria
    public function index_Pri(){
        $user     = Auth::user();
        $profesor = Profesor::where('cedula',$user->cedula)->get();
        $secciones  = MaterSeccion::where('cedprof',$user->cedula)->join('materias','materseccion.codmat','=','materias.cod')->get();
        $colegio  = Colegio::all();
        return view('evaluaciones.primaria')
            ->with('materias',$secciones)
            ->with('colegio',$colegio);
    }

    public function store_Pri_C(Request $request){
      $user     = Auth::user();
      $array = explode("-", $request->ids);
      $notas = MatInscrita::where('cod_sec',$array[0])
      ->where('cod_mat',$array[1])
      ->OrderBy('ced_alum','asc')
      ->get();
      $planificacion = Planificacion::where('pla_docente',$user->cedula)
      ->where('pla_secion',$array[0])
      ->where('pla_mat',$array[1])
      ->where('pla_lapso',$array[2])
      ->get();
      //dd($request);

      $j=0;
      $tam = sizeof($planificacion);
      //dd($tam);
      for ($i=0; $i < sizeof($notas); $i++) {
        if ($array[2] == 1) {
          $notas[$i]->letra1       = 0;
          $notas[$i]->inasis1      = 0;
          $notas[$i]->nota1_1      = 0;
          $notas[$i]->nota1_1_112  = 0;
          $notas[$i]->nota1_2      = 0;
          $notas[$i]->nota1_2_112  = 0;
          $notas[$i]->nota1_3      = 0;
          $notas[$i]->nota1_3_112  = 0;
          $notas[$i]->nota1_4      = 0;
          $notas[$i]->nota1_4_112  = 0;
          $notas[$i]->nota1_5      = 0;
          $notas[$i]->nota1_5_112  = 0;
          $notas[$i]->nota1_fl     = 0;
          $notas[$i]->nota1_fl112  = 0;
          $notas[$i]->nota1_70     = 0;
          $notas[$i]->nota1_30     = 0;
          $notas[$i]->nota1_deflap = 0;
          if($tam >=1){
            $notas[$i]->Des1_1 = $request->textareas[$j];
          }
          if($tam >=2){
            $notas[$i]->Des1_2 = $request->textareas[$j+1];
          }
          if($tam >=3){
            $notas[$i]->Des1_3 = $request->textareas[$j+2];
          }
          if($tam >=4){
            $notas[$i]->Des1_4 = $request->textareas[$j+3];
          }
          if($tam ==5){
            $notas[$i]->Des1_5 = $request->textareas[$j+4];
          }

        }
        if ($array[2] == 2) {
          $notas[$i]->letra2       = 0;
          $notas[$i]->inasis2      = 0;
          $notas[$i]->nota2_1      = 0;
          $notas[$i]->nota2_1_112  = 0;
          $notas[$i]->nota2_2      = 0;
          $notas[$i]->nota2_2_112  = 0;
          $notas[$i]->nota2_3      = 0;
          $notas[$i]->nota2_3_112  = 0;
          $notas[$i]->nota2_4      = 0;
          $notas[$i]->nota2_4_112  = 0;
          $notas[$i]->nota2_5      = 0;
          $notas[$i]->nota2_5_112  = 0;
          $notas[$i]->nota2_fl     = 0;
          $notas[$i]->nota2_fl112  = 0;
          $notas[$i]->nota2_70     = 0;
          $notas[$i]->nota2_30     = 0;
          $notas[$i]->nota2_deflap = 0;
        }
        if ($array[2] == 3) {
          $notas[$i]->letra3       = 0;
          $notas[$i]->inasis3      = 0;
          $notas[$i]->nota3_1      = 0;
          $notas[$i]->nota3_1_112  = 0;
          $notas[$i]->nota3_2      = 0;
          $notas[$i]->nota3_2_112  = 0;
          $notas[$i]->nota3_3      = 0;
          $notas[$i]->nota3_3_112  = 0;
          $notas[$i]->nota3_4      = 0;
          $notas[$i]->nota3_4_112  = 0;
          $notas[$i]->nota3_5      = 0;
          $notas[$i]->nota3_5_112  = 0;
          $notas[$i]->nota3_fl     = 0;
          $notas[$i]->nota3_fl112  = 0;
          $notas[$i]->nota3_70     = 0;
          $notas[$i]->nota3_30     = 0;
          $notas[$i]->nota3_deflap = 0;
        }
        $notas[$i]->save();
        $j= $j + $tam;
      }
      return redirect()->route('notas.primaria');
    }

    //-----------------------------------------------------------
    //Controladores de Ajax para las notas
    public function tabla_C(Request $request,$id){
      if ($request->ajax()) {
        $user     = Auth::user();
        $array = explode("-", $id);
        $notas = MatInscrita::where('cod_sec',$array[0])
        ->where('cod_mat',$array[1])
        ->join('estudiantes','matinscritas.ced_alum','=','estudiantes.est_ced')
        ->join('materias','matinscritas.cod_mat','=','materias.cod')
        ->OrderBy('ced_alum','asc')
        ->get();


        $planificacion = Planificacion::where('pla_docente',$user->cedula)
        ->where('pla_secion',$array[0])
        ->where('pla_mat',$array[1])
        ->where('pla_lapso',$array[2])
        ->get();
        return response()->json(['notas' => $notas, 'planificacion' => $planificacion]);
      }
    }

    public function tabla_N(Request $request,$id){
      if ($request->ajax()) {
        $user     = Auth::user();
        $array = explode("-", $id);
        $notas = MatInscrita::where('cod_sec',$array[0])
        ->where('cod_mat',$array[1])
        ->join('estudiantes','matinscritas.ced_alum','=','estudiantes.est_ced')
        ->OrderBy('est_apellidos','asc')
        ->OrderBy('est_nombres','asc')
        ->get();


        $planificacion = Planificacion::where('pla_docente',$user->cedula)
        ->where('pla_secion',$array[0])
        ->where('pla_mat',$array[1])
        ->where('pla_lapso',$array[2])
        ->get();
        return response()->json(['notas' => $notas, 'planificacion' => $planificacion]);
      }
    }

    //-----------------------------------------------------------
    //Controladores de boletines de secundaria
    public function bole_sec(){
      $secciones  = MaterSeccion::OrderBy('codsec','asc')
                                ->get();
      $hijos  = Repest::where('rep_cedrep',Auth::user()->cedula)
                                ->join('estudiantes','repest.rep_cedalum','=','estudiantes.est_ced')
                                ->join('matinscritas','repest.rep_cedalum','=','matinscritas.ced_alum')
                                ->get();
      $error = 0;
      return view ('evaluaciones.seccion')->with('secciones',$secciones)->with('hijos',$hijos)->with('error',$error);
    }

    public function boletines(Request $request){
      $user     = Auth::user();
      $colegio  = Colegio::all();
      $cedula   =$request->sec;
      if ($user->tipo_id != 6) {
        $seccion  = $request->sec;
      }
      else {
        $buscar = MatInscrita::where('ced_alum',$request->sec)->OrderBy('cod_sec','asc')->get();
        $seccion  = $buscar[0]->cod_sec;
      }


      $secciones  = MaterSeccion::where('codsec',$seccion)
      ->join('materias','materseccion.codmat','=','materias.cod')
      ->OrderBy('tipo','asc')
      ->OrderBy('des','asc')
      ->get();

      $notas = MatInscrita::where('cod_sec',$seccion)
      ->join('estudiantes','matinscritas.ced_alum','=','estudiantes.est_ced')
      ->join('materias','matinscritas.cod_mat','=','materias.cod')
      ->OrderBy('ced_alum','asc')
      ->OrderBy('tipo','asc')
      ->OrderBy('des','asc')
      ->get();
      $rep = $seccion[0].$seccion[1].$seccion[2]."U";

      $reparacion =  MatInscrita::where('cod_sec',$rep)
      ->join('estudiantes','matinscritas.ced_alum','=','estudiantes.est_ced')
      ->join('materias','matinscritas.cod_mat','=','materias.cod')
      ->OrderBy('ced_alum','asc')
      ->OrderBy('tipo','asc')
      ->OrderBy('des','asc')
      ->get(); 
      if (sizeof($notas) > 0) {
        return view ('evaluaciones.boletines')
        ->with('colegio',$colegio)
        ->with('secciones',$secciones)
        ->with('cedula',$cedula)
        ->with('notas',$notas)
        ->with('reparacion',$reparacion);
      }else {

        $secciones  = MaterSeccion::OrderBy('codsec','asc')
        ->get();
        $hijos  = Repest::where('rep_cedrep',Auth::user()->cedula)
        ->join('estudiantes','repest.rep_cedalum','=','estudiantes.est_ced')
        ->get();
        $error = 1;

        return view ('evaluaciones.seccion')->with('secciones',$secciones)->with('hijos',$hijos)->with('error',$error);
      }

    }

    //Controladores de boletines de primaria
    public function bole_sec_primaria(){
      $secciones  = MaterSeccion::OrderBy('codsec','asc')
      ->where('cedprof', Auth::user()->cedula)
      ->get();
      $hijos  = Repest::where('rep_cedrep',Auth::user()->cedula)
      ->join('estudiantes','repest.rep_cedalum','=','estudiantes.est_ced')
      ->join('matinscritas','repest.rep_cedalum','=','matinscritas.ced_alum')
      ->get();
      $error = 0;

      return view ('evaluaciones.seccion2')->with('secciones',$secciones)->with('hijos',$hijos)->with('error',$error);
    }

    public function boletines2(Request $request){
      $user     = Auth::user();
      $colegio  = Colegio::all();
      $cedula   =$request->sec;
      if ($user->tipo_id != 6) {
        $seccion  = $request->sec;
        $docente  = $user->cedula;
      }
      else {
        $buscar = MatInscrita::where('ced_alum',$request->sec)->OrderBy('cod_sec','asc')->get();
        $seccion  = $buscar[0]->cod_sec;
        $buscar = MaterSeccion::where('codsec',$seccion)->OrderBy('codsec','asc')->get();
        $docente  = $buscar[0]->cedprof;
      }

      //dd($docente);
      $secciones  = Planificacion::where('pla_docente',$docente)
                                                  ->where('pla_secion',$seccion)
                                                  ->where('pla_lapso',$request->lapso)
                                                  ->get();
      //dd($secciones);
      $notas = MatInscrita::where('cod_sec',$seccion)
                                    ->join('estudiantes','matinscritas.ced_alum','=','estudiantes.est_ced')
                                    ->join('materias','matinscritas.cod_mat','=','materias.cod')
                                    ->OrderBy('ced_alum','asc')
                                    ->OrderBy('tipo','asc')
                                    ->OrderBy('des','asc')
                                    ->get();
      if (sizeof($secciones) > 0 && sizeof($notas) > 0) {
        return view ('evaluaciones.boletines2')
                    ->with('colegio',$colegio)
                    ->with('secciones',$secciones)
                    ->with('cedula',$cedula)
                    ->with('lapso',$request->lapso)
                    ->with('notas',$notas);
      }else {
        $secciones  = MaterSeccion::OrderBy('codsec','asc')
                                  ->get();
        $hijos  = Repest::where('rep_cedrep',Auth::user()->cedula)
                                  ->join('estudiantes','repest.rep_cedalum','=','estudiantes.est_ced')
                                  ->get();
        $error = 1;
        return view ('evaluaciones.seccion2')->with('secciones',$secciones)->with('hijos',$hijos)->with('error',$error);
      }

    }
}
