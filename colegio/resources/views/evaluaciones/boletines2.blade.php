@extends('main')

@section('title')
  @if (Auth::user()->tipo_id == 6)
    Boletin del Lapso {{$lapso}}
  @else
    Boletines de la Seccion {{$notas[0]->cod_sec}}, Lapso {{$lapso}}
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
          <a href="{{route('boletines_primaria')}}" class="btn btn-info" type="button"><i class="fa fa-reply"></i> Volver</a>
          <button  id="todos" onclick="todos();" disabled class="imprimir btn btn-default" type="button"><i class="fa fa-print"></i> Imprimir Todos</button>
        </div>
        <hr>
      </div>
      <hr>
    @php


      $pos = 1;
      $est = array();

    @endphp
    @foreach ($notas as $nota )
      @if (Auth::user()->tipo_id == 6)
        <div style="display:  {{ $cedula == $nota->ced_alum ? 'block' : 'none'  }};">
          @endif
          <div class="table-responsive" id="boletines">
            <div id="{{$nota->ced_alum}}">
              <table class="table table-striped table-bordered table-hover" >
              <thead>
                <tr>
                  <th >
                    <span id="Nombre_{{$nota->ced_alum}}">{{$nota->ced_alum}} - {{$nota->est_nombres}} {{$nota->est_apellidos}} - {{$pos}}</span><button  onclick="pdf({{$nota->ced_alum}},0);" disabled class="imprimir btn btn-default pull-right" type="button"><i class="fa fa-print"></i> Imprimir</button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td>
                      @for ($i=0; $i < sizeof($secciones); $i++)
                        <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                                {{$secciones[$i]->pla_ins}}
                            </h4>
                          </div>
                          <div>
                            <div class="box-body" >
                              <p id="Des_{{$i}}_{{$nota->ced_alum}}">
                              @if ($lapso == 1)
                                @if ($i == 0)
                                  {{$nota->Des1_1}}
                                @endif
                                @if ($i == 1)
                                  {{$nota->Des1_2}}
                                @endif
                                @if ($i == 2)
                                  {{$nota->Des1_3}}
                                @endif
                                @if ($i == 3)
                                  {{$nota->Des1_4}}
                                @endif
                                @if ($i == 4)
                                  {{$nota->Des1_5}}
                                @endif
                              @endif
                              @if ($lapso == 2)
                                @if ($i == 0)
                                  {{$nota->Des2_1}}
                                @endif
                                @if ($i == 1)
                                  {{$nota->Des2_2}}
                                @endif
                                @if ($i == 2)
                                  {{$nota->Des2_3}}
                                @endif
                                @if ($i == 3)
                                  {{$nota->Des2_4}}
                                @endif
                                @if ($i == 4)
                                  {{$nota->Des2_5}}
                                @endif
                                @if ($lapso == 3)
                                  @if ($i == 0)
                                    {{$nota->Des3_1}}
                                  @endif
                                  @if ($i == 1)
                                    {{$nota->Des3_2}}
                                  @endif
                                  @if ($i == 2)
                                    {{$nota->Des3_3}}
                                  @endif
                                  @if ($i == 3)
                                    {{$nota->Des3_4}}
                                  @endif
                                  @if ($i == 4)
                                    {{$nota->Des3_5}}
                                  @endif
                                @endif
                              @endif
                              </p>
                            </div>
                          </div>
                        </div>
                      @endfor
                    </td>
                </tr>
              </tbody>
            </table>
            </div>
          </div>
      @if (Auth::user()->tipo_id == 6)
        </div>
      @endif
        @php
          $pos++;
          $est[] = $nota->ced_alum;
        @endphp
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
          $('.imprimir').removeAttr("disabled");
         logo2.onload = function(){
            $('.imprimir').removeAttr("disabled");
           logo3.onload = function(){
             $('.imprimir').removeAttr("disabled");

          };
         };
        };
      }
      else {
        logo.onload = function(){
         logo2.onload = function(){
           $('.imprimir').removeAttr("disabled");
         };
        };
      }

      @if (Auth::user()->tipo_id == 6)
        document.getElementById('todos').style = "display: none;"
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

  function encabezado(tipo){
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

      texto1 = "Lapso: ";
      var texto2 = "{{$lapso}}";
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 120, text);
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

      texto1 = "Lapso: ";
      var texto2 = "{{$lapso}}";
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 60, text);
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

      texto1 = "Cedula: ";
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

      if (año == "P11") {
        var text = "Primer Grado seccion "+sec[3];
      }
      if (año == "P22") {
        var text = "Segundo Grado seccion "+sec[3];
      }
      if (año == "P33") {
        var text = "Tercer Grado seccion "+sec[3];
      }
      if (año == "P44") {
        var text = "Cuarto Grado seccion "+sec[3];
      }
      if (año == "P55") {
        var text = "Quinto Grado seccion "+sec[3];
      }
      if (año == "P66") {
        var text = "Sexto Grado seccion "+sec[3];
      }
      if (año == "M33") {
        var text = "Pre-Escolar seccion "+sec[3];
      }
      console.log("Mirar seccion->"+text);
      doc.text(40, 185, text);

      texto1 = "Numero de lista: ";
      var texto2 = ""+vac[2];
      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.text(textOffset, 185, text);

      size =8;
      doc.setFontSize(size);
      verticalOffset = 210;
      @for ($i=0; $i < sizeof($secciones); $i++)
        text = "{{$secciones[$i]->pla_ins}}";

        var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
        doc.text(textOffset,verticalOffset, text);

        verticalOffset = verticalOffset + 10;
        doc.line(20, verticalOffset, (doc.internal.pageSize.width - 20), verticalOffset); // horizontal line

        verticalOffset = verticalOffset + 20;

        text = document.getElementById("Des_{{$i}}_"+cedula).innerText;
        console.log(text);
        lines = doc.splitTextToSize(text, doc.internal.pageSize.width-40);
        doc.text(20, (verticalOffset + size / 72), lines);

        verticalOffset += (lines.length + 1)*12;
      @endfor

      doc.line(100, 660, 200, 660); // horizontal line
      doc.line(100, 680, 200, 680); // horizontal line
      text = "Docentes";
      doc.text(50,660, text);


      doc.line(400, 660, 500, 660); // horizontal line
      text = "Representante";
      doc.text(320, 660, text);

      doc.line(100, 720, 250, 720); // horizontal line
      text = "{{$colegio[0]->nomdirector}}";
      doc.text(130, 740, text);
      text = "Director(a) del Plantel";
      doc.text(130, 760, text);



      doc.line(300, 720, 450, 720); // horizontal line
      text = "{{$colegio[0]->coor_primaria}}";
      doc.text(320, 740, text);
      text = "Coordinador de planes y proyectos";
      doc.text(310, 760, text);
      text = "Educacion Inicial y Primaria";
      doc.text(315, 780, text);

      if (tipo == 0) {
        doc.save('Boletin_'+cedula+'.pdf');
      }
  }
  </script>
@endsection
