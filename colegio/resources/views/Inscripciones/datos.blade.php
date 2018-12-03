@extends('main')

@section('title')
  Datos del Estudiante
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Inscripciones</li>
    <li class="active">Datos del Estudiante</li>
  </ol>
@endsection


@section('content')
  <div>
    <form method="POST" action="{{ route('inscripcion.inscribir') }}" accept-charset="UTF-8">
      {{ csrf_field() }}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Datos del Estudiante</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="form-group col-md-3 {{ $errors->has('CedulaEstudiante') ? 'has-error' : '' }}">
              <label for="CedulaEstudiante">Cedula</label>
              <input type="number" name="CedulaEstudiante" class="form-control" required autofocus>
            </div>
            <div class="form-group col-md-1 {{ $errors->has('NacionalidadEstudiante') ? 'has-error' : '' }}">
              <label for="NacionalidadEstudiante">Nac</label>
              <select class="form-control" name="NacionalidadEstudiante" required>
                <option value="" disabled selected >Nac</option>
                <option value="V">V</option>
                <option value="E">E</option>
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('NombreEstudiante') ? 'has-error' : '' }}">
              <label for="NombreEstudiante">Nombres:</label>
              <input type="text" name="NombreEstudiante" class="form-control" placeholder="Nombres" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('ApellidoEstudiante') ? 'has-error' : '' }}">
              <label for="ApellidoEstudiante">Apellidos:</label>
              <input type="text" name="ApellidoEstudiante" class="form-control" placeholder="Apeliidos" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('FechaNacimientoEstudiante') ? 'has-error' : '' }}">
              <label for="FechaNacimientoEstudiante">Fecha Nac:</label>
              <input type="text" name="FechaNacimientoEstudiante" class="form-control datepicker" placeholder="dd/mm/aaaa" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('PlantelProcedencia') ? 'has-error' : '' }}">
              <label for="PlantelProcedencia">Pantel de Procedencia:</label>
              <select class="form-control" name="PlantelProcedencia" required id="plantel">
                <option value="" disabled selected>Seleccione Plantel</option>
                @foreach ($planteles as $plantel)
                  <option value="{{ $plantel->est_codigo }}">{{ $plantel->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('LugardeNacimiento') ? 'has-error' : '' }}">
              <label for="LugardeNacimiento">Lugar de nacimiento:</label>
              <input type="text" name="LugardeNacimiento" class="form-control" required placeholder="Lugar de nacimineto">
            </div>
            <div class="form-group col-md-4 {{ $errors->has('Pais') ? 'has-error' : '' }}">
              <label for="Pais">Pais:</label>
              <select class="form-control" name="Pais" required>
                <option value="" disabled selected>Seleccione Pais</option>
                @foreach ($paises as $pais)
                  <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('Estado') ? 'has-error' : '' }}">
              <label for="Estado">Estado:</label>
                <select class="form-control" name="Estado" required>
                <option value="" disabled selected>Seleccione Pais</option>
                @foreach ($estados as $estado)
                  <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('EstadoCivil') ? 'has-error' : '' }}">
              <label for="EstadoCivil">Estado Civil:</label>
              <select class="form-control" name="EstadoCivil" required>
                <option value="" disabled selected>Estado Civil</option>
                <option value="S">Soltero</option>
                <option value="C">Casado</option>
                <option value="D">Divorciado</option>
                <option value="V">Viudo</option>
                <option value="O">Otro</option>
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('Sexo') ? 'has-error' : '' }}">
              <label for="Sexo">Sexo:</label>
              <select class="form-control" name="Sexo" required>
                <option value="" disabled selected>Seleccione Sexo</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('TipodeParto') ? 'has-error' : '' }}">
              <label for="TipodeParto">Tipo de parto:</label>
              <select class="form-control" name="TipodeParto" required>
                <option value="" disabled selected>Tipo de Parto</option>
                <option value="0">Parto Natural</option>
                <option value="1">Parto por cesárea</option>
                <option value="2">Otro</option>
                <option value="3">Otro</option>
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('EmailEstudiante') ? 'has-error' : '' }}">
              <label for="EmailEstudiante">E-Mail:</label>
              <input type="email" name="EmailEstudiante" class="form-control" placeholder="example@mail.com" required>
            </div>
          </div><!--Fin row-->
        </div><!--Fin panel body-->
      </div>
        <!--Datos de la madre-->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos de la madre</h3>
          </div>
          <div class="box-body">
          <div class="row">
            <div class="form-group col-md-3 {{ $errors->has('CedulaMadre') ? 'has-error' : '' }}">
              <label for="CedulaMadre">Cedula</label>
              <input type="number" name="CedulaMadre" class="form-control" placeholder="Cedula" required>
            </div>
            <div class="form-group col-md-1 {{ $errors->has('NacionalidadMadre') ? 'has-error' : '' }}">
              <label for="NacionalidadMadre">Nac</label>
              <select class="form-control" name="NacionalidadMadre" required>
                <option value="" disabled selected>Nac</option>
                <option value="V">V</option>
                <option value="E">E</option>
              </select>
            </div>
            <div class="form-group col-md-8 {{ $errors->has('NombreMadre') ? 'has-error' : '' }}">
              <label for="NombreMadre">Nombres y apellidos:</label>
              <input type="text" name="NombreMadre" class="form-control" placeholder="Nombres y apellidos" required>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('DireccionMadre') ? 'has-error' : '' }}">
              <label for="DireccionMadre">Direccion de Habitación:</label>
              <input type="text" name="DireccionMadre" class="form-control" placeholder="Direccion" required>
            </div>
            <div class="form-group col-md-3 {{ $errors->has('TelefonoCelularMadre') ? 'has-error' : '' }}">
              <label for="TelefonoCelularMadre">Telefono Celular:</label>
              <input type="tel" name="TelefonoCelularMadre" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-3 {{ $errors->has('TelefonoHabitacionMadre') ? 'has-error' : '' }}">
              <label for="TelefonoHabitacionMadre">Tlf. Habitacion:</label>
              <input type="tel" name="TelefonoHabitacionMadre" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-5 {{ $errors->has('LugarTrabajoMadre') ? 'has-error' : '' }}">
              <label for="LugarTrabajoMadre">Lugar de Trabajo:</label>
              <input type="text" name="LugarTrabajoMadre" class="form-control" placeholder="Lugar de Trabajo" required>
            </div>
            <div class="form-group col-md-5 {{ $errors->has('DireccionTrabjoMadre') ? 'has-error' : '' }}">
              <label for="DireccionTrabjoMadre">Direccion de Trabajo:</label>
              <input type="text" name="DireccionTrabjoMadre" class="form-control" placeholder="Direccion de Trabajo" required>
            </div>
            <div class="form-group col-md-2 {{ $errors->has('TelefonoTrabajoMadre') ? 'has-error' : '' }}">
              <label for="TelefonoTrabajoMadre">Tlf. de Trabajo:</label>
              <input type="tel" name="TelefonoTrabajoMadre" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('ProfecionMadre') ? 'has-error' : '' }}">
              <label for="ProfecionMadre">Profesion:</label>
              <input type="text" name="ProfecionMadre" class="form-control" placeholder="Profesion" required>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('EmailMadre') ? 'has-error' : '' }}">
              <label for="EmailMadre">E-Mail:</label>
              <input type="email" name="EmailMadre" class="form-control" placeholder="example@mail.com" required>
            </div>
          </div><!--Fin row-->
        </div><!--Fin panel body-->
      </div>
        <!--Datos Padre-->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos del padre</h3>
          </div>
          <div class="box-body">
          <div class="row">
            <div class="form-group col-md-3 {{ $errors->has('CedulaPadre') ? 'has-error' : '' }}">
              <label for="CedulaPadre">Cedula</label>
              <input type="number" name="CedulaPadre" class="form-control" placeholder="Cedula" required>
            </div>
            <div class="form-group col-md-1 {{ $errors->has('NacionalidadPadre') ? 'has-error' : '' }}">
              <label for="NacionalidadPadre">Nac</label>
              <select class="form-control" name="NacionalidadPadre" required>
                <option value="" disabled selected>Nac</option>
                <option value="V">V</option>
                <option value="E">E</option>
              </select>
            </div>
            <div class="form-group col-md-8 {{ $errors->has('NombrePadre') ? 'has-error' : '' }}">
              <label for="NombrePadre">Nombres y apellidos:</label>
              <input type="text" name="NombrePadre" class="form-control" placeholder="Nombres y apellidos" required>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('DireccionPadre') ? 'has-error' : '' }}">
              <label for="DireccionPadre">Direccion de Habitación:</label>
              <input type="text" name="DireccionPadre" class="form-control" placeholder="Direccion" required>
            </div>
            <div class="form-group col-md-3 {{ $errors->has('TelefonoCelularPadre') ? 'has-error' : '' }}">
              <label for="TelefonoCelularPadre">Telefono Celular:</label>
              <input type="tel" name="TelefonoCelularPadre" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-3 {{ $errors->has('TelefonoHabitacionPadre') ? 'has-error' : '' }}">
              <label for="TelefonoHabitacionPadre">Tlf. Habitacion:</label>
              <input type="tel" name="TelefonoHabitacionPadre" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-5 {{ $errors->has('LugarTrabajoPadre') ? 'has-error' : '' }}">
              <label for="LugarTrabajoPadre">Lugar de Trabajo:</label>
              <input type="text" name="LugarTrabajoPadre" class="form-control" placeholder="Lugar de Trabajo" required>
            </div>
            <div class="form-group col-md-5 {{ $errors->has('DireccionTrabjoPadre') ? 'has-error' : '' }}">
              <label for="DireccionTrabjoPadre">Direccion de Trabajo:</label>
              <input type="text" name="DireccionTrabjoPadre" class="form-control" placeholder="Direccion de Trabajo" required>
            </div>
            <div class="form-group col-md-2 {{ $errors->has('TelefonoTrabajoPadre') ? 'has-error' : '' }}">
              <label for="TelefonoTrabajoPadre">Tlf. de Trabajo:</label>
              <input type="tel" name="TelefonoTrabajoPadre" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('ProfecionPadre') ? 'has-error' : '' }}">
              <label for="ProfecionPadre">Profesion:</label>
              <input type="text" name="ProfecionPadre" class="form-control" placeholder="Profesion" required>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('EmailPadre') ? 'has-error' : '' }}">
              <label for="EmailPadre">E-Mail:</label>
              <input type="email" name="EmailPadre" class="form-control" placeholder="example@mail.com" required>
            </div>
          </div><!--Fin row-->
        </div><!--Fin panel body-->
      </div>
        <!--Datos Representante-->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos del representante</h3>
          </div>
          <div class="box-body">
          <div class="row">
            <div class="form-group col-md-3" {{ $errors->has('CedulaRepresentante') ? 'has-error' : '' }}>
              <label for="CedulaRepresentante">Cedula</label>
              <input type="number" name="CedulaRepresentante" class="form-control" placeholder="Cedula" required>
            </div>
            <div class="form-group col-md-1 {{ $errors->has('NacionalidadRepresentante') ? 'has-error' : '' }}">
              <label for="NacionalidadRepresentante">Nac</label>
              <select class="form-control" name="NacionalidadRepresentante" required>
                <option value="" disabled selected>Nac</option>
                <option value="V">V</option>
                <option value="E">E</option>
              </select>
            </div>
            <div class="form-group col-md-8 {{ $errors->has('NombreRepresentante') ? 'has-error' : '' }}">
              <label for="NombreRepresentante">Nombres y apellidos:</label>
              <input type="text" name="NombreRepresentante" class="form-control" placeholder="Nombres y apellidos" required>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('DireccionRepresentante') ? 'has-error' : '' }}">
              <label for="DireccionRepresentante">Direccion de Habitación:</label>
              <input type="text" name="DireccionRepresentante" class="form-control" placeholder="Direccion" required>
            </div>
            <div class="form-group col-md-3 {{ $errors->has('TelefonoCelularRepresentante') ? 'has-error' : '' }}">
              <label for="TelefonoCelularRepresentante">Telefono Celular:</label>
              <input type="tel" name="TelefonoCelularRepresentante" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-3 {{ $errors->has('TelefonoHabitacionRepresentante') ? 'has-error' : '' }}">
              <label for="TelefonoHabitacionRepresentante">Tlf. Habitacion:</label>
              <input type="tel" name="TelefonoHabitacionRepresentante" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-5 {{ $errors->has('LugarTrabajoRepresentante') ? 'has-error' : '' }}">
              <label for="LugarTrabajoRepresentante">Lugar de Trabajo:</label>
              <input type="text" name="LugarTrabajoRepresentante" class="form-control" placeholder="Lugar de Trabajo" required>
            </div>
            <div class="form-group col-md-5 {{ $errors->has('DireccionTrabjoRepresentante') ? 'has-error' : '' }}">
              <label for="DireccionTrabjoRepresentante">Direccion de Trabajo:</label>
              <input type="text" name="DireccionTrabjoRepresentante" class="form-control" placeholder="Direccion de Trabajo" required>
            </div>
            <div class="form-group col-md-2 {{ $errors->has('TelefonoTrabajoRepresentante') ? 'has-error' : '' }}">
              <label for="TelefonoTrabajoRepresentante">Tlf. de Trabajo:</label>
              <input type="tel" name="TelefonoTrabajoRepresentante" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('ProfecionRepresentante') ? 'has-error' : '' }}">
              <label for="ProfecionRepresentante">Profesion:</label>
              <input type="text" name="ProfecionRepresentante" class="form-control" placeholder="Profesion" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('EmailRepresentante') ? 'has-error' : '' }}">
              <label for="EmailRepresentante">E-Mail:</label>
              <input type="email" name="EmailRepresentante" class="form-control" placeholder="example@mail.com" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('ParentescoRepresentante') ? 'has-error' : '' }}">
              <label for="ParentescoRepresentante">Parentesco</label>
              <input type="text" name="ParentescoRepresentante" class="form-control" placeholder="Parentesco" required>
            </div>
          </div><!--Fin row-->
        </div><!--Fin panel body-->
      </div>
        <!--Datos de emergencia-->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos de Emergencia</h3>
          </div>
          <div class="box-body">
          <div class="row">
            <div class="form-group col-md-4 {{ $errors->has('NombreEmergencia') ? 'has-error' : '' }}">
              <label for="NombreEmergencia">En Caso de Emergencia Llamar:</label>
              <input type="text" name="NombreEmergencia" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('TelefonoEmergencia') ? 'has-error' : '' }}">
              <label for="TelefonoEmergencia">Telefono:</label>
              <input type="tel" name="TelefonoEmergencia" class="form-control" placeholder="0000-0000000" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('GradoFamiliarEmergencia') ? 'has-error' : '' }}">
              <label for="GradoFamiliarEmergencia">Grado Familiar</label>
              <input type="text" name="GradoFamiliarEmergencia" class="form-control" placeholder="Familiar" required>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('ViveConEmergencia') ? 'has-error' : '' }}">
              <label for="ViveConEmergencia">Vive Con:</label>
              <select class="form-control" name="ViveConEmergencia" required>
                <option value=""disabled selected>Seleccione una opcion</option>
                <option value="1">Papa</option>
                <option value="2">Mama</option>
                <option value="3">Otro</option>
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('TransporteEmergencia') ? 'has-error' : '' }}">
              <label for="TransporteEmergencia">Medio de Transporte</label>
              <select class="form-control" name="TransporteEmergencia" required>
                <option value=""disabled selected>Seleccione una opcion</option>
                <option value="1">Particular</option>
                <option value="2">Transporte Publico</option>
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('NombreViveEmergencia') ? 'has-error' : '' }}">
              <label for="NombreViveEmergencia">Nombre con quien vive</label>
              <input type="text" name="NombreViveEmergencia" class="form-control" placeholder="Nombre" required>
            </div>
          </div><!--Fin row-->
        </div><!--Fin panel body-->
      </div><!--Fin panel primary-->
    </div>
    <div class="form-group">
      <input class="btn btn-primary" type="submit" value="Guardar">
    </div>
    </form>
  </div><!--Fin car-->
@endsection

@section('js')
  <script>
  $('.datepicker').datepicker({
    autoclose: true,
    orientation: 'auto bottom',
    formatDate: "yy-mm-dd"
  });
    $('#plantel').select2();
  </script>
@endsection
