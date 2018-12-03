@extends('main')

@section('title')
  Usuarios
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li class="active">Usuarios</li>
  </ol>
@endsection
@section('content')
  <div class="box">
    <div class="box-body">
      <div class="table-responsive">
        <div class="row">
          <div class="col col-sm-8">
            <a class="btn btn-success" role="button" data-toggle="collapse" href="#form0" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-user-plus"></i> Crear Usuario</a>
          </div>
          <div class="col col-sm-4">
            <form method="GET" action="{{route('users.index')}}" accept-charset="UTF-8">
              {{ csrf_field() }}
              <div class="input-group">
                <input class="form-control" placeholder="Buscar por nombres" name="name" type="text" id="name">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-default btn-flat"><i class="fa fa-search" aria-hidden="true"></i></button>
                </span>
              </div>
            </form>
          </div>
        </div>
        <div class="collapse" id="form0">
          <hr>
          <form method="POST" action="{{route('users.store')}}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('Nombre') ? 'has-error' : '' }}">
              <label for="Nombre">Nombre</label>
              <input class="form-control" placeholder="Nombres" required="" name="Nombre" type="text" id="name">
            </div>
            <div class="form-group {{ $errors->has('Apellido') ? 'has-error' : '' }}">
              <label for="Apellido">Apellidos</label>
              <input class="form-control" placeholder="Apellidos" required="" name="Apellido" type="text" id="last_name">
            </div>
            <div class="form-group {{ $errors->has('Email') ? 'has-error' : '' }}">
              <label for="Email">Email</label>
              <input class="form-control" placeholder="example@mail.com" required="" name="Email" type="email" id="email">
            </div>
            <div class="form-group {{ $errors->has('Password') ? 'has-error' : '' }}">
              <label for="Password">Contraseña</label>
              <input class="form-control" placeholder="*********" required="" name="Password" type="password" id="password">
            </div>
            <div class="form-group {{ $errors->has('Telefono') ? 'has-error' : '' }}">
              <label for="Telefono">Numero de Telefono</label>
              <input class="form-control" placeholder="0000-0000000" required="" name="Telefono" type="number" id="phone">
            </div>
            <div class="form-group {{ $errors->has('Cedula') ? 'has-error' : '' }}">
              <label for="Cedula">Numero de cedula</label>
              <input class="form-control" placeholder="999999999" required="" name="Cedula" type="tel" id="cedula">
            </div>
            <div class="form-group {{ $errors->has('TipoUsuario') ? 'has-error' : '' }}">
              <label for="TipoUsuario">Tipo de Usuario</label>
              <select class="form-control" required="" name="TipoUsuario" id="type_user">
                <option value="select">Seleccione una opcion...</option>
                @foreach ($type_users as $type_user)
                  <option value="{{$type_user->id}}">{{$type_user->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group {{ $errors->has('DepositoSoftservica') ? 'has-error' : '' }}">
              <button class="btn btn-success" type="submit"><i class="fa  fa-upload"></i> Registrar</button>
            </div>
        </form>
        </div>
        <div class="container-fluid">

  			</div>
        <hr>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
              <tr>
                  <th>Nombres</th>
                  <th>Email</th>
                  <th>Clave</th>
                  <th>Numero de cedula</th>
                  <th>Tipo de usuario</th>
                  <th>Accion</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($users as $user2)
              <tr class="odd gradeX">
                <td>{{$user2->nombre}} {{$user2->apellido}}</td>
                <td>{{$user2->email}}</td>
                <td>{{$user2->clave}}</td>
                <td>{{$user2->cedula}}</td>
                <td>{{$user2->tipo->name}}</td>
                <td >
                  <a class="btn btn-warning" role="button" data-toggle="collapse" href="#form{{$user2->id}}" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <a href="{{ route('users.destroy', $user2->id) }}" onclick="return confirm('¿Seguro que deseas eliminar?')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
              </tr>
              <tr class="odd gradeX collapse"  id="form{{$user2->id}}">
                <td COLSPAN=7>
                  <form method="POST" action="{{route('users.update',$user2->id)}}" accept-charset="UTF-8">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="name">Nombre</label>
                      <input class="form-control" value="{{$user2->nombre}}" required="" name="Nombre" type="text" id="name">
                    </div>
                    <div class="form-group">
                      <label for="last_name">Apellidos</label>
                      <input class="form-control" value="{{$user2->apellido}}" required="" name="Apellido" type="text" id="last_name">
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input class="form-control" value="{{$user2->email}}" required="" name="Email" type="email" id="email">
                    </div>
                    <div class="form-group">
                      <label for="password">Contraseña</label>
                      <input class="form-control" value="{{$user2->clave}}" required="" name="Password" type="password" id="password">
                    </div>
                    <div class="form-group">
                      <label for="phone">Numero de Telefono</label>
                      <input class="form-control" value="{{$user2->telefono}}" required="" name="Telefono" type="number" id="phone">
                    </div>
                    <div class="form-group">
                      <label for="cedula">Numero de cedula</label>
                      <input class="form-control" value="{{$user2->cedula}}" required="" name="Cedula" type="tel" id="cedula">
                    </div>
                    <div class="form-group">
                      <label for="type_user">Tipo de Usuario</label>
                      <select class="form-control" required="" name="TipoUsuario" id="type_user">
                        <option value="{{$user2->tipo_id}}">{{$user2->tipo->name}}</option>
                        @foreach ($type_users as $type_user)
                          @if ($type_user->id !=  $user2->tipo_id)
                            <option value="{{$type_user->id}}">{{$type_user->name}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-warning" type="submit"><i class="fa fa-pencil"></i> Editar</button>
                    </div>
                  </form>
              </tr>
              <tr class="odd gradeX collapse">
              </tr>
            @endforeach
          </tbody>
        </table>
        {!! $users->render() !!}
      </div>
    </div>
  </div>
@endsection
