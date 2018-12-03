@extends('main')

@section('title')
  Menus
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Menus</li>
    <li class="active">Configurar Menu</li>
  </ol>
@endsection

@section('content')
  <div class="box">
    <div class="box-body">
      <div class="table-responsive">
        <a class="btn btn-success" role="button" data-toggle="collapse" href="#form0" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus-square"></i>  Agregar Menu</a>
        <div class="collapse" id="form0">
          <hr>
          <form method="POST" action="{{route('menus.store')}}" accept-charset="UTF-8">
              {{ csrf_field() }}
              <div class="form-group {{ $errors->has('Nombre') ? 'has-error' : '' }}">
                <label for="Nombre">Nombre</label>
                <input class="form-control" placeholder="Nombres" required="" name="Nombre" type="text" id="name">
              </div>
              <div class="form-group {{ $errors->has('Icono') ? 'has-error' : '' }}">
                <label for="Icono">Icono</label>
                <div class="input-group">
                  <input class="form-control" placeholder="fa fa-circle-o" required="" name="Icono" type="text" id="icon">
                      <span class="input-group-btn">
                        <a target="_blank" href="{{route('menus.iconos')}}" class="btn btn-info btn-flat"><i class="fa fa-search"></i></a>
                      </span>
                </div>
              </div>
              <div class="form-group {{ $errors->has('Ruta') ? 'has-error' : '' }}">
                <label for="Ruta">Ruta</label>
                <input class="form-control" placeholder="Ruta" required="" name="Ruta" type="text" id="ruta">
              </div>
              <div class="form-group {{ $errors->has('Orden') ? 'has-error' : '' }}">
                <label for="Orden">Orden</label>
                <input class="form-control" value="0" required="" name="Orden" min="0" type="number" id="orden">
              </div>
              <div class="form-group {{ $errors->has('Padre') ? 'has-error' : '' }}">
                <label for="Padre">Menu Padre</label>
                <select class="form-control select2"  name="Padre" id="padre">
                  <option value="0">Seleccione una opcion...</option>
                  @foreach ($padres as $menu)
                    <option value="{{$menu->id}}">{{$menu->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <input  name="activar" class="form-control" id="activar" type="checkbox" checked data-toggle="toggle" data-on="Visible" data-off="No visible" data-offstyle="danger" data-width="100">
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit"><i class="fa fa-upload"></i> Crear</button>
              </div>
          </form>
        </div>
        <hr>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
              <tr>
                  <th>Nombre</th>
                  <th>Ruta</th>
                  <th>Orden</th>
                  <th>Padre</th>
                  <th>Sub Menus</th>
                  <th>Visibilidad</th>
                  <th>Acciones</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($padres as $menu)
              <tr class="odd gradeX">
                <td><i class="{{$menu->icon}}"></i> {{$menu->name}}</td>
                <td>{{$menu->slug}}</td>
                <td>{{$menu->order}}</td>
                @if ($menu->parent == 0)
                  <td>No posee</td>
                @else
                  <td>{{$menu->padre($padres, $menu)}}</td>
                @endif

                <td>{{$menu->countChildren($padres, $menu)}}</td>
                @if ($menu->enabled == 1)
                  <td><span class="label label-primary">Visible</span></td>
                @else
                  <td><span class="label label-danger"> No Visible</span></td>
                @endif
                <td class="center">
                  <a class="btn btn-warning" role="button" data-toggle="collapse" href="#form{{$menu->id}}" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <a href="{{ route('menus.destroy', $menu->id) }}" onclick="return confirm('¿Seguro que deseas eliminar?')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
              </tr>
              <tr class="odd gradeX collapse"  id="form{{$menu->id}}">
                <td COLSPAN=7>
                  <form method="POST" action="{{route('menus.update',$menu->id)}}" accept-charset="UTF-8">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="Nombre">Nombre</label>
                      <input class="form-control" value="{{$menu->name}}" required="" name="Nombre" type="text" id="name">
                    </div>
                    <div class="form-group">
                      <label for="Icono">Icono</label>
                      <div class="input-group">
                        <input class="form-control" placeholder="fa fa-circle-o" required="" name="Icono" value="{{$menu->icon}}" type="text" id="icon">
                            <span class="input-group-btn">
                              <a target="_blank" href="{{route('menus.iconos')}}" class="btn btn-info btn-flat"><i class="fa fa-search"></i></a>
                            </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="Ruta">Ruta</label>
                      <input class="form-control" value="{{$menu->slug}}" required="" name="Ruta" type="text" id="ruta">
                    </div>
                    <div class="form-group">
                      <label for="Orden">Orden</label>
                      <input class="form-control" value="{{$menu->order}}" required="" name="Orden" min="0" type="number" id="orden">
                    </div>
                    <div class="form-group">
                      <label for="Padre">Menu Padre</label>
                      <select class="form-control select2"  name="Padre" id="padre">
                        @if ($menu->parent == 0)
                          <option value="0">No posee</option>
                        @else
                          <option value="{{$menu->parent}}">{{$menu->padre($padres, $menu)}}</option>
                        @endif
                        @foreach ($padres as $m)
                          <option value="0">No posee</option>
                          @if ($menu->parent == 0)
                            <option value="{{$m->id}}">{{$m->name}}</option>
                          @else
                            @if ($menu->parent != $m->id)
                                <option value="{{$m->id}}">{{$m->name}}</option>
                            @endif
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <input  name="activar" class="form-control" id="activar" type="checkbox" checked data-toggle="toggle" data-on="Visible" data-off="No visible" data-offstyle="danger" data-width="100">
                    </div>
                    <div class="form-group">
                      <button class="btn btn-warning" type="submit"><i class="fa fa-pencil"></i> Editar</button>
                    </div>
                  </form>
                </td>
              </tr>
              <tr class="odd gradeX"></tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
@section('js')

@endsection
