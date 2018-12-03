@extends('main')

@section('title')
  @if (Auth::user()->tipo_id == 6)
    Boletin
  @else
    Boletines de la Seccion {{$notas[0]->cod_sec}}
  @endif

@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Evaluaciones</li>
    @if (Auth::user()->tipo_id == 6)
      <li class="active">Boletin</li>
    @else
      <li class="active">Boletines de la Seccion {{$notas[0]->cod_sec}}</li>
    @endif
  </ol>
@endsection

@section('content')
  <div class="box">
    <div class="box-body">
      <div class="row">
        <div class="col col-xs-12">
          <a href="{{route('boletines')}}" class="btn btn-info" type="button"><i class="fa fa-reply"></i> Volver</a>
          <button  id="todos" onclick="todos();" disabled class="imprimir btn btn-default" type="button"><i class="fa fa-print"></i> Imprimir Todos</button>
        </div>
        <hr>
      </div>
    @php
      $materias = sizeof($secciones);
      $pos = 0;
      $i = 1;
      $n   = array();
      $n2  = array();
      $n3  = array();
      $est = array();
      $est1 = array();
      $est2 = array();
      $est3 = array();
      $final = array();
      $final1 = array();
      $final2 = array();
      $final3 = array();
      $lapso1 = true;
      $lapso2 = true;
      $lapso3 = true;
    @endphp
    @foreach ($notas as $nota )
      @if ($pos ==  0)
        @php

        $n = array();
        $n2 = array();
        $n3 = array();
        $def = array();
        $pdef = array();
        $est[] = $nota->ced_alum;
        $est1[] = $nota->ced_alum;
        $est2[] = $nota->ced_alum;
        $est3[] = $nota->ced_alum;
        @endphp
        @if (Auth::user()->tipo_id == 6)
         <div style="display:  {{ $cedula == $nota->ced_alum ? 'block' : 'none'  }};">
        @endif
          <div class="table-responsive" id="boletines">
          <div id="{{$nota->ced_alum}}">
          <table class="table table-striped table-bordered table-hover" >
            <thead>
              <tr>
                <th colspan="6">
                  <button  onclick="pdf({{$nota->ced_alum}},0);" disabled class="imprimir btn btn-default" type="button"><i class="fa fa-print"></i> Imprimir</button>
                </th>
                <th   colspan="10">
                  <span id="Nombre_{{$nota->ced_alum}}">{{$nota->ced_alum}} - {{$nota->est_nombres}} {{$nota->est_apellidos}} - {{$i}}</span>
                </th>
              </tr>
                <tr>
                    <th rowspan="2" colspan="6" scope="col">Asignaturas</th>
                    <th colspan="2" scope="col1">Lapso 1</th>
                    <th colspan="2" scope="col2">Lapso 2</th>
                    <th colspan="2" scope="col3">Lapso 3</th>
                    <th colspan="1" scope="col4">Def</th>
                </tr>
                <tr>
                    <th colspan="1" scope="col1">Notas</th>
                    <th colspan="1" scope="col1">Inas</th>
                    <th colspan="1" scope="col2">Notas</th>
                    <th colspan="1" scope="col2">Inas</th>
                    <th colspan="1" scope="col3">Notas</th>
                    <th colspan="1" scope="col3">Inas</th>
                    <th colspan="1" scope="col4"></th>
                </tr>
            </thead>
            <tbody>
      @endif
              @if ($nota->tipo != 2)
              <tr>
                <td colspan="5" scope="row">{{$nota->des}}</td>
                <td colspan="1" scope="row">{{$nota->cond_materia}}</td>
                @if ($nota->nota1_deflap == 0)
                  <td id="N1_{{$nota->cod}}_{{$nota->ced_alum}}">-</td>
                  <td id="I1_{{$nota->cod}}_{{$nota->ced_alum}}">-</td>
                @else
                  @if ($nota->cualitativa == 0)
                    <td id="N1_{{$nota->cod}}_{{$nota->ced_alum}}">{{$nota->nota1_deflap}}</td>
                  @else
                      @if ($nota->nota1_deflap >= 18 && $nota->nota1_deflap <= 20 )
                        <td id="N1_{{$nota->cod}}_{{$nota->ced_alum}}">A</td>
                      @endif
                      @if ($nota->nota1_deflap >= 15 && $nota->nota1_deflap <= 17 )
                        <td id="N1_{{$nota->cod}}_{{$nota->ced_alum}}">B</td>
                      @endif
                      @if ($nota->nota1_deflap >= 12 && $nota->nota1_deflap <= 14 )
                        <td id="N1_{{$nota->cod}}_{{$nota->ced_alum}}">C</td>
                      @endif
                      @if ($nota->nota1_deflap <= 11 )
                        <td id="N1_{{$nota->cod}}_{{$nota->ced_alum}}">D</td>
                      @endif
                  @endif
                  <td id="I1_{{$nota->cod}}_{{$nota->ced_alum}}">{{$nota->inasis1}}</td>
                @endif
                @php
                  if ($nota->tipo <=1 && $nota->cualitativa == 0) {
                    $n[]   = $nota->nota1_deflap;
                  }
                    $def[] = $nota->nota1_deflap;

                @endphp
                @if ($nota->nota2_deflap == 0)
                  <td id="N2_{{$nota->cod}}_{{$nota->ced_alum}}">-</td>
                  <td id="I2_{{$nota->cod}}_{{$nota->ced_alum}}">-</td>
                @else
                  <td id="N2_{{$nota->cod}}_{{$nota->ced_alum}}">{{$nota->nota2_deflap}}</td>
                  @if ($nota->cualitativa == 0)
                    <td id="N2_{{$nota->cod}}_{{$nota->ced_alum}}">{{$nota->nota2_deflap}}</td>
                  @else
                      @if ($nota->nota2_deflap >= 18 && $nota->nota2_deflap <= 20 )
                        <td id="N2_{{$nota->cod}}_{{$nota->ced_alum}}">A</td>
                      @endif
                      @if ($nota->nota2_deflap >= 15 && $nota->nota2_deflap <= 17 )
                        <td id="N2_{{$nota->cod}}_{{$nota->ced_alum}}">B</td>
                      @endif
                      @if ($nota->nota2_deflap >= 12 && $nota->nota2_deflap <= 14 )
                        <td id="N2_{{$nota->cod}}_{{$nota->ced_alum}}">C</td>
                      @endif
                      @if ($nota->nota2_deflap <= 11 )
                        <td id="N2_{{$nota->cod}}_{{$nota->ced_alum}}">D</td>
                      @endif
                  @endif
                  <td id="I2_{{$nota->cod}}_{{$nota->ced_alum}}">{{$nota->inasis2}}</td>
                  @php
                  if ($nota->tipo <=1 && $nota->cualitativa == 0) {
                    $n2[]  = $nota->nota2_deflap;
                  }
                    $def[] = $nota->nota2_deflap;
                  @endphp
                @endif

                @if ($nota->nota3_deflap == 0)
                  <td id="N3_{{$nota->cod}}_{{$nota->ced_alum}}">-</td>
                  <td id="I3_{{$nota->cod}}_{{$nota->ced_alum}}">-</td>
                @else
                  @if ($nota->cualitativa == 0)
                    <td id="N3_{{$nota->cod}}_{{$nota->ced_alum}}">{{$nota->nota3_deflap}}</td>
                  @else
                      @if ($nota->nota3_deflap >= 18 && $nota->nota3_deflap <= 20 )
                        <td id="N3_{{$nota->cod}}_{{$nota->ced_alum}}">A</td>
                      @endif
                      @if ($nota->nota3_deflap >= 15 && $nota->nota3_deflap <= 17 )
                        <td id="N3_{{$nota->cod}}_{{$nota->ced_alum}}">B</td>
                      @endif
                      @if ($nota->nota3_deflap >= 12 && $nota->nota3_deflap <= 14 )
                        <td id="N3_{{$nota->cod}}_{{$nota->ced_alum}}">C</td>
                      @endif
                      @if ($nota->nota3_deflap <= 11 )
                        <td id="N3_{{$nota->cod}}_{{$nota->ced_alum}}">D</td>
                      @endif
                  @endif
                  <td id="I3_{{$nota->cod}}_{{$nota->ced_alum}}">{{$nota->inasis3}}</td>
                  @php
                  if ($nota->tipo <=1 && $nota->cualitativa == 0) {
                    $n3[]  = $nota->nota3_deflap;
                  }
                    $def[] = $nota->nota3_deflap;
                  @endphp
                @endif

                @if (sizeof($def) > 0)
                  @if (array_sum($def) > 0 )
                    @if ($nota->cualitativa == 0)
                      <td id="def_{{$nota->cod}}_{{$nota->ced_alum}}">{{round(array_sum($def)/count($def),2)}}</td>
                    @else
                      @if (round(array_sum($def)/count($def),2) >= 18 && round(array_sum($def)/count($def),2) <= 20 )
                        <td id="def_{{$nota->cod}}_{{$nota->ced_alum}}">A</td>
                      @endif
                      @if (round(array_sum($def)/count($def),2) >= 15 && round(array_sum($def)/count($def),2) <= 17 )
                        <td id="def_{{$nota->cod}}_{{$nota->ced_alum}}">B</td>
                      @endif
                      @if (round(array_sum($def)/count($def),2) >= 12 && round(array_sum($def)/count($def),2) <= 14 )
                        <td id="def_{{$nota->cod}}_{{$nota->ced_alum}}">C</td>
                      @endif
                      @if (round(array_sum($def)/count($def),2) <= 11 )
                        <td id="def_{{$nota->cod}}_{{$nota->ced_alum}}">D</td>
                      @endif
                    @endif
                  @else
                    <td id="def_{{$nota->cod}}_{{$nota->ced_alum}}">0</td>
                  @endif
                @else
                    <td id="def_{{$nota->cod}}_{{$nota->ced_alum}}">-</td>
                @endif
                @php
                    unset($def);
                @endphp
              </tr>
              @endif
      @php
        $pos = $pos +1;
      @endphp
      @if ($pos ==  $materias)
        <!-- REPARACION-->
        @for ($x=0; $x < sizeof($reparacion) ; $x++)
          @if ($nota->ced_alum == $reparacion[$x]->ced_alum)
          <tr>
            <td colspan="5" scope="row">{{$reparacion[$x]->des}}</td>
            <td colspan="1" scope="row">{{$reparacion[$x]->cond_materia}}</td>
            @if ($reparacion[$x]->nota1_deflap == 0)
              <td id="N1_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">-</td>
              <td id="I1_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">-</td>
            @else
              <td id="N1_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">{{$reparacion[$x]->nota1_deflap}}</td>
              <td id="I1_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">{{$reparacion[$x]->inasis1}}</td>
            @endif
            @php
              if ($reparacion[$x]->tipo <=1) {
                $n[]   = $reparacion[$x]->nota1_deflap;
              }
              $def[] = $reparacion[$x]->nota1_deflap;
            @endphp
            @if ($reparacion[$x]->nota2_deflap == 0)
              <td id="N2_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">-</td>
              <td id="I2_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">-</td>
            @else
              <td id="N2_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">{{$reparacion[$x]->nota2_deflap}}</td>
              <td id="I2_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">{{$reparacion[$x]->inasis2}}</td>
              @php
              if ($reparacion[$x]->tipo <=1) {
                $n2[]  = $reparacion[$x]->nota2_deflap;
              }
                $def[] = $reparacion[$x]->nota2_deflap;
              @endphp
            @endif

            @if ($reparacion[$x]->nota3_deflap == 0)
              <td id="N3_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">-</td>
              <td id="I3_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">-</td>
            @else
              <td id="N3_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">{{$reparacion[$x]->nota3_deflap}}</td>
              <td id="I3_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">{{$reparacion[$x]->inasis3}}</td>
              @php
              if ($reparacion[$x]->tipo <=1) {
                $n3[]  = $reparacion[$x]->nota3_deflap;
              }
                $def[] = $reparacion[$x]->nota3_deflap;
              @endphp
            @endif

            @if (sizeof($def) > 0)
              @if (array_sum($def) > 0 )
                <td id="def_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">{{round(array_sum($def)/count($def),2)}}</td>
              @else
                <td id="def_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">0</td>
              @endif
            @else
                <td id="def_{{$reparacion[$x]->cod}}_{{$reparacion[$x]->ced_alum}}">-</td>
            @endif
            @php
                unset($def);
            @endphp
          </tr>
          @endif
        @endfor
        <!-- FIN REPARACION-->
        <tr>
          <td colspan="6" scope="col">Promedio</td>

            @if (sizeof($n) > 0)
              <td colspan="2" id="p1_{{$nota->ced_alum}}" scope="col">{{round(array_sum($n)/count($n),2)}}</td>
              @php
                $pdef[]   = round(array_sum($n)/count($n),2);
                $final1[] = round(array_sum($n)/count($n),2);
              @endphp
            @else
              <td colspan="2" id="p1_{{$nota->ced_alum}}">-</td>
              @php
                $final1[] = round(0,2);
                $lapso1 = false;
              @endphp
            @endif
            @if (sizeof($n2) > 0)
              <td colspan="2" id="p2_{{$nota->ced_alum}}" scope="col">{{round(array_sum($n2)/count($n2),2)}}</td>
              @php
                $pdef[] = round(array_sum($n2)/count($n2),2);
                $final2[] = round(array_sum($n2)/count($n2),2);
              @endphp
            @else
              <td colspan="2" id="p2_{{$nota->ced_alum}}">-</td>
              @php
                $final2[] = round(0,2);
                $lapso2 = false;
              @endphp
            @endif
            @if (sizeof($n3) > 0)
              <td colspan="2" id="p3_{{$nota->ced_alum}}" scope="col">{{round(array_sum($n3)/count($n3),2)}}</td>
              @php
                $pdef[] = round(array_sum($n3)/count($n3),2);
                $final3[] = round(array_sum($n3)/count($n3),2);
              @endphp
            @else
              <td colspan="2" id="p3_{{$nota->ced_alum}}">-</td>
              @php
                $final3[] = round(0,2);
                $lapso3 = false;
              @endphp
            @endif

          <td id="pd_{{$nota->ced_alum}}" colspan="1" scope="col">{{round(array_sum($pdef)/count($pdef), 2)}}</td>
          @php
            $final[] = round(array_sum($pdef)/count($pdef),2);
          @endphp
        </tr>
        <tr>
          <td  colspan="6" scope="col">Posicion</td>
          <td  id="pos1_{{$nota->ced_alum}}" colspan="2" scope="col">-</td>
          <td  id="pos2_{{$nota->ced_alum}}" colspan="2" scope="col">-</td>
          <td  id="pos3_{{$nota->ced_alum}}" colspan="2" scope="col">-</td>
          <td  id="pos_{{$nota->ced_alum}}" colspan="1" scope="col">-</td>
        </tr>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
          </div>
        </div>
        @if (Auth::user()->tipo_id == 6)
      </div>
    @endif
        @php
          unset($n);
          unset($n2);
          unset($n3);
          $pos = 0;
          $i++;
        @endphp
      @endif
    @endforeach
    </div>
  </div>
