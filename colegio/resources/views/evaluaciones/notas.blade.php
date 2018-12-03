@extends('main')

@section('title')
  Cargar Notas Secundaria por {{Request::segment(2)}}
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Evaluaciones</li>
    <li class="active">Notas Secundaria</li>
  </ol>
@endsection

@section('content')
  <div id="alertas">
  </div>
  <div class="box">
    <div class="box-body">
      <iframe id="output" style="display: none"></iframe>
      <form id="form" method="GET" action="{{ Request::segment(2) === 'cedula' ? route('notas.store') : route('notas.nombre.store')  }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="form-group" id="cmat">
          <label for="mat">Materia</label>
          <select class="form-control"  name="mat" id="mater">
            <option value="">Seleccione una opcion...</option>
            @for ($i=0; $i <sizeof($materias) ; $i++)
              @if ( $materias[$i]->codsec[0] != 'P'  && $materias[$i]->codsec[0] != 'M' && $materias[$i]->tipo !=1)
                <option value="{{$materias[$i]->codsec}}-{{$materias[$i]->cod}}">{{$materias[$i]->codsec}} - {{$materias[$i]->des}}</option>
              @endif
            @endfor
          </select>
        </div>
        <div class="form-group" id="clap">
          <label for="lapso">Lapso</label>
          <select class="form-control"  name="lapso" id="lap">
            <option value="">Seleccione una opcion...</option>
            <option value="1">Primer Lapso</option>
            <option value="2">Segundo Lapso</option>
            <option value="3">Tercer Lapso</option>
          </select>
        </div>
        <div id="pT" class="form-group">
          <input onchange="permiso()" name="activar" class="form-control" id="activar" type="checkbox" checked data-toggle="toggle" data-on="Con Final" data-off="Sin Final" data-offstyle="success" data-style="quick">
        </div>
      </form>
      <form method="POST" action="{{ Request::segment(2) === 'cedula' ? route('notas.store') : route('notas.nombre.store')  }}" accept-charset="UTF-8" id="tocult">
      {{ csrf_field() }}
      <input type="text" name="ids" id="ids" style="display: none">
      <div class="table-responsive" id="tbreponsive" style="display:none">
        <table class="table table-striped table-bordered " id="tableMy">
          <thead id="thead">
          </thead>
          <tbody id="tbody">
          </tbody>
        </table>
      </div>
      <div class="row" id="varios" style="display: none">
        <div class="col col-xs-12">
          <p class="text-red noDimensiones">-1 = Inasistente (I) <br /> -2 = No Presento(NP)</p>
        </div>
        <div class="col col-xs-12"> 
          <button class="btn btn-success " type="submit" id="btnGuardar"><i class="fa fa-upload"></i> Guardar</button>
          <button class="btn btn-danger noDimensiones" type="button" onclick="pdf();" id="btnPDF" data-toggle="tooltip" title="Reporte de evaluacion por lapso"><i class="fa fa-print"></i> Reporte</button>
          <button class="btn btn-danger noDimensiones" type="button" onclick="pdf2();" id="btnPDF" title="Reporte Actuación general del Estudiante"><i class="fa fa-print"></i> Rep Act</button>
          <button class="btn btn-danger noDimensiones" type="button" onclick="pdf3();" id="btnPDF" title="Reporte final de año"><i class="fa fa-print"></i> Rep Def</button>
        <!--  <button class="btn btn-warning " type="button" onclick="return confirm('¿Seguro que deseas finaliar? Luego no podra hacer modificaciones')" id="btnPDF" title="Finalizar lapso"><i class="fa fa-warning"></i> Finalizar Lapso</button>-->
        </div>

      </form>
    </div>
  </div>
