@extends('main')

@section('title')
  Constancias
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Reportes</li>
    <li class="active">Constancias</li>
  </ol>
@endsection
@section('content')
  <!-- Default box -->
  <div class="box">
    <div class="box-body">
      @if (Auth::user()->tipo_id != 6)
        <div class="form-group">
          <label for="cedulaE">Estudiante</label>
          <select class="form-control" name="cedulaE" id="cedulaE">
            <option value="" disabled selected >Seleccione Estudiante</option>
            @php
              $cedula = -100;
            @endphp

              @foreach ($repres as $estudiante)
                <option value="{{$estudiante->cod_sec}}-{{$estudiante->est_ced}}-{{$estudiante->est_nombres}} {{$estudiante->est_apellidos}}-{{$estudiante->est_lugnac}}">{{ $estudiante->est_ced }} - {{ $estudiante->est_nombres}}{{ $estudiante->est_apellidos}}</option>
              @endforeach
          </select>
        </div>
        @else
          <div class="form-group">
            <label for="cedulaE">Estudiante</label>
            <select class="form-control" name="cedulaE" id="cedulaE">
              <option value="" disabled selected >Seleccione Estudiante</option>
              @php
                $cedula = -100;
              @endphp
              @foreach ($repres as $repre)
                @if ($cedula != $repre->rep_cedalum)
                    <option value="{{$repre->cod_sec}}-{{$repre->rep_cedalum}}-{{$repre->est_nombres}} {{$repre->est_apellidos}}-{{$repre->est_lugnac}}">{{$repre->est_nombres}} {{$repre->est_apellidos}}</option>
                    @php
                      $cedula = $repre->rep_cedalum;
                    @endphp
                @endif
              @endforeach
            </select>
          </div>
      @endif
      <div class="form-group">
        <label for="lapso">Constancias</label>
        <select class="form-control"  name="tipo" id="tipo">
          <option value="">Seleccione una Constancias</option>
          <option value="1">Constancia de Conducta</option>
          <option value="2">Constancia de Estudio</option>
          <option value="3">Constancia de Inscripcion</option>
          <option value="4">Constancia de Retiro</option>
        </select>
      </div>
      <button  id="todos" disabled onclick="pdf();" class="imprimir btn btn-default" type="button"><i class="fa fa-print"></i> Imprimir Constancia</button>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
