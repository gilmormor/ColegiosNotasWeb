@extends('main')

@section('title')
  Editar Permisos
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Menus</li>
    <li class="active">Editar Permisos</li>
  </ol>
@endsection

@section('content')
  <div class="box">
    <div class="box-body">
      <div class="table-responsive">
          <form method="POST" action="{{route('permisos.store')}}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <div id="pT" class="form-group">
              <input onchange="permiso()"  name="activar" class="form-control" id="activar" type="checkbox" checked data-toggle="toggle" data-on="Usuario" data-off="Rol" data-offstyle="success" data-style="quick">
            </div>
            <div style="display: none;" class="form-group" id="cambiar">
              <a  id="btnC" class="btn btn-primary" href="{{route('permisos.index')}}">Cambiar</a>
            </div>
            <div class="form-group" id="us">
              <label for="user">Usuario</label>
              <select class="form-control"  name="user" id="user">
                <option value="">Seleccione una opcion...</option>
                @foreach ($usuarios as $menu)
                  <option value="{{$menu->id}}">{{$menu->email}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group" id="rol" style="display: none;">
              <label for="rol">Rol</label>
              <select class="form-control"  name="rol" id="rol_s">
                <option value="">Seleccione una opcion...</option>
                @foreach ($tipos as $menu)
                  <option value="{{$menu->id}}">{{$menu->name}}</option>
                @endforeach
              </select>
            </div>
            <div id="m" class="form-group" style="display: none;">
              <label for="menus">Menus</label>
              <select class="form-control select2" required="" id="menus" name="menus[]" multiple>
                @foreach ($padres as $menu)
                  <option  value="{{$menu->id}}">{{$menu->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-success" type="submit"><i class="fa fa-plus-square"> Agregar Permisos</i></button>
            </div>
        </form>
        <hr>
      </div>
    </div>
  </div>
@endsection
@section('js')
<script type="text/javascript">
    var estado = 1;

    $("#user").change(function functionName(event) {
      c  = document.getElementById('cambiar');
      c.style="display: block;";

      c  = document.getElementById('pT');
      c.style="display: none;";

      c  = document.getElementById('us');
      c.style="display: none;";

      var combo = document.getElementById("user");
      var selected = combo.options[combo.selectedIndex].text;
      $("#btnC").html('Cambiar '+selected);

      $.get("permisos/menus/"+event.target.value+"/1",function (reponse,state) {
        m  = document.getElementById('m');
        m.style="display: block;";
        for (var i = 0; i < reponse.length; i++) {
          for (var j = 0; j < $("#menus option").length; j++) {
            if ($("#menus option")[j].value == reponse[i].id) {
              $("#menus option")[j].setAttribute("selected","");
            }
          }
        }
        $('.select2').select2()
      });
    });

    $("#rol_s").change(function functionName(event) {
      c  = document.getElementById('cambiar');
      c.style="display: block;";

      c  = document.getElementById('pT');
      c.style="display: none;";

      c  = document.getElementById('rol');
      c.style="display: none;";

      var combo = document.getElementById("rol_s");
      var selected = combo.options[combo.selectedIndex].text;
      $("#btnC").html('Cambiar '+selected);

      $.get("permisos/menus/"+event.target.value+"/2",function (reponse,state) {
        m  = document.getElementById('m');
        m.style="display: block;";
        for (var i = 0; i < reponse.length; i++) {
          console.log(i);
          for (var j = 0; j < $("#menus option").length; j++) {
            if ($("#menus option")[j].value == reponse[i].id) {
              $("#menus option")[j].setAttribute("selected","");
            }
          }
        }
        $('.select2').select2()
      });
    });
    function permiso() {

      chk = document.getElementsByName('activar');
      us  = document.getElementById('us');
      rol = document.getElementById('rol');

      if(estado == 1){
        estado = 0;
        us.style="display: none;";
        rol.style="display: block;";
      }
      else {
        estado = 1;
        rol.style="display: none;";
        us.style="display: block;";
      }
    }


</script>
@endsection