@endsection
@section('js')
  <script src="{{ asset('adminlte/plugins/jspdf/jspdf.debug.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jspdf/faker.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jspdf/jspdf.plugin.autotable.js') }}"></script>
  <script type="text/javascript">

  var final;
  var cantP = 0;
  var columns = [];
  var rows = [];
  var columnsObj = [];
  var rowsObj = [];
  var columnsDef = [];
  var rowsDef = [];
  var doc = new jsPDF('l', 'mm', [297, 210]);
  var docObj = new jsPDF('l', 'mm', [297, 210]);
  var docDef = new jsPDF('l', 'mm', [297, 210]);

  var trampa = 1;
  var plan = Array();
  var Aprobados;
  var Reprobados;

  function cargarBasePdf(lapso,seccion,materia,escolar) {
      doc.setFontSize(8);
      doc.setFontType("bold");
      var texto = "{{$colegio[0]->nombre}}";
      Aprobados  = 0;
      Reprobados = 0;
      texto = texto.toUpperCase();
      doc.text(20, 10, texto);

      doc.text(20, 14, "Sección: ");

      doc.setFontType("default");
      doc.text(34, 14, seccion);

      doc.setFontType("bold");
      doc.text(40, 14, "Profesor: ");

      doc.setFontType("default");
      var texto = "{{Auth::user()->nombre}} {{Auth::user()->apellido}}";
      texto = texto.toUpperCase();
      doc.text(54, 14, "{{Auth::user()->cedula}}"+"   "+texto);

      doc.setFontType("bold");
      doc.text(20, 18, "Asignatura: ");

      doc.setFontType("default");
      var texto = materia;
      texto = texto.toUpperCase();
      doc.text(36, 18,texto);

      texto1 = "Fecha y hora: ";
      var f = new Date();
      var texto2 = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear()+" "+f.getHours()+":"+f.getMinutes()+":"+f.getSeconds();

      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.setFontType("bold");
      doc.text(textOffset, 10, texto1);
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth);
      doc.setFontType("default");
      doc.text(textOffset, 10, texto2);

      texto1 = "Año Escolar: ";
      var texto2 = escolar+"  ";

      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.setFontType("bold");
      doc.text(textOffset, 14, texto1);
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth);
      doc.setFontType("default");
      doc.text(textOffset, 14, texto2);

      texto1 = "Lapso: ";
      var texto2 = lapso+"  ";

      var text = texto1+texto2;
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) -20;
      doc.setFontType("bold");
      doc.text(textOffset, 18, texto1);
      var textOffset = (doc.internal.pageSize.width - 20);
      doc.setFontType("default");
      doc.text(textOffset, 18, texto2);

      text = "PLANILLA DE CONTROL DE LA ACTUACIÓN GENERAL DEL ESTUDIANTE";
      var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
      var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
      doc.text(textOffset, 26, text);

      doc.line(20, 28, (doc.internal.pageSize.width - 20), 28); // horizontal line

      doc.setFontSize(8);
      doc.setFontType("bold");
      if (final == 1) {
        doc.text(45, 32, "Fecha:");
        doc.text(45, 36, "Objetivo:");
        doc.text(45, 40, "Instrumento:");
        doc.text(45, 44, "Ponderacion:");
      }else {
        doc.text(45, 32, "Fecha:");
        doc.text(45, 36, "Objetivo:");
        doc.text(45, 40, "Instrumento:");
        doc.text(45, 44, "Ponderacion:");
      }


      columns.length=0;
      columns.push({title: "N", dataKey: "id"});
      columns.push({title: "Cedula", dataKey: "cedula"});
      columns.push({title: "Nombre", dataKey: "name"});
      columns.push({title: "N1", dataKey: "n1"});
      columns.push({title: "112", dataKey: "n1_112"});
      columns.push({title: "N2", dataKey: "n2"});
      columns.push({title: "112", dataKey: "n2_112"});
      columns.push({title: "N3", dataKey: "n3"});
      columns.push({title: "112", dataKey: "n3_112"});
      columns.push({title: "N4", dataKey: "n4"});
      columns.push({title: "112", dataKey: "n4_112"});
      columns.push({title: "N5", dataKey: "n5"});
      columns.push({title: "112", dataKey: "n5_112"});
      columns.push({title: "NPond", dataKey: "npond"});
      columns.push({title: "Rasg", dataKey: "rasg"});
      columns.push({title: "AJ", dataKey: "aj"});
      columns.push({title: "NAJ", dataKey: "naj"});
      if (final == 1) {
        columns.push({title: "70%", dataKey: "n70"});
        columns.push({title: "FL", dataKey: "fl"});
        columns.push({title: "112", dataKey: "fl_112"});
        columns.push({title: "30%", dataKey: "n30"});
        columns.push({title: "70%+30%", dataKey: "sum"});
      }
      columns.push({title: "Def", dataKey: "def"});
      columns.push({title: "Ins", dataKey: "ins"});

      doc.setProperties({
          title: 'Notas de: ' + "{{Auth::user()->nombre}} {{Auth::user()->apellido}} "+seccion+" "+materia+" Lapso "+lapso,
          subject: 'Nomina de notas de los estudiantes'
      });
  }

  function cargarBasePdf2(lapso,seccion,materia,escolar) {
      docObj.setFontSize(8);
      docObj.setFontType("bold");
      var texto = "{{$colegio[0]->nombre}}";
      texto = texto.toUpperCase();
      docObj.text(20, 10, texto);

      docObj.text(20, 14, "Sección: ");

      docObj.setFontType("default");
      docObj.text(34, 14, seccion);

      docObj.setFontType("bold");
      docObj.text(40, 14, "Profesor: ");

      docObj.setFontType("default");
      var texto = "{{Auth::user()->nombre}} {{Auth::user()->apellido}}";
      texto = texto.toUpperCase();
      docObj.text(54, 14, "{{Auth::user()->cedula}}"+"   "+texto);

      docObj.setFontType("bold");
      docObj.text(20, 18, "Asignatura: ");

      docObj.setFontType("default");
      var texto = materia;
      texto = texto.toUpperCase();
      docObj.text(36, 18,texto);

      texto1 = "Fecha y hora: ";
      var f = new Date();
      var texto2 = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear()+" "+f.getHours()+":"+f.getMinutes()+":"+f.getSeconds();

      var text = texto1+texto2;
      var textWidth = docObj.getStringUnitWidth(text) * docObj.internal.getFontSize() / docObj.internal.scaleFactor;
      var textOffset = (docObj.internal.pageSize.width - textWidth) -20;
      docObj.setFontType("bold");
      docObj.text(textOffset, 10, texto1);
      var textWidth = docObj.getStringUnitWidth(text) * docObj.internal.getFontSize() / docObj.internal.scaleFactor;
      var textOffset = (docObj.internal.pageSize.width - textWidth);
      docObj.setFontType("default");
      docObj.text(textOffset, 10, texto2);

      texto1 = "Año Escolar: ";
      var texto2 = escolar+"  ";

      var text = texto1+texto2;
      var textWidth = docObj.getStringUnitWidth(text) * docObj.internal.getFontSize() / docObj.internal.scaleFactor;
      var textOffset = (docObj.internal.pageSize.width - textWidth) -20;
      docObj.setFontType("bold");
      docObj.text(textOffset, 14, texto1);
      var textWidth = docObj.getStringUnitWidth(text) * docObj.internal.getFontSize() / docObj.internal.scaleFactor;
      var textOffset = (docObj.internal.pageSize.width - textWidth);
      docObj.setFontType("default");
      docObj.text(textOffset, 14, texto2);

      texto1 = "Lapso: ";
      var texto2 = lapso+"  ";

      var text = texto1+texto2;
      var textWidth = docObj.getStringUnitWidth(text) * docObj.internal.getFontSize() / docObj.internal.scaleFactor;
      var textOffset = (docObj.internal.pageSize.width - textWidth) -20;
      docObj.setFontType("bold");
      docObj.text(textOffset, 18, texto1);
      var textOffset = (docObj.internal.pageSize.width - 20);
      docObj.setFontType("default");
      docObj.text(textOffset, 18, texto2);

      text = "PLANILLA DE CONTROL DE LA ACTUACIÓN GENERAL DEL ESTUDIANTE";
      var textWidth = docObj.getStringUnitWidth(text) * docObj.internal.getFontSize() / docObj.internal.scaleFactor;
      var textOffset = (docObj.internal.pageSize.width - textWidth) / 2;
      docObj.text(textOffset, 26, text);

      docObj.line(20, 28, (docObj.internal.pageSize.width - 20), 28); // horizontal line

      docObj.setFontSize(8);
      docObj.setFontType("bold");
      if (final == 1) {
        docObj.text(45, 32, "Fecha:");
        docObj.text(45, 36, "Objetivo:");
        docObj.text(45, 40, "Instrumento:");
        docObj.text(45, 44, "Ponderacion:");
      }else {
        docObj.text(45, 32, "Fecha:");
        docObj.text(45, 36, "Objetivo:");
        docObj.text(45, 40, "Instrumento:");
        docObj.text(45, 44, "Ponderacion:");
      }


      columnsObj.length=0;
      columnsObj.push({title: "N", dataKey: "id"});
      columnsObj.push({title: "Cedula", dataKey: "cedula"});
      columnsObj.push({title: "Nombre", dataKey: "name"});
      columnsObj.push({title: "Aspectos Predominantes de la Actuacion de los Estudiantes", dataKey: "act"});

      docObj.setProperties({
          title: 'Reporte de: ' + "{{Auth::user()->nombre}} {{Auth::user()->apellido}} "+seccion+" "+materia+" Lapso "+lapso,
          subject: 'Nomina de Aspectos predominantes de la actuacion de los estudiantes'
      });
  }

  function cargarBasePdf3(lapso,seccion,materia,escolar) {
      docDef.setFontSize(8);
      docDef.setFontType("bold");
      var texto = "{{$colegio[0]->nombre}}";
      texto = texto.toUpperCase();
      docDef.text(20, 10, texto);

      docDef.text(20, 14, "Sección: ");

      docDef.setFontType("default");
      docDef.text(34, 14, seccion);

      docDef.setFontType("bold");
      docDef.text(40, 14, "Profesor: ");

      docDef.setFontType("default");
      var texto = "{{Auth::user()->nombre}} {{Auth::user()->apellido}}";
      texto = texto.toUpperCase();
      docDef.text(54, 14, "{{Auth::user()->cedula}}"+"   "+texto);

      docDef.setFontType("bold");
      docDef.text(20, 18, "Asignatura: ");

      docDef.setFontType("default");
      var texto = materia;
      texto = texto.toUpperCase();
      docDef.text(36, 18,texto);

      texto1 = "Fecha y hora: ";
      var f = new Date();
      var texto2 = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear()+" "+f.getHours()+":"+f.getMinutes()+":"+f.getSeconds();

      var text = texto1+texto2;
      var textWidth = docDef.getStringUnitWidth(text) * docDef.internal.getFontSize() / docDef.internal.scaleFactor;
      var textOffset = (docDef.internal.pageSize.width - textWidth) -20;
      docDef.setFontType("bold");
      docDef.text(textOffset, 10, texto1);
      var textWidth = docDef.getStringUnitWidth(text) * docDef.internal.getFontSize() / docDef.internal.scaleFactor;
      var textOffset = (docDef.internal.pageSize.width - textWidth);
      docDef.setFontType("default");
      docDef.text(textOffset, 10, texto2);

      texto1 = "Año Escolar: ";
      var texto2 = escolar+"  ";

      var text = texto1+texto2;
      var textWidth = docDef.getStringUnitWidth(text) * docDef.internal.getFontSize() / docDef.internal.scaleFactor;
      var textOffset = (docDef.internal.pageSize.width - textWidth) -20;
      docDef.setFontType("bold");
      docDef.text(textOffset, 14, texto1);
      var textWidth = docDef.getStringUnitWidth(text) * docDef.internal.getFontSize() / docDef.internal.scaleFactor;
      var textOffset = (docDef.internal.pageSize.width - textWidth);
      docDef.setFontType("default");
      docDef.text(textOffset, 14, texto2);

      texto1 = "Lapso: ";
      var texto2 = lapso+"  ";

      var text = texto1+texto2;
      var textWidth = docDef.getStringUnitWidth(text) * docDef.internal.getFontSize() / docDef.internal.scaleFactor;
      var textOffset = (docDef.internal.pageSize.width - textWidth) -20;
      docDef.setFontType("bold");
      docDef.text(textOffset, 18, texto1);
      var textOffset = (docDef.internal.pageSize.width - 20);
      docDef.setFontType("default");
      docDef.text(textOffset, 18, texto2);

      text = "RERPORTE FINAL DE AÑO";
      var textWidth = docDef.getStringUnitWidth(text) * docDef.internal.getFontSize() / docDef.internal.scaleFactor;
      var textOffset = (docDef.internal.pageSize.width - textWidth) / 2;
      docDef.text(textOffset, 26, text);

      docDef.line(20, 28, (docDef.internal.pageSize.width - 20), 28); // horizontal line

      docDef.setFontSize(8);
      docDef.setFontType("bold");



      columnsDef.length=0;
      columnsDef.push({title: "N", dataKey: "id"});
      columnsDef.push({title: "Cedula", dataKey: "cedula"});
      columnsDef.push({title: "Nombre", dataKey: "name"});
      columnsDef.push({title: "Lapso I", dataKey: "def1"});
      columnsDef.push({title: "Ins", dataKey: "ins1"});
      columnsDef.push({title: "Lapso II", dataKey: "def2"});
      columnsDef.push({title: "Ins", dataKey: "ins2"});
      columnsDef.push({title: "Lapso III", dataKey: "def3"});
      columnsDef.push({title: "Ins", dataKey: "ins3"});
      columnsDef.push({title: "Def", dataKey: "def"});

      docDef.setProperties({
          title: 'Notas de: ' + "{{Auth::user()->nombre}} {{Auth::user()->apellido}} "+seccion+" "+materia+" Lapso "+lapso,
          subject: 'Nomina de notas de los estudiantes'
      });
  }

  $("#lap").change(function functionName(event) {
      llenar(1);
  });
  $("#mater").change(function functionName(event) {
      llenar(1);
  });

  function permiso() {
    if (trampa == 0) {
      if (final == 1) {
        final = 0;
      }
      else {
        final =1;
      }
    }
    llenar(0);
  }

  function calcular(id) {
    lapso = document.getElementById('lap').value;
    notas = Array();
    for (var i = 0; i < cantP; i++) {
        n112 = document.getElementById("n"+lapso+"_"+(i+1)+"_112_"+id).value;
        if (n112 > 0) {
          notas.push(parseFloat(n112*(plan[i]/100)));
        }else {
          n = document.getElementById("n"+lapso+"_"+(i+1)+"_"+id).value;
          if (n > 0) {
            notas.push(parseFloat(n*(plan[i]/100)));
          }
          else {
            notas.push(0);
          }
        }
    }
    sum = notas.reduce((previous, current) => current += previous);
    avg = sum;
    avg = avg.toFixed(2);
    document.getElementById('npond'+id).value = avg;
    aj = parseInt(document.getElementById('aj'+id).value);
    nj = parseFloat(avg) + parseFloat(aj);
    if (nj > 20) {
      nj=20;
    }


    document.getElementById('naj'+id).value = nj;
    if (final == 1) {
      n70 = parseFloat(nj) * parseFloat('0.70');
      n70 = n70.toFixed(2);
      nota = 0;
      document.getElementById("n"+lapso+"_70_"+id).value = n70;
      document.getElementById("r"+lapso+"_70_"+id).value = n70;
      n112 = document.getElementById("n"+lapso+"_fl112_"+id).value;
      if (n112 > 0) {
        nota = parseInt(n112);
      }else {
        n = document.getElementById("n"+lapso+"_fl_"+id).value;
        if (n > 0) {
          nota = parseInt(n);
        }
      }
      n30 = parseFloat(nota) * parseFloat('0.30');
      n30 = n30.toFixed(2);
      document.getElementById("n"+lapso+"_30_"+id).value = n30;
      document.getElementById("r"+lapso+"_30_"+id).value = n30;

      def = parseFloat(n70) + parseFloat(n30);
      document.getElementById("n"+lapso+"_deflap_"+id).value = Math.round(def);
      document.getElementById("r"+lapso+"_deflap_"+id).value = Math.round(def);
    }
    else {
      document.getElementById("n"+lapso+"_70_"+id).value = Math.round(nj);
      document.getElementById("r"+lapso+"_70_"+id).value = Math.round(nj);
    }
  }

  function contarL(cadena,id) {
    contA = 0;
    contB = 0;
    contC = 0;
    aj = 0;
    for (var i = 0; i < cadena.length; i++) {
      if (cadena[i] == 'A') {
        contA++;
      }
      if (cadena[i] == 'B') {
        contB++;
      }
      if (cadena[i] == 'C') {
        contC++;
      }
    }
    if (contA >= 2) {
      aj = 2;
    }
    if (contB >= 2) {
      aj = 1;
    }
    document.getElementById('aj'+id).value = parseInt(aj);
    calcular(id);
  }

  function calRasgo(element,id) {
    cadena = element.value;
    contarL(cadena,id);

  }

  function llenar(bandera) {

    if (document.getElementById('mater').value != "" && document.getElementById('lap').value != "") {
      var id =""+document.getElementById('mater').value+"-"+ document.getElementById('lap').value;
      var lapso = document.getElementById('lap').value;
      $.get("notas/tabla/"+id,function (reponse,state) {
        console.log(reponse);
        var aux_cualit=reponse.notas[0].cualitativa;
        if (reponse.planificacion.length > 0 && reponse.notas.length > 0) {

        c  = document.getElementById('varios');
        c.style="display: block;";
        c  = document.getElementById('tbreponsive');
        c.style="display: block;";
        var thd = document.getElementById('thead');
        thd.innerHTML = "";
        alertas = document.getElementById('alertas');
        alertas.innerHTML = "";

        var tr = document.createElement("tr");

        var td = document.createElement("td");
        td.innerHTML = "Cedula";
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "Nombres";
        td.setAttribute("width","20%");
        tr.appendChild(td);

        cantP = reponse.planificacion.length;
        var id =""+document.getElementById('mater').value+"-"+ document.getElementById('lap').value+"-"+cantP+"-"+final;
        document.getElementById("ids").value = id;

        var lapso   = document.getElementById('lap').value;
        doc = new jsPDF('l', 'mm', [297, 210]);
        docObj = new jsPDF('l', 'mm', [297, 210]);
        docDef = new jsPDF('l', 'mm', [297, 210]);
        var combo = document.getElementById("mater");
        var separar = combo.options[combo.selectedIndex].text;
        var res = separar.split("-");
        var seccion = res[0];
        var materia = res[1];
        var escolar = reponse.notas[0].periescolar;
        if (bandera == 1) {
          trampa = 1;
          if (lapso == 1) {
            final = parseInt(reponse.notas[0].nota1_fl);
          }
          if (lapso == 2) {
            final = parseInt(reponse.notas[0].nota2_fl);
          }
          if (lapso == 3) {
            final = parseInt(reponse.notas[0].nota3_fl);
          }

          if(final == 0){
            $('#activar').bootstrapToggle('off');
          }
          else {
            final = 1;
            $('#activar').bootstrapToggle('on');
          }
        }else {
          trampa = 0;
        }

        cargarBasePdf(lapso,seccion,materia,escolar);
        cargarBasePdf2(lapso,seccion,materia,escolar);
        cargarBasePdf3(lapso,seccion,materia,escolar);

        if (cantP > 0) {
          c  = document.getElementById('tocult');
          c.style="display: block;";
        }
        else {
          c  = document.getElementById('tocult');
          c.style="display: none;";
        }
        rows.length=0;
        rowsObj.length = 0;
        rowsDef.length = 0;
        plan.length=0;
        Aprobados = 0;
        Reprobados = 0;
        for (var i = 0; i < cantP; i++) {
            plan.push(parseInt(reponse.planificacion[i].pla_por));
        }
        for (var i = 0; i < cantP; i++) {
          var td = document.createElement("td");
          td.innerHTML = "N "+(i+1);
          td.setAttribute("width","7%");
          tr.appendChild(td);

          var td = document.createElement("td");
          td.innerHTML = "112";
          td.setAttribute("class","noDimensiones");
          tr.appendChild(td);
        }

        var td = document.createElement("td");
        td.innerHTML = "NPond";
        td.setAttribute("class","noDimensiones");
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "Rasgo";
        td.setAttribute("class","noDimensiones");
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "AJ";
        td.setAttribute("class","noDimensiones");
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "NAJ";
        td.setAttribute("class","noDimensiones");
        tr.appendChild(td);

        if (final == 1) {
          var td = document.createElement("td");
          td.innerHTML = "70%";
          td.setAttribute("class","noDimensiones");
          tr.appendChild(td);

          var td = document.createElement("td");
          td.innerHTML = "FL";
          td.setAttribute("class","noDimensiones");
          tr.appendChild(td);

          var td = document.createElement("td");
          td.innerHTML = "112";
          td.setAttribute("class","noDimensiones");
          tr.appendChild(td);

          var td = document.createElement("td");
          td.innerHTML = "30%";
          td.setAttribute("class","noDimensiones");
          tr.appendChild(td);
        }


        var td = document.createElement("td");
        td.innerHTML = "Def";
        td.setAttribute("class","noDimensiones");
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "Inas";
        td.setAttribute("width","3%");
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "DesAct";
        td.setAttribute("class","noDimensiones");
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "En cuanto al conocimiento e información";
        td.setAttribute("class","dimensiones");
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "En cuanto a su trabajo; trabajo en equipo e individual";
        td.setAttribute("class","dimensiones");
        tr.appendChild(td);


        thd.appendChild(tr);


        var tb = document.getElementById('tbody');
        tb.innerHTML = "";
        for (var i = 0; i < reponse.notas.length; i++) {

          var tr = document.createElement("tr");
          tr.setAttribute("class","odd gradeX");
          tr.setAttribute("id","tr"+i);

          var td = document.createElement("td");
          td.innerHTML = reponse.notas[i].ced_alum;
          tr.appendChild(td);

          var td = document.createElement("td");
          td.innerHTML = reponse.notas[i].est_apellidos+" "+reponse.notas[i].est_nombres;
          tr.appendChild(td);

          if (cantP >= 1) {

              td = document.createElement("td");
              if(aux_cualit == 0){
                input = document.createElement("input");
              }else{
                input = document.createElement("select");
                var miOption=document.createElement("option");
                // Añadimos las propiedades value y label
                miOption.setAttribute("value",0);
                miOption.setAttribute("label","");
                miOption.innerHTML = "";
                // Añadimos el option al select
                input.appendChild(miOption);

                var miOption1=document.createElement("option");
                // Añadimos las propiedades value y label
                miOption1.setAttribute("value",20);
                miOption1.setAttribute("label","A");
                miOption1.innerHTML = "A";
                // Añadimos el option al select
                input.appendChild(miOption1);

                var miOption2=document.createElement("option");
                miOption2.setAttribute("value",17);
                miOption2.setAttribute("label","B");
                miOption2.innerHTML = "B";
                // Añadimos el option al select
                input.appendChild(miOption2);

                var miOption3=document.createElement("option");
                miOption3.setAttribute("value",14);
                miOption3.setAttribute("label","C");
                miOption3.innerHTML = "C";
                // Añadimos el option al select
                input.appendChild(miOption3);

                var miOption3=document.createElement("option");
                miOption3.setAttribute("value",11);
                miOption3.setAttribute("label","D");
                miOption3.innerHTML = "D";
                // Añadimos el option al select
                input.appendChild(miOption3);


              }
              
              if (lapso == 1 ) {
                input.value = reponse.notas[i].nota1_1;
              }
              if (lapso == 2 ) {
                input.value = reponse.notas[i].nota2_1;
              }
              if (lapso == 3 ) {
                input.value = reponse.notas[i].nota3_1;
              }
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("name","n"+lapso+"_1[]");
              input.setAttribute("onchange","calcular("+i+");");
              input.setAttribute("id","n"+lapso+"_1_"+i);
              input.setAttribute("min","-2");
              input.setAttribute("max","20");
              td.appendChild(input);
              tr.appendChild(td);

              td = document.createElement("td");
              td.setAttribute("class","noDimensiones");
              input = document.createElement("input");
              if (lapso == 1 ) {
                input.value = reponse.notas[i].nota1_1_112;
              }
              if (lapso == 2 ) {
                input.value = reponse.notas[i].nota2_1_112;
              }
              if (lapso == 3 ) {
                input.value = reponse.notas[i].nota3_1_112;
              }
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("name","n"+lapso+"_1_112[]");
              input.setAttribute("onchange","calcular("+i+");");
              input.setAttribute("id","n"+lapso+"_1_112_"+i);
              input.setAttribute("min","-2");
              input.setAttribute("max","20");
              td.appendChild(input);
              tr.appendChild(td);
          }
          if (cantP >= 2) {
              td = document.createElement("td");
              input = document.createElement("input");
              if (lapso == 1 ) {
                input.value = reponse.notas[i].nota1_2;
              }
              if (lapso == 2 ) {
                input.value = reponse.notas[i].nota2_2;
              }
              if (lapso == 3 ) {
                input.value = reponse.notas[i].nota3_2;
              }
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("name","n"+lapso+"_2[]");
              input.setAttribute("onchange","calcular("+i+");");
              input.setAttribute("id","n"+lapso+"_2_"+i);
              input.setAttribute("min","-2");
              input.setAttribute("max","20");
              td.appendChild(input);
              tr.appendChild(td);

              td = document.createElement("td");
              td.setAttribute("class","noDimensiones");
              input = document.createElement("input");
              if (lapso == 1 ) {
                input.value = reponse.notas[i].nota1_2_112;
              }
              if (lapso == 2 ) {
                input.value = reponse.notas[i].nota2_2_112;
              }
              if (lapso == 3 ) {
                input.value = reponse.notas[i].nota3_2_112;
              }
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("name","n"+lapso+"_2_112[]");
              input.setAttribute("onchange","calcular("+i+");");
              input.setAttribute("id","n"+lapso+"_2_112_"+i);
              input.setAttribute("min","-2");
              input.setAttribute("max","20");
              td.appendChild(input);
              tr.appendChild(td);
          }
          if (cantP >= 3) {
              td = document.createElement("td");
              input = document.createElement("input");
              if (lapso == 1 ) {
                input.value = reponse.notas[i].nota1_3;
              }
              if (lapso == 2 ) {
                input.value = reponse.notas[i].nota2_3;
              }
              if (lapso == 3 ) {
                input.value = reponse.notas[i].nota3_3;
              }
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("name","n"+lapso+"_3[]");
              input.setAttribute("onchange","calcular("+i+");");
              input.setAttribute("id","n"+lapso+"_3_"+i);
              input.setAttribute("min","-2");
              input.setAttribute("max","20");
              td.appendChild(input);
              tr.appendChild(td);

              td = document.createElement("td");
              td.setAttribute("class","noDimensiones");
              input = document.createElement("input");
              if (lapso == 1 ) {
                input.value = reponse.notas[i].nota1_3_112;
              }
              if (lapso == 2 ) {
                input.value = reponse.notas[i].nota2_3_112;
              }
              if (lapso == 3 ) {
                input.value = reponse.notas[i].nota3_3_112;
              }
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("name","n"+lapso+"_3_112[]");
              input.setAttribute("onchange","calcular("+i+");");
              input.setAttribute("id","n"+lapso+"_3_112_"+i);
              input.setAttribute("min","-2");
              input.setAttribute("max","20");
              td.appendChild(input);
              tr.appendChild(td);
          }
          if (cantP >= 4) {
            td = document.createElement("td");
            input = document.createElement("input");
            if (lapso == 1 ) {
              input.value = reponse.notas[i].nota1_4;
            }
            if (lapso == 2 ) {
              input.value = reponse.notas[i].nota2_4;
            }
            if (lapso == 3 ) {
              input.value = reponse.notas[i].nota3_4;
            }
            input.setAttribute("class","form-control");
            input.setAttribute("type","number");
            input.setAttribute("name","n"+lapso+"_4[]");
            input.setAttribute("onchange","calcular("+i+");");
            input.setAttribute("id","n"+lapso+"_4_"+i);
            input.setAttribute("min","-2");
            input.setAttribute("max","20");
            td.appendChild(input);
            tr.appendChild(td);

            td = document.createElement("td");
            td.setAttribute("class","noDimensiones");
            input = document.createElement("input");
            if (lapso == 1 ) {
              input.value = reponse.notas[i].nota1_4_112;
            }
            if (lapso == 2 ) {
              input.value = reponse.notas[i].nota2_4_112;
            }
            if (lapso == 3 ) {
              input.value = reponse.notas[i].nota3_4_112;
            }
            input.setAttribute("class","form-control");
            input.setAttribute("type","number");
            input.setAttribute("name","n"+lapso+"_4_112[]");
            input.setAttribute("onchange","calcular("+i+");");
            input.setAttribute("id","n"+lapso+"_4_112_"+i);
            input.setAttribute("min","-2");
            input.setAttribute("max","20");
            td.appendChild(input);
            tr.appendChild(td);
          }
          if (cantP >= 5) {
            td = document.createElement("td");
            input = document.createElement("input");
            if (lapso == 1 ) {
              input.value = reponse.notas[i].nota1_5;
            }
            if (lapso == 2 ) {
              input.value = reponse.notas[i].nota2_5;
            }
            if (lapso == 3 ) {
              input.value = reponse.notas[i].nota3_5;
            }
            input.setAttribute("class","form-control");
            input.setAttribute("type","number");
            input.setAttribute("name","n"+lapso+"_5[]");
            input.setAttribute("onchange","calcular("+i+");");
            input.setAttribute("id","n"+lapso+"_5_"+i);
            input.setAttribute("min","-2");
            input.setAttribute("max","20");
            td.appendChild(input);
            tr.appendChild(td);

            td = document.createElement("td");
            td.setAttribute("class","noDimensiones");
            input = document.createElement("input");
            if (lapso == 1 ) {
              input.value = reponse.notas[i].nota1_5_112;
            }
            if (lapso == 2 ) {
              input.value = reponse.notas[i].nota2_5_112;
            }
            if (lapso == 3 ) {
              input.value = reponse.notas[i].nota3_5_112;
            }
            input.setAttribute("class","form-control");
            input.setAttribute("type","number");
            input.setAttribute("name","n"+lapso+"_5_112[]");
            input.setAttribute("onchange","calcular("+i+");");
            input.setAttribute("id","n"+lapso+"_5_112_"+i);
            input.setAttribute("min","-2");
            input.setAttribute("max","20");
            td.appendChild(input);
            tr.appendChild(td);
          }

          td = document.createElement("td");
          td.setAttribute("class","noDimensiones");
          input = document.createElement("input");
          input.value = 0;
          input.setAttribute("class","form-control");
          input.setAttribute("type","number");
          input.setAttribute("id","npond"+i);
          input.setAttribute("disabled","disabled");
          td.appendChild(input);
          tr.appendChild(td);

          td = document.createElement("td");
          td.setAttribute("class","noDimensiones");
          input = document.createElement("input");
          if (lapso == 1) {
            cadena = reponse.notas[i].letra1;
          }
          if (lapso == 2) {
            cadena = reponse.notas[i].letra2;
          }
          if (lapso == 3) {
            cadena = reponse.notas[i].letra3;
          }
          if (cadena == 0 || cadena == null) {
            cadena ="";
            input.value = cadena;
          }else {
            input.value = cadena;
          }
          input.setAttribute("class","form-control rasgo");
          input.setAttribute("type","text");
          input.setAttribute("name","letra"+lapso+"[]");
          input.setAttribute("maxlength","3");
          input.setAttribute("id","letra"+lapso+i);
          input.setAttribute("onchange","calRasgo(this,"+i+");");
          input.setAttribute("style","text-transform:uppercase;");
          input.setAttribute("onkeyup","javascript:this.value=this.value.toUpperCase();");
          td.appendChild(input);
          tr.appendChild(td);

          td = document.createElement("td");
          td.setAttribute("class","noDimensiones");
          input = document.createElement("input");
          input.value = 0;
          input.setAttribute("class","form-control");
          input.setAttribute("type","number");
          input.setAttribute("id","aj"+i);
          input.setAttribute("disabled","disabled");
          td.appendChild(input);
          tr.appendChild(td);

          td = document.createElement("td");
          td.setAttribute("class","noDimensiones");
          input = document.createElement("input");
          input.value = 0;
          input.setAttribute("class","form-control");
          input.setAttribute("type","number");
          input.setAttribute("id","naj"+i);
          input.setAttribute("disabled","disabled");
          td.appendChild(input);
          tr.appendChild(td);

          td = document.createElement("td");
          td.setAttribute("class","noDimensiones");
          input = document.createElement("input");
          input2 = document.createElement("input");

          if (lapso == 1) {
            input.value = reponse.notas[i].nota1_70;
            input2.value = reponse.notas[i].nota1_70;
          }
          if (lapso == 2) {
            input.value = reponse.notas[i].nota2_70;
            input2.value = reponse.notas[i].nota2_70;
          }
          if (lapso == 3) {
            input.value = reponse.notas[i].nota3_70;
            input2.value = reponse.notas[i].nota3_70;
          }
          input.setAttribute("class","form-control");
          input.setAttribute("type","number");
          input.setAttribute("disabled","disabled");
          input.setAttribute("id","n"+lapso+"_70_"+i);


          input2.setAttribute("class","form-control");
          input2.setAttribute("type","hidden");
          input2.setAttribute("name","n"+lapso+"_70[]");
          input2.setAttribute("id","r"+lapso+"_70_"+i);
          td.appendChild(input);
          td.appendChild(input2);
          tr.appendChild(td);

          if (final == 1) {
              td = document.createElement("td");
              td.setAttribute("class","noDimensiones");
              input = document.createElement("input");
              if (lapso == 1 )
                input.value = reponse.notas[i].nota1_fl;
              if (lapso == 2 )
                input.value = reponse.notas[i].nota2_fl;
              if (lapso == 3 )
                input.value = reponse.notas[i].nota3_fl;
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("name","n"+lapso+"_fl[]");
              input.setAttribute("onchange","calcular("+i+");");
              input.setAttribute("id","n"+lapso+"_fl_"+i);
              input.setAttribute("min","-2");
              input.setAttribute("max","20");
              td.appendChild(input);
              tr.appendChild(td);

              td = document.createElement("td");
              td.setAttribute("class","noDimensiones");
              input = document.createElement("input");
              if (lapso == 1 )
                input.value = reponse.notas[i].nota1_fl112;
              if (lapso == 2 )
                input.value = reponse.notas[i].nota2_fl112;
              if (lapso == 3 )
                input.value = reponse.notas[i].nota3_fl112;
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("name","n"+lapso+"_fl112[]");
              input.setAttribute("onchange","calcular("+i+");");
              input.setAttribute("id","n"+lapso+"_fl112_"+i);
              input.setAttribute("min","-2");
              input.setAttribute("max","20");
              td.appendChild(input);
              tr.appendChild(td);

              td = document.createElement("td");
              td.setAttribute("class","noDimensiones");
              input = document.createElement("input");
              input2 = document.createElement("input");
              if (lapso == 1 ){
                input.value  = reponse.notas[i].nota1_30;
                input2.value = reponse.notas[i].nota1_30;
              }
              if (lapso == 2 ){
                input.value  = reponse.notas[i].nota2_30;
                input2.value = reponse.notas[i].nota2_30;
              }
              if (lapso == 3 ){
                input.value  = reponse.notas[i].nota3_30;
                input2.value = reponse.notas[i].nota3_30;
              }
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("disabled","disabled");
              input.setAttribute("id","n"+lapso+"_30_"+i);

              input2.setAttribute("class","form-control");
              input2.setAttribute("type","hidden");
              input2.setAttribute("name","n"+lapso+"_30[]");
              input2.setAttribute("id","r"+lapso+"_30_"+i);
              td.appendChild(input);
              td.appendChild(input2);
              tr.appendChild(td);

              td = document.createElement("td");
              td.setAttribute("class","noDimensiones");
              input = document.createElement("input");
              input2 = document.createElement("input");
              if (lapso == 1 ){
                input.value  = reponse.notas[i].nota1_deflap;
                input.value2 = reponse.notas[i].nota1_deflap;
              }
              if (lapso == 2 ){
                input.value  = reponse.notas[i].nota2_deflap;
                input2.value = reponse.notas[i].nota2_deflap;
              }
              if (lapso == 3 ){
                input.value  = reponse.notas[i].nota3_deflap;
                input2.value = reponse.notas[i].nota3_deflap;
              }
              input.setAttribute("class","form-control");
              input.setAttribute("type","number");
              input.setAttribute("disabled","disabled");
              input2.setAttribute("name","nd"+lapso+"_deflap[]");
              input.setAttribute("id","n"+lapso+"_deflap_"+i);

              input2.setAttribute("class","form-control");
              input2.setAttribute("type","hidden");
              input2.setAttribute("name","n"+lapso+"_deflap[]");
              input2.setAttribute("id","r"+lapso+"_deflap_"+i);
              td.appendChild(input);
              td.appendChild(input2);
              tr.appendChild(td);



          }

          td = document.createElement("td");
          input = document.createElement("input");
          if (lapso == 1 ){
            input.value  = reponse.notas[i].inasis1;
          }
          if (lapso == 2 ){
            input.value  = reponse.notas[i].inasis2;
          }
          if (lapso == 3 ){
            input.value  = reponse.notas[i].inasis3;
          }
          input.setAttribute("class","form-control");
          input.setAttribute("type","number");
          input.setAttribute("name","ins[]");
          input.setAttribute("id","ins"+lapso+i);
          td.appendChild(input);
          tr.appendChild(td);

          td = document.createElement("td");
          td.setAttribute("class","noDimensiones");
          a = document.createElement("a");
          a.setAttribute("class","btn btn-warning");
          a.setAttribute("data-toggle","collapse");
          a.setAttribute("role","button");
          a.setAttribute("href","#form"+reponse.notas[i].ced_alum);
          a.setAttribute("aria-expanded","false");
          a.setAttribute("aria-controls","collapseExample");
          icono = document.createElement("i");
          icono.setAttribute("class","fa fa-pencil");
          icono.setAttribute("aria-hidden","true");

          a.appendChild(icono);
          td.appendChild(a);
          tr.appendChild(td);

          tb.appendChild(tr);


//Dimensiones

          td = document.createElement("td");
          td.setAttribute("class","dimensiones");
          input = document.createElement("input");
          var des;
          if (lapso == 1) {
            des = reponse.notas[i].dim1_1;
          }
          if (lapso == 2) {
            des = reponse.notas[i].dim2_1;
          }
          if (lapso == 3) {
            des = reponse.notas[i].dim3_1;
          }
          input.value =  des;
          input.setAttribute("class","form-control");
          input.setAttribute("type","text");
          input.setAttribute("name","Dim1Obj[]");
          input.setAttribute("id","Dim1Obj"+lapso+i);
          td.appendChild(input);
          tr.appendChild(td);


          td = document.createElement("td");
          td.setAttribute("class","dimensiones");
          input = document.createElement("input");
          var des;
          if (lapso == 1) {
            des = reponse.notas[i].dim1_2;
          }
          if (lapso == 2) {
            des = reponse.notas[i].dim2_2;
          }
          if (lapso == 3) {4
            des = reponse.notas[i].dim3_2;
          }
          input.value =  des;
          input.setAttribute("class","form-control");
          input.setAttribute("type","text");
          input.setAttribute("name","Dim2Obj[]");
          input.setAttribute("id","Dim2Obj"+lapso+i);
          td.appendChild(input);
          tr.appendChild(td);

//Fin Dimensiones


          tr = document.createElement("tr");
          td = document.createElement("td");
          td.setAttribute("class","noDimensiones");
          tr.setAttribute("class","odd gradeX collapse");
          tr.setAttribute("id","form"+reponse.notas[i].ced_alum);
          input = document.createElement("input");
          var des;
          if (lapso == 1) {
            des = reponse.notas[i].Des1;
          }
          if (lapso == 2) {
            des = reponse.notas[i].Des2;
          }
          if (lapso == 3) {
            des = reponse.notas[i].Des3;
          }
          input.value =  des;
          input.setAttribute("class","form-control");
          input.setAttribute("type","text");
          input.setAttribute("name","DesObj[]");
          input.setAttribute("id","DesObj"+lapso+i);
          input.value
          td.appendChild(input);
          var nColumnas = $("#tableMy tr:last td").length;
          td.setAttribute("COLSPAN",nColumnas);

          tr.appendChild(td);

          tb.appendChild(tr);

          contarL(cadena,i);

          if(aux_cualit == 1){
            ocultarNoDimensiones();          
          }else{
            ocultarDimensiones();
          }

          var name    = reponse.notas[i].est_apellidos+" "+reponse.notas[i].est_nombres;
          var cedula    = reponse.notas[i].ced_alum;
          if (lapso == 1){
            var n1      = reponse.notas[i].nota1_1;
            var n1_112  = reponse.notas[i].nota1_1_112;
            var n2      = reponse.notas[i].nota1_2;
            var n2_112  = reponse.notas[i].nota1_2_112;
            var n3      = reponse.notas[i].nota1_3;
            var n3_112  = reponse.notas[i].nota1_3_112;
            var n4      = reponse.notas[i].nota1_4;
            var n4_112  = reponse.notas[i].nota1_4_112;
            var n5      = reponse.notas[i].nota1_5;
            var n5_112  = reponse.notas[i].nota1_5_112;
            var rasg    = reponse.notas[i].letra1;
            var ins     = reponse.notas[i].inasis1;
            var ins1     = reponse.notas[i].inasis1;
            if (final == 1) {
              var n70     = reponse.notas[i].nota1_70;
              var fl      = reponse.notas[i].nota1_fl;
              var fl_112  = reponse.notas[i].nota1_fl112;
              var n30     = reponse.notas[i].nota1_30;
              var sum     = parseFloat(n70)+parseFloat(n30);
            }
            var def     = reponse.notas[i].nota1_deflap;
            //def = def.toFixed(2);
            var def1    = def;
            var DesObj  = reponse.notas[i].Des1;
          }
          if (lapso == 2){
            var n1      = reponse.notas[i].nota2_1;
            var n1_112  = reponse.notas[i].nota2_1_112;
            var n2      = reponse.notas[i].nota2_2;
            var n2_112  = reponse.notas[i].nota2_2_112;
            var n3      = reponse.notas[i].nota2_3;
            var n3_112  = reponse.notas[i].nota2_3_112;
            var n4      = reponse.notas[i].nota2_4;
            var n4_112  = reponse.notas[i].nota2_4_112;
            var n5      = reponse.notas[i].nota2_5;
            var n5_112  = reponse.notas[i].nota2_5_112;
            var rasg    = reponse.notas[i].letra2;
            var ins     = reponse.notas[i].inasis2;
            var ins2     = reponse.notas[i].inasis2;
            if (final == 1) {
              var n70     = reponse.notas[i].nota2_70;
              var fl      = reponse.notas[i].nota2_fl;
              var fl_112  = reponse.notas[i].nota2_fl112;
              var n30     = reponse.notas[i].nota2_30;
              var sum     = parseFloat(n70)+parseFloat(n30);
            }
            var def     = reponse.notas[i].nota2_deflap;
            //def = def.toFixed(2);
            var def2    = def;
            var DesObj  = reponse.notas[i].Des2;
          }
          if (lapso == 3){
            var n1      = reponse.notas[i].nota3_1;
            var n1_112  = reponse.notas[i].nota1_1_112;
            var n2      = reponse.notas[i].nota3_2;
            var n2_112  = reponse.notas[i].nota3_2_112;
            var n3      = reponse.notas[i].nota3_3;
            var n3_112  = reponse.notas[i].nota3_3_112;
            var n4      = reponse.notas[i].nota3_4;
            var n4_112  = reponse.notas[i].nota3_4_112;
            var n5      = reponse.notas[i].nota3_5;
            var n5_112  = reponse.notas[i].nota3_5_112;
            var rasg    = reponse.notas[i].letra3;
            var ins     = reponse.notas[i].inasis3;
            var ins3     = reponse.notas[i].inasis3;
            if (final == 1) {
              var n70     = reponse.notas[i].nota3_70;
              n70 = n70.toFixed(2);
              var fl      = reponse.notas[i].nota3_fl;
              var fl_112  = reponse.notas[i].nota3_fl112;
              var n30     = reponse.notas[i].nota3_30;
              n30 = n30.toFixed(2);
              var sum     = parseFloat(n70).toFixed(2)+parseFloat(n30).toFixed(2);
              sum = sum.toFixed(2);
            }
            var def     = reponse.notas[i].nota3_deflap;
            //def = def.toFixed(2);
            var def3     = def;
            var DesObj  = reponse.notas[i].Des3;
          }

          if (parseInt(def) < 10) {
            Reprobados = parseInt(Reprobados) + 1;
          }else {
            Aprobados = parseInt(Aprobados) + 1;
          }

          var npond   = parseInt(document.getElementById('npond'+i).value);
          var aj      = document.getElementById('aj'+i).value;
          var naj     = document.getElementById('naj'+i).value;
          if (DesObj == null) {
            DesObj ="";
          }
          rowsObj.push({
            "id": (i+1),
            "cedula": cedula,
            "name": name,
            "act": DesObj,
          });
          if (def1 > 0 && def2 > 0 && def3 > 0) {
            definitiva = (def1+def2+def3)/3;
            defF = definitiva.toFixed(2);
          }
          else {
            defF = "ND";
          }
          rowsDef.push({
            "id": (i+1),
            "cedula": cedula,
            "name": name,
            "def1": def1,
            "ins1": ins1,
            "def2": def2,
            "ins2": ins2,
            "def3": def3,
            "ins3": ins3,
            "def": defF,
          });
          //condiciones para n1 en los reportes
          if (n1 == -1) {
            n1 ="I";
          }
          else if (n1 == -2) {
            n1 ="NP";
          }
          else if (n1 < 10) {
            n1 ="0"+n1;
          }
          //condiciones para n1 112 en los reportes
          if (n1_112 == -1) {
            n1_112 ="I";
          }
          else if (n1_112 == -2) {
            n1_112 ="NP";
          }
          else if (n1_112 < 10) {
            n1_112 ="0"+n1_112;
          }
          //condiciones para n2 en los reportes
          if (n2 == -1) {
            n2 ="I";
          }
          else if (n2 == -2) {
            n2 ="NP";
          }
          else if (n2 < 10) {
            n2 ="0"+n2;
          }
          //condiciones para n2 112 en los reportes
          if (n2_112 == -1) {
            n2_112 ="I";
          }
          else if (n2_112 == -2) {
            n2_112 ="NP";
          }
          else if (n2_112 < 10) {
            n2_112 ="0"+n2_112;
          }
          //condiciones para n3 en los reportes
          if (n3 == -1) {
            n3 ="I";
          }
          else if (n3 == -2) {
            n3 ="NP";
          }
          else if (n3 < 10) {
            n3 ="0"+n3;
          }
          //condiciones para n3 112 en los reportes
          if (n3_112 == -1) {
            n3_112 ="I";
          }
          else if (n3_112 == -2) {
            n3_112 ="NP";
          }
          else if (n3_112 < 10) {
            n3_112 ="0"+n3_112;
          }
          //condiciones para n4 en los reportes
          if (n4 == -1) {
            n4 ="I";
          }
          else if (n4 == -2) {
            n4 ="NP";
          }
          else if (n4 < 10) {
            n4 ="0"+n4;
          }
          //condiciones para n4 112 en los reportes
          if (n4_112 == -1) {
            n4_112 ="I";
          }
          else if (n4_112 == -2) {
            n4_112 ="NP";
          }
          else if (n4_112 < 10) {
            n4_112 ="0"+n4_112;
          }
          //condiciones para n5 en los reportes
          if (n5 == -1) {
            n5 ="I";
          }
          else if (n5 == -2) {
            n5 ="NP";
          }
          else if (n5 < 10) {
            n5 ="0"+n5;
          }
          //condiciones para n5 112 en los reportes
          if (n5_112 == -1) {
            n5_112 ="I";
          }
          else if (n5_112 == -2) {
            n5_112 ="NP";
          }
          else if (n5_112 < 10) {
            n5_112 ="0"+n5_112;
          }
          //condiciones para npond en los reportes
          if (parseInt(npond) < 10) {
            npond ="0"+parseInt(npond);
          }
          //condiciones para naj en los reportes
          if (parseInt(naj) < 10) {
            naj ="0"+parseInt(naj);
          }
          //condiciones para fl en los reportes
          if (parseInt(fl) < 10) {
            fl ="0"+parseInt(fl);
          }
          //condiciones para fl 112 en los reportes
          if (parseInt(fl_112) < 10) {
            fl_112 ="0"+parseInt(fl_112);
          }
          //condiciones para sum en los reportes
          if (parseInt(sum) < 10) {
            sum ="0"+parseInt(sum);
          }
          //condiciones para def en los reportes
          if (parseInt(def) < 10) {
            def ="0"+parseInt(def);
          }
          //condiciones para n70 en los reportes
          if (parseFloat(n70).toFixed(2) < 10) {
            n70 ="0"+parseFloat(n70).toFixed(2);
          }
          //condiciones para n30 en los reportes
          if (parseFloat(n30).toFixed(2) < 10) {
            n30 ="0"+parseFloat(n30).toFixed(2);
          }
          //condiciones para rasg en los reportes
          if (rasg == null) {
            rasg = "";
          }

          if (final == 1) {
            rows.push({
              "id": (i+1),
              "cedula": cedula,
              "name": name,
              "n1": n1,
              "n1_112": n1_112,
              "n2": n2,
              "n2_112": n2_112,
              "n3": n3,
              "n3_112": n3_112,
              "n4": n4,
              "n4_112": n4_112,
              "n5": n5,
              "n5_112": n5_112,
              "npond": npond,
              "rasg": rasg,
              "aj": parseInt(aj),
              "naj": naj,
              "n70": n70,
              "fl": fl,
              "fl_112": fl_112,
              "n30": n30,
              "sum": sum,
              "def": def,
              "ins": parseInt(ins)
            });
          }
          else {
            rows.push({
              "id": (i+1),
              "cedula": cedula,
              "name": name,
              "n1": n1,
              "n1_112": n1_112,
              "n2": n2,
              "n2_112": n2_112,
              "n3": n3,
              "n3_112": n3_112,
              "n4": n4,
              "n4_112": n4_112,
              "n5": n5,
              "n5_112": n5_112,
              "npond": npond,
              "rasg": rasg,
              "aj": parseInt(aj),
              "naj": naj,
              "def": def,
              "ins": parseInt(ins)
            });
          }
        }
//-----------------Documento 1-------------------------
          if (cantP >= 1) {
            doc.setFontType("default");
            fecha  = reponse.planificacion[0].pla_fecha;
            vect = fecha.split(" ");
            doc.text(93, 32, vect[0]);
            doc.text(93, 36, reponse.planificacion[0].pla_des);
            doc.text(93, 40,reponse.planificacion[0].pla_ins);
            doc.text(93, 44,reponse.planificacion[0].pla_por+"%");
          }
          if (cantP >= 2) {
            doc.setFontType("default");
            fecha  = reponse.planificacion[1].pla_fecha;
            vect = fecha.split(" ");
            doc.text(110, 32, vect[0]);
            doc.text(110, 36, reponse.planificacion[1].pla_des);
            doc.text(110, 40,reponse.planificacion[1].pla_ins);
            doc.text(110, 44,reponse.planificacion[1].pla_por+"%");
          }
          if (cantP >= 3) {
            doc.setFontType("default");
            fecha  = reponse.planificacion[2].pla_fecha;
            vect = fecha.split(" ");
            doc.text(127, 32, vect[0]);
            doc.text(127, 36, reponse.planificacion[2].pla_des);
            doc.text(127, 40,reponse.planificacion[2].pla_ins);
            doc.text(127, 44,reponse.planificacion[2].pla_por+"%");
          }
          if (cantP >= 4) {
            doc.setFontType("default");
            fecha  = reponse.planificacion[3].pla_fecha;
            vect = fecha.split(" ");
            doc.text(144, 32, vect[0]);
            doc.text(144, 36, reponse.planificacion[3].pla_des);
            doc.text(144, 40,reponse.planificacion[3].pla_ins);
            doc.text(144, 44,reponse.planificacion[3].pla_por+"%");
          }
          if (cantP >= 5) {
            doc.setFontType("default");
            fecha  = reponse.planificacion[4].pla_fecha;
            vect = fecha.split(" ");
            doc.text(161, 32, vect[0]);
            doc.text(161, 36, reponse.planificacion[4].pla_des);
            doc.text(161, 40,reponse.planificacion[4].pla_ins);
            doc.text(161, 44,reponse.planificacion[4].pla_por+"%");
          }

//-----------------Documento 2-------------------------
          if (cantP >= 1) {
            docObj.setFontType("default");
            fecha  = reponse.planificacion[0].pla_fecha;
            vect = fecha.split(" ");
            docObj.text(93, 32, vect[0]);
            docObj.text(93, 36, reponse.planificacion[0].pla_des);
            docObj.text(93, 40,reponse.planificacion[0].pla_ins);
            docObj.text(93, 44,reponse.planificacion[0].pla_por+"%");
          }
          if (cantP >= 2) {
            docObj.setFontType("default");
            fecha  = reponse.planificacion[1].pla_fecha;
            vect = fecha.split(" ");
            docObj.text(110, 32, vect[0]);
            docObj.text(110, 36, reponse.planificacion[1].pla_des);
            docObj.text(110, 40,reponse.planificacion[1].pla_ins);
            docObj.text(110, 44,reponse.planificacion[1].pla_por+"%");
          }
          if (cantP >= 3) {
            docObj.setFontType("default");
            fecha  = reponse.planificacion[2].pla_fecha;
            vect = fecha.split(" ");
            docObj.text(127, 32, vect[0]);
            docObj.text(127, 36, reponse.planificacion[2].pla_des);
            docObj.text(127, 40,reponse.planificacion[2].pla_ins);
            docObj.text(127, 44,reponse.planificacion[2].pla_por+"%");
          }
          if (cantP >= 4) {
            docObj.setFontType("default");
            fecha  = reponse.planificacion[3].pla_fecha;
            vect = fecha.split(" ");
            docObj.text(144, 32, vect[0]);
            docObj.text(144, 36, reponse.planificacion[3].pla_des);
            docObj.text(144, 40,reponse.planificacion[3].pla_ins);
            docObj.text(144, 44,reponse.planificacion[3].pla_por+"%");
          }
          if (cantP >= 5) {
            docObj.setFontType("default");
            fecha  = reponse.planificacion[4].pla_fecha;
            vect = fecha.split(" ");
            docObj.text(161, 32, vect[0]);
            docObj.text(161, 36, reponse.planificacion[4].pla_des);
            docObj.text(161, 40,reponse.planificacion[4].pla_ins);
            docObj.text(161, 44,reponse.planificacion[4].pla_por+"%");
          }

        doc.autoTable(columns, rows, {
          theme: 'grid',
          startY: 48,
          margin: {left: 15},
          styles: {
            cellPadding: 0.5, fontSize: 6,
            overflow: 'linebreak',
            columnWidth: 'wrap',
            halign: 'center'
          },
          columnStyles: {
            id: {columnWidth: 10},
            cedula: {halign: 'left',columnWidth: 15},
            name: {halign: 'left',columnWidth:50},
            n1:  {columnWidth: 10},
            n1_112:  {columnWidth: 10},
            n2:  {columnWidth: 10},
            n2_112:  {columnWidth: 10},
            n3:  {columnWidth: 10},
            n3_112:  {columnWidth: 10},
            n4:  {columnWidth: 10},
            n4_112:  {columnWidth: 10},
            n5:  {columnWidth: 10},
            n5_112:  {columnWidth: 10},
            npond:  {columnWidth: 10},
            rasg:  {columnWidth: 10},
            aj:  {columnWidth: 10},
            naj:  {columnWidth: 10},
            def:  {columnWidth: 10},
            ins:  {columnWidth: 10},
          }
        });
        let first = doc.autoTable.previous;
        doc.setFontType("default");
        texto = "Aprobados: "+Aprobados+" Reprobados: "+Reprobados;
        doc.text(20, first.finalY + 10, texto);

        docObj.autoTable(columnsObj, rowsObj, {
          theme: 'grid',
          startY: 48,
          margin: {left: 15},
          styles: {
            cellPadding: 0.5, fontSize: 6,
            overflow: 'linebreak',
            columnWidth: 'wrap',
            halign: 'center'
          },
          columnStyles: {
            id: {columnWidth: 10},
            cedula: {halign: 'left',columnWidth: 15},
            name: {halign: 'left',columnWidth:50},
            act:  {halign: 'left',columnWidth: 200},
          }
        });
        docDef.autoTable(columnsDef, rowsDef, {
          theme: 'grid',
          startY: 32,
          margin: {left: 15},
          styles: {
            cellPadding: 0.5, fontSize: 6,
            overflow: 'linebreak',
            columnWidth: 'wrap',
          },
          columnStyles: {
            id: {columnWidth: 10},
            cedula: {halign: 'left',columnWidth: 40},
            name: {halign: 'left',columnWidth:100},
            def1: {columnWidth:20},
            ins1: {columnWidth:15},
            def2: {columnWidth:20},
            ins2: {columnWidth:15},
            def3: {columnWidth:20},
            ins3: {columnWidth:15},
            def: {columnWidth:20},
          }
        });
      }else {
        c  = document.getElementById('varios');
        c.style="display: none;";
        c  = document.getElementById('tbreponsive');
        c.style="display: none;";
        var thd = document.getElementById('thead');
        thd.innerHTML = "";
        if (reponse.planificacion.length == 0){
          alert  = document.getElementById('alertas');

          div = document.createElement("div");
          div.setAttribute("class","alert alert-danger alert-dismissible");

          button = document.createElement("button");
          button.setAttribute("type","button");
          button.setAttribute("class","close");
          button.setAttribute("data-dismiss","alert");
          button.setAttribute("aria-hidden","true");
          button.innerText="x";

          h4 = document.createElement("h4");
          h4.innerText = " Error";

          p = document.createElement("p");
          p.innerText = "No se ha cargado ninguna planificacion para esta materia en este lapso";

          div.appendChild(button);
          div.appendChild(h4);
          div.appendChild(p);
          alert.appendChild(div);

        }
        if (reponse.notas.length == 0){
          alert  = document.getElementById('alertas');

          div = document.createElement("div");
          div.setAttribute("class","alert alert-danger alert-dismissible");

          button = document.createElement("button");
          button.setAttribute("type","button");
          button.setAttribute("class","close");
          button.setAttribute("data-dismiss","alert");
          button.setAttribute("aria-hidden","true");
          button.innerText="x";

          h4 = document.createElement("h4");
          h4.innerText = " Error";

          p = document.createElement("p");
          p.innerText = "Esta materia no tiene ningun estudiante inscrito";

          div.appendChild(button);
          div.appendChild(h4);
          div.appendChild(p);
          alert.appendChild(div);
        }
      }
      });
    }
  }
  function pdf() {
    var combo = document.getElementById("mater");
    var separar = combo.options[combo.selectedIndex].text;
    var combo2 = document.getElementById("lap");
    var separar2 = combo2.options[combo2.selectedIndex].text;
    doc.save('Nomina de '+separar+' '+separar2+'.pdf');
  }

  function pdf2() {
    var combo = document.getElementById("mater");
    var separar = combo.options[combo.selectedIndex].text;
    var combo2 = document.getElementById("lap");
    var separar2 = combo2.options[combo2.selectedIndex].text;
    docObj.save('Nomina de Actitudes  '+separar+' '+separar2+'.pdf');
  }

  function pdf3() {
    var combo = document.getElementById("mater");
    var separar = combo.options[combo.selectedIndex].text;
    var combo2 = document.getElementById("lap");
    var separar2 = combo2.options[combo2.selectedIndex].text;
    docDef.save('Nomina de Definitiva'+separar+' '+separar2+'.pdf');
  }

  function ocultarDimensiones(){
      var myClasses = document.querySelectorAll('.dimensiones');
          i = 0;
          l = myClasses.length;
      for (i = 0; i < l; i++) {
          myClasses[i].style.display = 'none';
      }
  }

  function ocultarNoDimensiones(){
      var myClasses = document.querySelectorAll('.noDimensiones');
          i = 0;
          l = myClasses.length;
      for (i = 0; i < l; i++) {
          myClasses[i].style.display = 'none';
      }
  }

  </script>
@endsection