@endsection
@section('js')
  <script src="{{ asset('adminlte/plugins/jspdf/jspdf.debug.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jspdf/faker.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jspdf/jspdf.plugin.autotable.js') }}"></script>


  </script>
  <script type="text/javascript">

  var doc = new jsPDF('p', 'pt', 'letter');
  var logo = new Image();
  var titulo;


    window.onload=function() {
      logo.src = "{{ asset('img/logo.png') }}";
      logo.onload = function(){
         $('.imprimir').removeAttr("disabled")
      };
    }
    function encabezado(tipo){
      doc = new jsPDF('p', 'pt', 'letter');
      doc.addImage(logo, 'png', 50, 45,70,70);

      doc.setFontSize(10);
      text = "{{$colegio[0]->nombre}}";
      doc.text(180, 70, text);

      text = "Inscrito en el Ministerio del Poder Popular para la Educación";
      doc.text(180, 80, text);

      text = "{{$colegio[0]->localidad}}-Municipio{{$colegio[0]->municipio}}-Estado{{$colegio[0]->zonaeducativa}}";
      doc.text(180, 90, text);

      if (tipo == 1) {
        text = "CONSTACIA DE CONDUCTA";
      }
      if (tipo == 2) {
        text = "CONSTACIA DE ESTUDIOS";
      }
      if (tipo == 3) {
        text = "CONSTACIA DE INSCRIPCION";
      }
      if (tipo == 4) {
        text = "CONSTACIA DE RETIRO";
      }

      size =18;
      doc.setFontType("bold");
      doc.setFontSize(size);
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
      doc.text(textOffset, 160, text);
      doc.setFontType("default");

    }

    function pdf() {
        if (document.getElementById('cedulaE').value != "" && document.getElementById('tipo').value != "") {
          tipo = document.getElementById('tipo').value;
          cadena = document.getElementById('cedulaE').value;
          datos = cadena.split("-");
          var grado;
          if (""+datos[0][0]+datos[0][1] == "M3") {
            grado = "Pre-Escolar seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "P1") {
            grado = "Primer Grado seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "P2") {
            grado = "Segundo Grado seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "P3") {
            grado = "Tercer Grado seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "P4") {
            grado = "Cuarto Grado seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "P5") {
            grado = "Quinto Grado seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "P6") {
            grado = "Sexto Grado seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "01") {
            grado = "Primer Año seccion"+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "02") {
            grado = "Segundo Año seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "03") {
            grado = "Tercer Año seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "D4") {
            grado = "Cuarto Año seccion "+datos[0][3];
          }
          if (""+datos[0][0]+datos[0][1] == "D5") {
            grado = "Quinto Año seccion "+datos[0][3];
          }
          encabezado(tipo);
          size =15;
          doc.setFontSize(size);
          verticalOffset = 210;
          if (tipo == 1) {
            text = "Quien suscribe, {{$colegio[0]->nomdirector}} ,titular de la cédula de identidad N° {{$colegio[0]->ceddirector}} , en su carácter de Directora de la {{$colegio[0]->nombre}}, Código de Plantel {{$colegio[0]->codigodea}}, por medio de la presente hace constar que el estudiante: "+datos[2]+", con cédula de identidad V-"+datos[1]+", cursa en esta Institución "+grado+",durante el año escolar: {{$filtros[0]->codlapso}} y durante su permanencia en el mismo se observó BUENA CONDUCTA. Constancia que se expide a petición de la parte interesada para fines legales y se firma en {{$colegio[0]->localidad}}, el {{$fecha}}.";
          }
          if (tipo == 2) {
            text = "Quien suscribe, {{$colegio[0]->nomdirector}} ,titular de la cédula de identidad N° {{$colegio[0]->ceddirector}} , en su carácter de Directora de la {{$colegio[0]->nombre}}, Código de Plantel {{$colegio[0]->codigodea}}, por medio de la presente hace constar que el estudiante: "+datos[2]+", con cédula de identidad V-"+datos[1]+", cursa en esta Institución "+grado+",durante el año escolar: {{$filtros[0]->codlapso}}. Constancia que se expide a petición de la parte interesada para fines legales y se firma en {{$colegio[0]->localidad}}, el {{$fecha}}.";
          }
          if (tipo == 3) {
            text = "Quien suscribe, {{$colegio[0]->nomdirector}} ,titular de la cédula de identidad N° {{$colegio[0]->ceddirector}} , en su carácter de Directora de la {{$colegio[0]->nombre}}, Código de Plantel {{$colegio[0]->codigodea}}, por medio de la presente hace constar que el estudiante: "+datos[2]+", con cédula de identidad V-"+datos[1]+", está inscrito  en esta Institución para cursar "+grado+",durante el año escolar: {{$filtros[0]->codlapso}} y durante su permanencia en el mismo se observó BUENA CONDUCTA. Constancia que se expide a petición de la parte interesada para fines legales y se firma en {{$colegio[0]->localidad}}, el {{$fecha}}.";
          }
          if (tipo == 4) {
            text = "Quien suscribe, {{$colegio[0]->nomdirector}} ,titular de la cédula de identidad N° {{$colegio[0]->ceddirector}} , en su carácter de Directora de la {{$colegio[0]->nombre}}, Código de Plantel {{$colegio[0]->codigodea}}, por medio de la presente certifica que el estudiante: "+datos[2]+", con cédula de identidad V-"+datos[1]+", fue inscrito en esta Institución en "+grado+",durante el año escolar: {{$filtros[0]->codlapso}}.Y hoy se RETIRA por solicitud de su representante {{Auth::user()->nombre}} {{Auth::user()->apellido}}, cedula de identidad v-{{Auth::user()->cedula}}, segun la siguiente causa legal: RETIRO VOLUNTARIO. Constancia que se expide a petición de la parte interesada para fines legales y se firma en {{$colegio[0]->localidad}}, el {{$fecha}}.";
          }
          doc.setFontSize(12);
          lines = doc.splitTextToSize(text, doc.internal.pageSize.width-90);
          doc.text(50, (verticalOffset + size / 72), lines);


          verticalOffset += (lines.length + 1)*12 + 100;

          doc.line(400, verticalOffset, (doc.internal.pageSize.width - 400), verticalOffset); // horizontal line
          text = "Directora";
          var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
          var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
          verticalOffset+=20;
          doc.text(textOffset, verticalOffset, text);


          doc.save('Constancias.pdf');
        }
    }
  </script>
@endsection
