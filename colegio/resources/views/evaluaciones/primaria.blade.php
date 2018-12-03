@extends('main')

@section('title')
  Cargar Notas Primaria
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Evaluaciones</li>
    <li class="active">Notas Primaria</li>
  </ol>
@endsection

@section('content')
  <div id="alertas">
  </div>
  <div class="box">
    <div class="box-body">
      <iframe id="output" style="display: none"></iframe>
      <form id="form" method="GET" action="{{route('notas.store')}}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="form-group" id="cmat">
          <label for="mat">Materia</label>
          <select class="form-control"  name="mat" id="mater">
            <option value="">Seleccione una opcion...</option>
            @for ($i=0; $i <sizeof($materias) ; $i++)
              @if (  $materias[$i]->codsec[0] != '0'  && $materias[$i]->codsec[0] != 'D')
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
      </form>
      <form method="POST" action="{{route('notas.primaria.store')}}" accept-charset="UTF-8" id="tocult">
      {{ csrf_field() }}
      <input type="text" name="ids" id="ids" style="display: none">
      <div class="table-responsive" id="tbreponsive" style="display:none">
        <table class="table table-striped table-bordered">
          <thead id="thead">
          </thead>
          <tbody id="tbody">
          </tbody>
        </table>
      </div>
      <div class="row" id="varios" style="display: none">
        <div class="col col-xs-12">
          <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-upload"></i> Guardar</button>
        </div>
      </div>
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

  var estado = 1;
  var cantP = 0;
  var final = 0;


  function llenar() {

    if (document.getElementById('mater').value != "" && document.getElementById('lap').value != "") {
      c  = document.getElementById('varios');
      c.style="display: block;";
      c  = document.getElementById('tbreponsive');
      c.style="display: block;";
      var id =""+document.getElementById('mater').value+"-"+ document.getElementById('lap').value;
      var lapso = document.getElementById('lap').value;
      $.get("notas/tabla/"+id,function (reponse,state) {
        if (reponse.planificacion.length > 0 && reponse.notas.length > 0) {
        var thd = document.getElementById('thead');
        thd.innerHTML = "";

        var tr = document.createElement("tr");

        var td = document.createElement("td");
        td.innerHTML = "Cedula";
        tr.appendChild(td);

        var td = document.createElement("td");
        td.innerHTML = "Nombres";
        tr.appendChild(td);

        cantP = reponse.planificacion.length;
        var id =""+document.getElementById('mater').value+"-"+ document.getElementById('lap').value+"-"+cantP+"-"+estado;
        document.getElementById("ids").value = id;
        console.log(reponse);
        var lapso   = document.getElementById('lap').value;
        doc = new jsPDF('l', 'mm', [297, 210]);
        var combo = document.getElementById("mater");
        var separar = combo.options[combo.selectedIndex].text;
        var res = separar.split("-");
        var seccion = res[0];
        var materia = res[1];
        var escolar = reponse.notas[0].periescolar;
        console.log(lapso+" "+seccion+" "+materia+" "+escolar);
        var tb = document.getElementById('tbody');
        tb.innerHTML = "";
        if (cantP>0) {


        var td = document.createElement("td");
        td.innerHTML = "Editar";
        tr.appendChild(td);

        thd.appendChild(tr);
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

          td = document.createElement("td");
          var a = document.createElement("td");
          a.setAttribute("class","btn btn-warning");
          a.setAttribute("role","button");
          a.setAttribute("data-toggle","collapse");
          a.setAttribute("href","#trColl"+i);
          a.setAttribute("aria-expanded","false");
          a.setAttribute("aria-controls","collapseExample");
          var icon = document.createElement("i");
          icon.setAttribute("class","fa fa-pencil");
          icon.setAttribute("ria-hidden","true");
          a.appendChild(icon);
          td.appendChild(a);
          tr.appendChild(td);



          var tr2 = document.createElement("tr");
          tr2.setAttribute("class","odd gradeX collapse");
          tr2.setAttribute("id","trColl"+i);

          td = document.createElement("td");
          td.setAttribute("COLSPAN","5");

          for (var j = 0; j < reponse.planificacion.length; j++) {
            div = document.createElement("div");
            div.setAttribute("class","form-group");

            label = document.createElement("label");
            label.innerHTML=""+reponse.planificacion[j].pla_ins;

            textarea = document.createElement("textarea");
            textarea.setAttribute("class","form-control");
            textarea.setAttribute("name","textareas[]");
            if (lapso == 1) {
                switch (j+1) {
                  case 1: textarea.value =reponse.notas[i].Des1_1;break;
                  case 2: textarea.value =reponse.notas[i].Des1_2;break;
                  case 3: textarea.value =reponse.notas[i].Des1_3;break;
                  case 4: textarea.value =reponse.notas[i].Des1_4;break;
                  case 5: textarea.value =reponse.notas[i].Des1_5;break;

                }
            }
            if (lapso == 2) {
              switch (j+1) {
                case 1: textarea.value =reponse.notas[i].Des2_1;break;
                case 2: textarea.value =reponse.notas[i].Des2_2;break;
                case 3: textarea.value =reponse.notas[i].Des2_3;break;
                case 4: textarea.value =reponse.notas[i].Des2_4;break;
                case 5: textarea.value =reponse.notas[i].Des2_5;break;

              }
            }
            if (lapso == 3) {
              switch (j+1) {
                case 1: textarea.value =reponse.notas[i].Des3_1;break;
                case 2: textarea.value =reponse.notas[i].Des3_2;break;
                case 3: textarea.value =reponse.notas[i].Des3_3;break;
                case 4: textarea.value =reponse.notas[i].Des3_4;break;
                case 5: textarea.value =reponse.notas[i].Des3_5;break;

              }
            }

            div.appendChild(label);
            div.appendChild(textarea);
            td.appendChild(div);
            tr2.appendChild(td);
          }

          var tr3 = document.createElement("tr");
          tr3.setAttribute("class","odd gradeX");

          tb.appendChild(tr);
          tb.appendChild(tr2);
          tb.appendChild(tr3);


        }
      }else {
        c  = document.getElementById('varios');
        c.style="display: none;";
        c  = document.getElementById('tbreponsive');
        c.style="display: nome;";
      }
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
        p.innerText = "No se ha cargado ninguna planificacion en este lapso";

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
        p.innerText = "Este Grado no tiene ningun estudiante inscrito";

        div.appendChild(button);
        div.appendChild(h4);
        div.appendChild(p);
        alert.appendChild(div);
      }
    }
      });
    }
  }

  $("#lap").change(function functionName(event) {
      llenar();
  });
  $("#mater").change(function functionName(event) {
      llenar();
  });

  </script>
@endsection