@endsection
@section('js')
  <script src="{{ asset('adminlte/plugins/jspdf/jspdf.debug.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jspdf/faker.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jspdf/jspdf.plugin.autotable.js') }}"></script>


  <script type="text/javascript">

  var doc = new jsPDF('p', 'pt', 'letter');
  var logo = new Image();
  var logo2 = new Image();
  var logo3 = new Image();

    window.onload=function() {

      logo.src = "{{ asset('img/logo.png') }}";
      logo2.src = "{{ asset('img/boletin.png') }}";
      if ({{$colegio[0]->logo2}} == 1) {
        logo3.src = "{{ asset('img/logo2.png') }}";
        logo.onload = function(){
          $('.imprimir').removeAttr("disabled")
         logo2.onload = function(){
           $('.imprimir').removeAttr("disabled")
           logo3.onload = function(){
             $('.imprimir').removeAttr("disabled")
          };
         };
        };
      }
      else {
        logo.onload = function(){
         logo2.onload = function(){
           $('.imprimir').removeAttr("disabled")
         };
        };
      }

      @php
        $n     = sizeof($est);
        $incre = $n/2;
        $ban;
      @endphp
      @for ($i=0; $i < $n-1 ; $i++)
        @for ($j=$i+1; $j < $n ; $j++)
          @if ($final1[$i] < $final1[$j])
            @php
              $aux        = $final1[$i];
              $final1[$i] = $final1[$j];
              $final1[$j] = $aux;
              $aux        = $est1[$i];
              $est1[$i] = $est1[$j];
              $est1[$j] = $aux;
            @endphp
          @endif
          @if ($final2[$i] < $final2[$j])
            @php
              $aux        = $final2[$i];
              $final2[$i] = $final2[$j];
              $final2[$j] = $aux;
              $aux        = $est2[$i];
              $est2[$i] = $est2[$j];
              $est2[$j] = $aux;
            @endphp
          @endif
          @if ($final3[$i] < $final1[$j])
            @php
              $aux        = $final3[$i];
              $final3[$i] = $final3[$j];
              $final3[$j] = $aux;
              $aux        = $est3[$i];
              $est3[$i] = $est3[$j];
              $est3[$j] = $aux;
            @endphp
          @endif
          @if ($final[$i] < $final[$j])
            @php
              $aux        = $final[$i];
              $final[$i] = $final[$j];
              $final[$j] = $aux;
              $aux        = $est[$i];
              $est[$i] = $est[$j];
              $est[$j] = $aux;
            @endphp
          @endif
        @endfor
      @endfor

      @for ($i=0; $i < $n ; $i++)
      @if ($lapso1)
        document.getElementById('pos1_{{$est1[$i]}}').innerHTML = "{{($i+1)}}/{{$n}}"
      @endif
      @if ($lapso2)
        document.getElementById('pos2_{{$est2[$i]}}').innerHTML = "{{($i+1)}}/{{$n}}"
      @endif
      @if ($lapso3)
        document.getElementById('pos3_{{$est3[$i]}}').innerHTML = "{{($i+1)}}/{{$n}}"
      @endif
      document.getElementById('pos_{{$est[$i]}}').innerHTML = "{{($i+1)}}/{{$n}}"
      @endfor
      @if (Auth::user()->tipo_id == 6)
        document.getElementById('todos').style = "display: none;"
        @for($i=0; $i < $n ; $i++)

        if ({{$est1[$i]}} != {{$cedula}}) {
        //  document.getElementById('{{$est1[$i]}}').style = "display: none;"
        }

        @endfor
      @endif
    }

  function todos()
  {
    var band = 1;
    @for ($i=0; $i < sizeof($est) ; $i++)
      pdf({{$est[$i]}},band)
      if (band == 1) {
        band =2;
      }
    @endfor
    doc.save('Boletines.pdf');
  }

  function encabezado(tipo)
  {
    if (tipo == 0 || tipo == 1) {
      doc = new jsPDF('p', 'pt', 'letter');
    }
    else {
      doc.addPage();
    }

    doc.addImage(logo, 'png', 20, 20,100,100);

    doc.setFontSize(8);

    doc.setFontType("bold");
    text = "{{$colegio[0]->nombre}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 40, text);

    doc.setFontType("default");
    text = "CODIGO PLANTEL {{$colegio[0]->codigodea}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 50, text);

    text = "{{$colegio[0]->direccion}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 60, text);

    text = "{{$colegio[0]->telefono}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 70, text);

    text = "{{$colegio[0]->localidad}} Edo. {{$colegio[0]->zonaeducativa}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 80, text);

    text = "{{$colegio[0]->convenioavec}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 90, text);

    if ({{$colegio[0]->logo2}} == 1) {
      doc.addImage(logo3, 'png', doc.internal.pageSize.width - 140,20,100,80);
      texto1 = "Fecha y hora: ";
      var f = new Date();
      var texto2 = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 100, text);

      texto1 = "Año Escolar: ";
      var texto2 = "{{$notas[0]->periescolar}}";
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 110, text);

    }else{
      texto1 = "Fecha y hora: ";
      var f = new Date();
      var texto2 = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 40, text);

      texto1 = "Año Escolar: ";
      var texto2 = "{{$notas[0]->periescolar}}";
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 50, text);

  }

    text = "Datos del Estudiante";
    doc.setFontSize(10);
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 145, text);

    doc.line(20, 150, (doc.internal.pageSize.width - 20), 150); // horizontal line

  }

  function pdf(cedula,tipo) {

      encabezado(tipo);
      cn  = document.getElementById('Nombre_'+cedula).innerHTML;
      vac = cn.split("-");

      texto1 = "Cédula de Identidad: ";
      var texto2 = ""+vac[0];
      var text = texto1+texto2;
      doc.text(40, 170, text);

      texto1 = "Nombres y Apellidos: ";
      var texto2 = ""+vac[1];
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 170, text);

      texto1 = "Seccion: ";
      sec = "{{$notas[0]->cod_sec}}";
      año = ""+sec[0]+sec[1]+sec[2];
