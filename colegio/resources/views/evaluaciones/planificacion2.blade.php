@extends('main')

@section('title')
  Planificacion Primaria
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Evaluaciones</li>
    <li class="active">Planificacion Primaria</li>
  </ol>
@endsection

@section('content')
  <div class="box">
    <div class="box-body">
      <form method="GET" action="{{route('planificacion_primaria.store')}}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="form-group" id="cmat">
          <label for="mat">Materia</label>
          <select class="form-control"  name="mat" id="mater">
            <option value="">Seleccione una opcion...</option>
            @for ($i=0; $i <sizeof($materias) ; $i++)
              @if ( $materias[$i]->codsec[0] != '0'  && $materias[$i]->codsec[0] != 'D' && $materias[$i]->tipo !=1)
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
      <form method="POST" action="{{route('planificacion_primaria.store')}}" accept-charset="UTF-8">
      {{ csrf_field() }}
      <input type="text" name="ids" id="ids" style="display: none">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>Instrumento</th>
            </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
      </table>
      <div class="row" id="varios" style="display: none">
        <div class="col col-sm-12">
          <button onclick="agregar()" class="btn btn-primary" type="button" id="btnFalta"><i class="fa fa-plus"></i> Agregar</button>
          <button onclick="ultimo()" class="btn btn-danger" type="button" id="btnFalta"><i class="fa fa-trash-o"></i> Borrar</button>
            <button class="btn btn-success" disabled="disabled" type="submit" id="btnGuardar"><i class="fa fa-upload"></i>  Guardar</button>
        </div>
        <div class="col col-sm-2">
          <div class="form-group">

          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
@endsection
@section('js')
  <script type="text/javascript">


    function eliminar(element){
      vector = element.id.split("-");
      id = vector[1];
      var tb = document.getElementById('tbody');
      var tr = document.getElementById('tr'+id);
      var j = 0;

      for (var i = 0; i < $("#tbody tr").length; i++) {
        if (i==id) {
          tr.id = "borrar";
        }
        else {
          var trs = document.getElementById('tr'+i);
          trs.id = "tr"+j;
          var td = document.getElementById("eliminar-"+i)
          td.id = "eliminar-"+j;
          j++;
        }
      }
      tr = document.getElementById('borrar');
      tb.removeChild(tr);
      i = $("#tbody tr").length;
      if (i == 0) {
        console.log("entroo");
        btn2 = document.getElementById('btnGuardar');
        btn2.setAttribute("disabled","disabled");
      }
    }
    function ultimo(){
      btn = document.getElementById('btnFalta');
      btn.removeAttribute('disabled');
      id = $("#tbody tr").length;
      id = id -1;
      console.log(id);
      if (id>0) {
        var tb = document.getElementById('tbody');
        var tr = document.getElementById('tr'+id);
        var j = 0;

        for (var i = 0; i < $("#tbody tr").length; i++) {
          if (i==id) {
            tr.id = "borrar";
          }

        }
        tr = document.getElementById('borrar');
        tb.removeChild(tr);
      }
    }

    function agregar() {

      i = $("#tbody tr").length;
      console.log(i);
      if (i<5) {
        var tb = document.getElementById('tbody');

        var tr = document.createElement("tr");
        tr.setAttribute("class","odd gradeX");
        tr.setAttribute("id","tr"+i);

        var td = document.createElement("td");
        var input = document.createElement("input");
        input.setAttribute("class","form-control");
        input.setAttribute("type","text");
        input.setAttribute("name","ins[]");
        input.setAttribute("maxlength","50");
        input.setAttribute("required","required");
        td.appendChild(input);
        tr.appendChild(td);

        /*td = document.createElement("td");
        input = document.createElement("a");
        input.setAttribute("id","eliminar-"+i);
        var icon = document.createElement("i");
        icon.setAttribute("class","fa fa-trash-o");
        icon.setAttribute("aria-hidden","true");
        input.appendChild(icon);
        input.setAttribute("class","btn btn-danger");
        input.setAttribute("onclick","eliminar(this)");
        td.appendChild(input);
        tr.appendChild(td);
*/
        tb.appendChild(tr);
        btn = document.getElementById('btnGuardar');
        btn.removeAttribute('disabled');
        if (i==4) {
          btn2 = document.getElementById('btnFalta');
          btn2.setAttribute("disabled","disabled");
        }
      }
      else {
        btn2 = document.getElementById('btnFalta');
        btn2.setAttribute("disabled","disabled");
      }

    }

    $("#lap").change(function functionName(event) {
      if (document.getElementById('mater').value != "") {
        c  = document.getElementById('varios');
        c.style="display: block;";
        var id =""+document.getElementById('mater').value+"-"+ event.target.value;
        document.getElementById("ids").value = id;
        $.get("planificacion/tabla/"+id,function (reponse,state) {
          var tb = document.getElementById('tbody');
          tb.innerHTML = "";
          var faltante = 100;
          var total = 0;
          for (var i = 0; i < reponse.length; i++) {
            var tr = document.createElement("tr");
            tr.setAttribute("class","odd gradeX");
            tr.setAttribute("id","tr"+i);

            var td = document.createElement("td");
            var input = document.createElement("input");
            input.value = reponse[i].pla_ins;
            input.setAttribute("class","form-control");
            input.setAttribute("type","text");
            input.setAttribute("name","ins[]");
            input.setAttribute("maxlength","50");
            input.setAttribute("required","required");
            td.appendChild(input);
            tr.appendChild(td);
/*
            td = document.createElement("td");
            input = document.createElement("a");
            input.setAttribute("id","eliminar-"+i);
            var icon = document.createElement("i");
            icon.setAttribute("class","fa fa-trash-o");
            icon.setAttribute("aria-hidden","true");
            input.appendChild(icon);
            input.setAttribute("class","btn btn-danger");
            input.setAttribute("onclick","eliminar(this)");
            td.appendChild(input);
            tr.appendChild(td);
*/
            tb.appendChild(tr);
          }


          btn = document.getElementById('btnGuardar');
          btn2 = document.getElementById('btnFalta');

        });
      }
    });

    $("#mater").change(function functionName(event) {
      if (document.getElementById('lap').value != "") {
        c  = document.getElementById('varios');
        c.style="display: block;";
        var id =""+event.target.value+"-"+ document.getElementById('lap').value;
        $.get("planificacion/tabla/"+id,function (reponse,state) {
          var tb = document.getElementById('tbody');
          tb.innerHTML = "";
          var faltante = 100;
          var total = 0;
          for (var i = 0; i < reponse.length; i++) {
            var tr = document.createElement("tr");
            tr.setAttribute("class","odd gradeX");
            tr.setAttribute("id","tr"+i);

            var td = document.createElement("td");
            var input = document.createElement("input");
            input.value = reponse[i].pla_ins;
            input.setAttribute("class","form-control");
            input.setAttribute("type","text");
            input.setAttribute("name","ins[]");
            input.setAttribute("maxlength","50");
            td.appendChild(input);
            tr.appendChild(td);
/*
            td = document.createElement("td");
            input = document.createElement("a");
            input.setAttribute("id","eliminar-"+i);
            var icon = document.createElement("i");
            icon.setAttribute("class","fa fa-trash-o");
            icon.setAttribute("aria-hidden","true");
            input.appendChild(icon);
            input.setAttribute("class","btn btn-danger");
            input.setAttribute("onclick","eliminar(this)");
            td.appendChild(input);
            tr.appendChild(td);
*/
            tb.appendChild(tr);
          }

          btn = document.getElementById('btnGuardar');
          btn2 = document.getElementById('btnFalta');

        });
      }
    });
  </script>
@endsection
