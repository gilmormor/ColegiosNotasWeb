@extends('main')

@section('title')
  Secciones
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Academicos</li>
    <li class="active">Secciones</li>
  </ol>
@endsection

@section('content')
  <div class="box">
    <div class="box-body">
      <div class="table-responsive">
        <div class="row">
          <div class="col col-sm-8">
            <a class="btn btn-success" role="button" data-toggle="collapse" href="#form-0" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus-square"></i> Crear Sección por materia</a>
          </div>
          <div class="col col-sm-4">
            <form method="GET" action="{{route('secciones.index')}}" accept-charset="UTF-8">
              {{ csrf_field() }}
              <div class="input-group">
                <input class="form-control" placeholder="Buscar Seccion" name="name" type="text" id="name">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-default btn-flat"><i class="fa fa-search" aria-hidden="true"></i></button>
                </span>
              </div>
            </form>
          </div>
        </div>
        <div class="collapse" id="form-0">
          <hr>
          <form method="POST" action="{{route('secciones.store')}}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">Seccion</label>
              <select class="form-control" required name="año" id="año0">
                <option value="" disabled selected >Seleccione una materia</option>
                <option value="M33" >Educación Inicial</option>
                <option value="P11" >Primer Grado</option>
                <option value="P22" >Segundo Grado</option>
                <option value="P33" >Tercero Grado</option>
                <option value="P44" >Cuarto Grado</option>
                <option value="P55" >Quinto Grado</option>
                <option value="P66" >Sexto Grado</option>
                <option value="017" >Primer Año</option>
                <option value="028" >Segundo Año</option>
                <option value="039" >Tercer Año</option>
                <option value="D41" >Cuarto Año</option>
                <option value="D52" >Quinto Año</option>
              </select>
            </div>
            <div class="form-group">
              <label for="seccion">Letra de la Seccion</label>
              <input class="form-control" placeholder="Letra de la Seccion" required="" name="seccion" type="text" id="seccion">
            </div>
            <div class="form-group">
              <label for="lapso">Lapso</label>
              <input class="form-control" placeholder="Lapso de la seccion" required="" name="lapso" type="text" id="lapso">
            </div>
            <div class="form-group">
              <label for="cap">Capacidad</label>
              <input class="form-control" placeholder="capacidad de la seccion" required="" name="cap" type="number" id="cap">
            </div>
            <div class="form-group">
              <button class="btn btn-success" type="submit"><i class="fa fa-upload"></i> Crear</button>
            </div>
        </form>
        </div>
        <hr>
        <table class="table table-striped table-bordered table-hover">
          <thead>
              <tr>
                  <th>Seccion</th>
                  <th>Materia</th>
                  <th>Profesor</th>
                  <th>Lapso</th>
                  <th>Capacidad</th>
                  <th>Accion</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($secciones as $seccion)
              <tr class="odd gradeX">
                <td>{{$seccion->codsec}}</td>
                <td>{{$seccion->des}}</td>
                <td>{{$seccion->nombre}} {{$seccion->apellido}}</td>
                <td>{{$seccion->lapso}}</td>
                <td>{{$seccion->capacidad}}</td>
                <td >
                  <a class="btn btn-warning" role="button" data-toggle="collapse" href="#form-{{$seccion->id}}" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <a href="{{ route('secciones.destroy', $seccion->id) }}" onclick="return confirm('¿Seguro que deseas eliminar?')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
              </tr>
              <tr class="odd gradeX collapse"  id="form-{{$seccion->id}}">
                <td COLSPAN=6>
                  <form method="POST" action="{{route('secciones.update',$seccion->id)}}" accept-charset="UTF-8">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="profesor">Profesor</label>
                      <select class="form-control" name="profesor" id="profesor{{$seccion->id}}">
                        <option value="{{$seccion->cedula}}">{{$seccion->nombre}} {{$seccion->apellido}}</option>
                        @foreach ($profesor as $p)
                          @if ($p->cedula != $seccion->cedula)
                            <option value="{{$p->cedula}}">{{$p->nombre}} {{$p->apellido}}</option>
                          @endif

                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="lapso">Lapso</label>
                      <input class="form-control" placeholder="Lapso de la seccion" required="" name="lapso" type="text" id="lapso{{$seccion->id}}" value="{{$seccion->lapso}}">
                    </div>
                    <div class="form-group">
                      <label for="cap">Capacidad</label>
                      <input class="form-control" placeholder="capacidad de la seccion" required="" name="cap" type="number" id="cap{{$seccion->id}}" value="{{$seccion->capacidad}}">
                    </div>
                    <div class="form-group">
                      <button class="btn btn-warning" type="submit"><i class="fa fa-pencil"></i> Editar</button>
                    </div>
                  </form>
                </td>
              </tr>
              <tr class="odd gradeX collapse">
              </tr>
            @endforeach
          </tbody>
        </table>
        {!! $secciones->render() !!}
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script type="text/javascript">

    $('#form-0').on('shown.bs.collapse', function () {
      var  id = $(this).attr("id");
      vec = id.split("-");
      if (vec[0] == "form") {
        $('#materia'+vec[1]).select2();
        $('#año'+vec[1]).select2();
      }

    })
    function chosen2(id) {
      console.log(id);

    }
  </script>
@endsection