/*
	  console.log("Mirar //////->"+año);
      if (año == "B17") {
        var text = "Primer año seccion "+sec[3];
      }
      if (año == "B28") {
        var text = "Segundo año seccion "+sec[3];
      }
      if (año == "B39") {
        var text = "Tercer año seccion "+sec[3];
      }
      if (año == "B41") {
        var text = "Cuarto año seccion "+sec[3];
      }
      if (año == "B52") {
        var text = "Quinto año seccion "+sec[3];
      }
*/
	  console.log("Mirar //////->"+año);
      if (año == "B17") {
        var text = "PRIMER AÑO "+sec[3];
      }
      if (año == "B28") {
        var text = "SEGUNDO AÑO "+sec[3];
      }
      if (año == "B39") {
        var text = "TERCER AÑO "+sec[3];
      }
      if (año == "B41") {
        var text = "CUARTO AÑO "+sec[3];
      }
      if (año == "B52") {
        var text = "QUINTO AÑO "+sec[3];
      }


      console.log("Mirar seccion->"+text);
      doc.text(40, 185, text);

      texto1 = "Numero de lista: ";
      var texto2 = ""+vac[2];
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 185, text);

      text = "Calificaciones Obtenidas";
      doc.setFontSize(10);
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
      doc.text(textOffset, 210, text);

      doc.line(20, 220, (doc.internal.pageSize.width - 20), 220); // horizontal line

      text = "Áreas de Formación";
      doc.text(140, 250, text);

      text = "Lapso I";
      doc.text(350, 240, text);
      text = "Nota";
      doc.text(340, 250, text);
      text = "Inas";
      doc.text(370, 250, text);

      text = "Lapso II";
      doc.text(420, 240, text);
      text = "Nota";
      doc.text(410, 250, text);
      text = "Inas";
      doc.text(440, 250, text);

      text = "Lapso III";
      doc.text(490, 240, text);
      text = "Nota";
      doc.text(480, 250, text);
      text = "Inas";
      doc.text(510, 250, text);

      text = "Def";
      doc.text(560, 245, text);

      doc.setLineWidth(1);
      doc.setDrawColor(221, 221, 221);
      doc.line(30, 255, (doc.internal.pageSize.width - 30), 255); // horizontal line


      doc.setFontSize(8);
      i = 0;
      @foreach ($notas as $mat)
        if ({{$mat->tipo}} != 2  && {{$mat->ced_alum}} == cedula ){
          text = "{{$mat->des}}";
          doc.text(30, 270+i, text);

          text = "{{$mat->cond_materia}}";
          doc.text(300, 270+i, text);

          text = document.getElementById('N1_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(340, 270+i, text);

          text = document.getElementById('I1_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(380, 270+i, text);

          text = document.getElementById('N2_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(420, 270+i, text);

          text = document.getElementById('I2_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(450, 270+i, text);

          text = document.getElementById('N3_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(490, 270+i, text);

          text = document.getElementById('I3_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(520, 270+i, text);

          text = document.getElementById('def_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(560, 270+i, text);

          doc.setLineWidth(1);
          doc.setDrawColor(221, 221, 221);
          doc.line(30, 270+i+5, (doc.internal.pageSize.width - 30), 270+i+5); // horizontal line
          i= i+ 20;
        }
      @endforeach
      @foreach ($reparacion as $mat)
        if ({{$mat->tipo}} != 2  && {{$mat->ced_alum}} == cedula ){
          text = "{{$mat->des}}";
          doc.text(30, 270+i, text);

          text = "{{$mat->cond_materia}}";
          doc.text(300, 270+i, text);

          text = document.getElementById('N1_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(340, 270+i, text);

          text = document.getElementById('I1_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(380, 270+i, text);

          text = document.getElementById('N2_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(420, 270+i, text);

          text = document.getElementById('I2_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(450, 270+i, text);

          text = document.getElementById('N3_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(490, 270+i, text);

          text = document.getElementById('I3_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(520, 270+i, text);

          text = document.getElementById('def_{{$mat->cod}}_'+cedula).innerHTML;
          doc.text(560, 270+i, text);

          doc.setLineWidth(1);
          doc.setDrawColor(221, 221, 221);
          doc.line(30, 270+i+5, (doc.internal.pageSize.width - 30), 270+i+5); // horizontal line
          i= i+ 20;
        }
      @endforeach
      text = "PROMEDIO";
      doc.text(270, 270+i, text);

      text = document.getElementById('p1_'+cedula).innerHTML;
      doc.text(340, 270+i, text);

      text = document.getElementById('p2_'+cedula).innerHTML;
      doc.text(420, 270+i, text);

      text = document.getElementById('p3_'+cedula).innerHTML;
      doc.text(490, 270+i, text);

      text = document.getElementById('pd_'+cedula).innerHTML;
      doc.text(560, 270+i, text);

      doc.setLineWidth(1);
      doc.setDrawColor(221, 221, 221);
      doc.line(30, 270+i+5, (doc.internal.pageSize.width - 30), 270+i+5);


      i= i+ 20;
      text = "POSICION";
      doc.text(270, 270+i, text);

      text = document.getElementById('pos1_'+cedula).innerHTML;
      doc.text(340, 270+i, text);

      text = document.getElementById('pos2_'+cedula).innerHTML;
      doc.text(420, 270+i, text);

      text = document.getElementById('pos3_'+cedula).innerHTML;
      doc.text(490, 270+i, text);

      text = document.getElementById('pos_'+cedula).innerHTML;
      doc.text(560, 270+i, text);

      doc.setLineWidth(1);
      doc.setDrawColor(221, 221, 221);
      doc.line(320, 255, 320, 270+i+5); // horizontal line

      doc.setLineWidth(1);
      doc.setDrawColor(221, 221, 221);
      doc.line(400, 255, 400, 270+i+5); // horizontal line

      doc.setLineWidth(1);
      doc.setDrawColor(221, 221, 221);
      doc.line(470, 255, 470, 270+i+5); // horizontal line

      doc.setLineWidth(1);
      doc.setDrawColor(221, 221, 221);
      doc.line(540, 255, 540, 270+i+5); // horizontal line

      i= i+ 30;
      doc.setFontSize(10);
      text = "Observaciones:";
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
      doc.text(30, 270+i, text);

      i= i+ 20;
      doc.setLineWidth(1);
      doc.setDrawColor(0,0,0);
      doc.line(30, 270+i+5, (doc.internal.pageSize.width - 30), 270+i+5); // horizontal line

      i= i+ 20;
      doc.setLineWidth(1);
      doc.setDrawColor(0,0,0);
      doc.line(30, 270+i+5, (doc.internal.pageSize.width - 30), 270+i+5); // horizontal line


      i= i+ 10;
      doc.addImage(logo2, 'png',150, 270+i,300,120);

      i= i+ 130;
      doc.line(310, 270+i+5,500, 270+i+5); // horizontal line
      doc.line(100, 270+i+5,290, 270+i+5); // horizontal line
      i= i+ 20;
      text = "Firma de Prof. Guia";
      doc.text(350, 270+i, text);

      text = "Firma del Representante";
      doc.text(150, 270+i, text);



      if (tipo == 0) {
        doc.save('Boletin_'+cedula+'.pdf');
      }
  }
  </script>
@endsection
