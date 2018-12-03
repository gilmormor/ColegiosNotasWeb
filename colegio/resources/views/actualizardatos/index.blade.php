@extends('main')

@section('title')
  Actualizar Datos
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Academicos</li>
    <li class="active">Actualizar Datos</li>
  </ol>
@endsection

@section('content')
  @php
    //Fecha actual
    $aux = explode(" ",$filtros[0]->fecfininsc);
    $aux2 = explode("-",$aux[0]);
    $aux3 = explode(":",$aux[1]);
    $fecha_i = $aux2[0].$aux2[1].$aux2[2];
    $hora_i = $aux3[0].$aux3[1].$aux3[2];
    //Fecha de Inscripcion
    $date = getdate();
    $cero = 0;
    //Fecha
    if ($date["year"] < 10 && $date["mon"] < 10 && $date["mday"] < 10) {
      $fecha_a = $cero.$date["year"].$cero.$date["mon"].$cero.$date["mday"];
    }elseif ($date["year"] < 10 && $date["mon"] < 10) {
      $fecha_a = $cero.$date["year"].$cero.$date["mon"].$date["mday"];
    }elseif ($date["year"] < 10 && $date["mday"] < 10) {
      $fecha_a = $cero.$date["year"].$date["mon"].$cero.$date["mday"];
    }elseif ($date["mon"] < 10 && $date["mday"] < 10) {
      $fecha_a = $date["year"].$cero.$date["mon"].$cero.$date["mday"];
    }elseif ($date["year"] < 10) {
      $fecha_a = $cero.$date["year"].$date["mon"].$date["mday"];
    }elseif ($date["mon"] < 10) {
      $fecha_a = $date["year"].$cero.$date["mon"].$date["mday"];
    }elseif ($date["mday"] < 10) {
      $fecha_a = $date["year"].$date["mon"].$cero.$date["mday"];
    }else {
      $fecha_a = $date["year"].$date["mon"].$date["mday"];
    }
    //Hora
    if ($date["hours"] < 10 && $date["minutes"] < 10 && $date["seconds"] < 10) {
      $hora_a = $cero.$date["hours"].$cero.$date["minutes"].$cero.$date["seconds"];
    }elseif ($date["hours"] < 10 && $date["minutes"] < 10) {
      $hora_a = $cero.$date["hours"].$cero.$date["minutes"].$date["seconds"];
    }elseif ($date["hours"] < 10 && $date["seconds"] < 10) {
      $hora_a = $cero.$date["hours"].$date["minutes"].$cero.$date["seconds"];
    }elseif ($date["minutes"] < 10 && $date["seconds"] < 10) {
      $hora_a = $date["hours"].$cero.$date["minutes"].$cero.$date["seconds"];
    }elseif ($date["hours"] < 10) {
      $hora_a = $cero.$date["hours"].$date["minutes"].$date["seconds"];
    }elseif ($date["minutes"] < 10) {
      $hora_a = $date["hours"].$cero.$date["minutes"].$date["seconds"];
    }elseif ($date["seconds"] < 10) {
        $hora_a = $date["hours"].$date["minutes"].$cero.$date["seconds"];
    }else {
      $hora_a = $date["hours"].$date["minutes"].$date["seconds"];
    }
    $band = true;
  @endphp
  @if ($fecha_a > $fecha_i)
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-info"></i> Importante!</h4>
      El proceso de inscripcion finalizo.
    </div>
    @php
      $band = false;
    @endphp
  @elseif ($fecha_a == $fecha_i && $hora_a > $hora_i)
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-info"></i> Importante!</h4>
      El proceso de inscripcion finalizo.
    </div>
    @php
      $band = false;
    @endphp
  @endif
  <!--Estudiante inscrito-->
  <div class="alert alert-success alert-dismissible" style="display:none" id="inscrito">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Importante!</h4>
      Estudiante inscrito ya se puede imprimir la planilla Inscripcion.
  </div>
  <!--Estudiante bajado-->
  <div class="alert alert-warning alert-dismissible" style="display:none" id="bajado">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-warning"></i> Importante!</h4>
      EL estudiante ya fue bajado no se puede actualizar.
  </div>
    <!--Formulario de inscripcion-->
    <form method="POST" action="{{ route('actualizardatos.store') }}" accept-charset="UTF-8">
      {{ csrf_field() }}
      <input type="text" name="ids" id="ids" style="display: none">
      <input type="text" name="ids2" id="ids2" style="display: none">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Datos del Estudiante</h3>
        </div>
        <div class="box-body">
          <div class="row">
            @if (Auth::user()->tipo_id == 3)
              <div class="form-group col-md-3">
                <label for="cedulaE">Cedula</label>
                <select class="form-control" name="cedulaE" id="cedulaE">
                  <option value="" disabled selected >Seleccione Cedula</option>
                    @foreach ($estudiantes as $estudiante)
                      <option value="{{ $estudiante->est_ced }}">{{ $estudiante->est_ced }}</option>
                    @endforeach
                </select>
              </div>
              @else
                <div class="form-group col-md-3">
                  <label for="cedulaE">Cedula</label>
                  <select class="form-control" name="cedulaE" id="cedulaE">
                    <option value="" disabled selected >Seleccione Cedula</option>
                    @foreach ($repres as $repre)
                      <option value="{{ $repre->est_ced }}">{{ $repre->est_nombres }}</option>
                    @endforeach
                  </select>
                </div>
            @endif
            <div class="form-group col-md-1 {{ $errors->has('NacionalidadEstudiante') ? 'has-error' : '' }}">
              <label for="NacionalidadEstudiante">Nac</label>
              <select class="form-control" name="NacionalidadEstudiante" id="nacE" disabled="disable" required >
                <option value="" disabled selected >Nac</option>
                <option value="V">V</option>
                <option value="E">E</option>
              </select>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('NombreEstudiante') ? 'has-error' : '' }}">
              <label for="NombreEstudiante">Nombres:</label>
              <input type="text" name="NombreEstudiante" class="form-control" id="nombresE" disabled="disabled" placeholder="Nombres" required >
            </div>
            <div class="form-group col-md-4 {{ $errors->has('ApellidoEstudiante') ? 'has-error' : '' }}">
              <label for="ApellidoEstudiante">Apellidos:</label>
              <input type="text" name="ApellidoEstudiante" class="form-control" id="apellidosE" disabled="disabled" placeholder="Apeliidos" required >
            </div>
            <div class="form-group col-md-4 {{ $errors->has('FechaNacimientoEstudiante') ? 'has-error' : '' }}">
              <label for="FechaNacimientoEstudiante">Fecha Nac:</label>
              <input type="text" name="FechaNacimientoEstudiante" class="form-control datepicker" id="fec_nacE" disabled="disabled" placeholder="fecha" required >
            </div>
            <div class="form-group col-md-8 {{ $errors->has('PlantelProcedencia') ? 'has-error' : '' }}">
              <label for="PlantelProcedencia">Pantel de Procedencia:</label>
              <input type="text" name="PlantelProcedencia" id="plante_proc" class="form-control" disabled="disabled" placeholder="Plantel de procedencia" required>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('LugardeNacimiento') ? 'has-error' : '' }}">
              <label for="LugardeNacimiento">Lugar de nacimiento:</label>
              <input type="text" name="LugardeNacimiento" class="form-control" id="lug_nacE" disabled="disabled" placeholder="Lugar de nacimineto" required >
            </div>
            <div class="form-group col-md-3 {{ $errors->has('Pais') ? 'has-error' : '' }}">
              <label for="Pais">Pais:</label>
              <select class="form-control" name="Pais" disabled="disabled" id="pais" required >
                <option value="" disabled selected>Seleccione Pais</option>
                @foreach ($paises as $pais)
                  <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-3 {{ $errors->has('Estado') ? 'has-error' : '' }}">
              <label for="Estado">Estado:</label>
                <select class="form-control" name="Estado" disabled="disabled" id="estado" required >
                <option value="" disabled selected>Seleccione Pais</option>
                @foreach ($estados as $estado)
                  <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-2 {{ $errors->has('EstadoCivil') ? 'has-error' : '' }}">
              <label for="EstadoCivil">Estado Civil:</label>
              <select class="form-control" name="EstadoCivil" disabled="disabled" id="est_cil" required >
                <option value="" disabled selected>Estado Civil</option>
                <option value="C">Casado (a)</option>
                <option value="D">Divorciado (a)</option>
                <option value="S">Soltero (a)</option>
                <option value="V">Viudo (a)</option>
              </select>
            </div>
            <div class="form-group col-md-2 {{ $errors->has('Sexo') ? 'has-error' : '' }}">
              <label for="Sexo">Sexo:</label>
              <select class="form-control" name="Sexo" disabled="disabled" id="sexo" required >
                <option value="" disabled selected>Seleccione Sexo</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>
            <div class="form-group col-md-3 {{ $errors->has('TipodeParto') ? 'has-error' : '' }}">
              <label for="TipodeParto">Tipo de parto:</label>
              <select class="form-control" name="TipodeParto" disabled="disabled" id="tipo_part" required >
                <option value="" disabled selected>Tipo de Parto</option>
                <option value="1">Parto sencillo</option>
                <option value="2">Primer Morocho</option>
                <option value="3">Segundo Morocho</option>
                <option value="4">Primer Trillizo</option>
                <option value="5">Segundo Trillizo</option>
                <option value="6">Tercer Trillizo</option>
              </select>
            </div>
            <div class="form-group col-md-5 {{ $errors->has('EmailEstudiante') ? 'has-error' : '' }}">
              <label for="EmailEstudiante">E-Mail:</label>
              <input type="email" name="EmailEstudiante" class="form-control" id="emailE" placeholder="example@mail.com" disabled="disbled" required >
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
                <input type="number" name="CedulaMadre" class="form-control" placeholder="Cedula" disabled="disabled" id="ced_m"required>
              </div>
              <div class="form-group col-md-1 {{ $errors->has('NacionalidadMadre') ? 'has-error' : '' }}">
                <label for="NacionalidadMadre">Nac</label>
                <select class="form-control" name="NacionalidadMadre" id="nacM" disabled="disabled"required>
                  <option value="" disabled selected>Nac</option>
                  <option value="V">V</option>
                  <option value="E">E</option>
                </select>
              </div>
              <div class="form-group col-md-8 {{ $errors->has('NombreMadre') ? 'has-error' : '' }}">
                <label for="NombreMadre">Nombres y apellidos:</label>
                <input type="text" name="NombreMadre" class="form-control" placeholder="Nombres y apellidos" disabled="disabled" id="nombM"required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('DireccionMadre') ? 'has-error' : '' }}">
                <label for="DireccionMadre">Direccion de Habitación:</label>
                <input type="text" name="DireccionMadre" class="form-control" placeholder="Direccion" disabled="disabled" id="direcM"required>
              </div>
              <div class="form-group col-md-3 {{ $errors->has('TelefonoCelularMadre') ? 'has-error' : '' }}">
                <label for="TelefonoCelularMadre">Telefono Celular:</label>
                <input type="tel" name="TelefonoCelularMadre" class="form-control" placeholder="00000000000" disabled="disabled" id="tel_cM"required>
              </div>
              <div class="form-group col-md-3 {{ $errors->has('TelefonoHabitacionMadre') ? 'has-error' : '' }}">
                <label for="TelefonoHabitacionMadre">Tlf. Habitacion:</label>
                <input type="tel" name="TelefonoHabitacionMadre" class="form-control" placeholder="00000000000" disabled="disabled" id="tel_hM"required>
              </div>
              <div class="form-group col-md-5 {{ $errors->has('LugarTrabajoMadre') ? 'has-error' : '' }}">
                <label for="LugarTrabajoMadre">Lugar de Trabajo:</label>
                <input type="text" name="LugarTrabajoMadre" class="form-control" placeholder="Lugar de Trabajo" disabled="disabled" id="ltM"required>
              </div>
              <div class="form-group col-md-5 {{ $errors->has('DireccionTrabjoMadre') ? 'has-error' : '' }}">
                <label for="DireccionTrabjoMadre">Direccion de Trabajo:</label>
                <input type="text" name="DireccionTrabjoMadre" class="form-control" placeholder="Direccion de Trabajo" disabled="disabled" id="dirtM"required>
              </div>
              <div class="form-group col-md-2 {{ $errors->has('TelefonoTrabajoMadre') ? 'has-error' : '' }}">
                <label for="TelefonoTrabajoMadre">Tlf. de Trabajo:</label>
                <input type="tel" name="TelefonoTrabajoMadre" class="form-control" placeholder="00000000000" disabled="disabled" id="tlf_tM"required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('ProfecionMadre') ? 'has-error' : '' }}">
                <label for="ProfecionMadre">Profesion:</label>
                <input type="text" name="ProfecionMadre" class="form-control" placeholder="Profesion" disabled="disabled" id="prfM"required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('EmailMadre') ? 'has-error' : '' }}">
                <label for="EmailMadre">E-Mail:</label>
                <input type="email" name="EmailMadre" class="form-control" placeholder="example@mail.com" disabled="disabled" id="emailM"required>
              </div>
            </div><!--Fin row-->
          </div><!--Fin panel body-->
        </div><!--Fin panel Primary-->
        <!--Datos Padre-->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos del padre</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-3 {{ $errors->has('CedulaPadre') ? 'has-error' : '' }}">
                <label for="CedulaPadre">Cedula</label>
                <input type="number" name="CedulaPadre" class="form-control" placeholder="Cedula" disabled="disabled" id="ced_p"required>
              </div>
              <div class="form-group col-md-1 {{ $errors->has('NacionalidadPadre') ? 'has-error' : '' }}">
                <label for="NacionalidadPadre">Nac</label>
                <select class="form-control" name="NacionalidadPadre" id="nacp" disabled="disabled" required>
                  <option value="" disabled selected>Nac</option>
                  <option value="V">V</option>
                  <option value="E">E</option>
                </select>
              </div>
              <div class="form-group col-md-8 {{ $errors->has('NombrePadre') ? 'has-error' : '' }}">
                <label for="NombrePadre">Nombres y apellidos:</label>
                <input type="text" name="NombrePadre" class="form-control" placeholder="Nombres y apellidos" disabled="disabled" id="nombp" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('DireccionPadre') ? 'has-error' : '' }}">
                <label for="DireccionPadre">Direccion de Habitación:</label>
                <input type="text" name="DireccionPadre" class="form-control" placeholder="Direccion" disabled="disabled" id="direcp" required>
              </div>
              <div class="form-group col-md-3 {{ $errors->has('TelefonoCelularPadre') ? 'has-error' : '' }}">
                <label for="TelefonoCelularPadre">Telefono Celular:</label>
                <input type="tel" name="TelefonoCelularPadre" class="form-control" placeholder="00000000000" disabled="disabled" id="tel_cp" required>
              </div>
              <div class="form-group col-md-3 {{ $errors->has('TelefonoHabitacionPadre') ? 'has-error' : '' }}">
                <label for="TelefonoHabitacionPadre">Tlf. Habitacion:</label>
                <input type="tel" name="TelefonoHabitacionPadre" class="form-control" placeholder="00000000000" disabled="disabled" id="tel_hp" required>
              </div>
              <div class="form-group col-md-5 {{ $errors->has('LugarTrabajoPadre') ? 'has-error' : '' }}">
                <label for="LugarTrabajoPadre">Lugar de Trabajo:</label>
                <input type="text" name="LugarTrabajoPadre" class="form-control" placeholder="Lugar de Trabajo" disabled="disabled" id="ltp" required>
              </div>
              <div class="form-group col-md-5 {{ $errors->has('DireccionTrabjoPadre') ? 'has-error' : '' }}">
                <label for="DireccionTrabjoPadre">Direccion de Trabajo:</label>
                <input type="text" name="DireccionTrabjoPadre" class="form-control" placeholder="Direccion de Trabajo" disabled="disabled" id="dirtp" required>
              </div>
              <div class="form-group col-md-2 {{ $errors->has('TelefonoTrabajoPadre') ? 'has-error' : '' }}">
                <label for="TelefonoTrabajoPadre">Tlf. de Trabajo:</label>
                <input type="tel" name="TelefonoTrabajoPadre" class="form-control" placeholder="00000000000" disabled="disabled" id="tlf_tp" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('ProfecionPadre') ? 'has-error' : '' }}">
                <label for="ProfecionPadre">Profesion:</label>
                <input type="text" name="ProfecionPadre" class="form-control" placeholder="Profesion" disabled="disabled" id="prfp" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('EmailPadre') ? 'has-error' : '' }}">
                <label for="EmailPadre">E-Mail:</label>
                <input type="email" name="EmailPadre" class="form-control" placeholder="example@mail.com" disabled="disabled" id="emailp" required>
              </div>
            </div><!--Fin row-->
          </div><!--Fin panel body-->
        </div><!--Fin panel primary-->
        <!--Datos Representante-->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos del representante</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-3  {{ $errors->has('CedulaRepresentante') ? 'has-error' : '' }}">
                <label for="CedulaRepresentante">Cedula</label>
                <input type="number" name="CedulaRepresentante" class="form-control" placeholder="Cedula" disabled="disabled" id="ced_R"required>
              </div>
              <div class="form-group col-md-1  {{ $errors->has('NacionalidadRepresentante') ? 'has-error' : '' }}">
                <label for="NacionalidadRepresentante">Nac</label>
                <select class="form-control" name="NacionalidadRepresentante" id="nacR" disabled="disabled" required>
                  <option value="" disabled selected>Nac</option>
                  <option value="V">V</option>
                  <option value="E">E</option>
                </select>
              </div>
              <div class="form-group col-md-8  {{ $errors->has('NombreRepresentante') ? 'has-error' : '' }}">
                <label for="NombreRepresentante">Nombres y apellidos:</label>
                <input type="text" name="NombreRepresentante" class="form-control" placeholder="Nombres y apellidos" disabled="disabled" id="nombR" required>
              </div>
              <div class="form-group col-md-6  {{ $errors->has('DireccionRepresentante') ? 'has-error' : '' }}">
                <label for="DireccionRepresentante">Direccion de Habitación:</label>
                <input type="text" name="DireccionRepresentante" class="form-control" placeholder="Direccion" disabled="disabled" id="direcR" required>
              </div>
              <div class="form-group col-md-3  {{ $errors->has('TelefonoCelularRepresentante') ? 'has-error' : '' }}">
                <label for="TelefonoCelularRepresentante">Telefono Celular:</label>
                <input type="tel" name="TelefonoCelularRepresentante" class="form-control" placeholder="00000000000" disabled="disabled" id="tel_cR" required>
              </div>
              <div class="form-group col-md-3  {{ $errors->has('TelefonoHabitacionRepresentante') ? 'has-error' : '' }}">
                <label for="TelefonoHabitacionRepresentante">Tlf. Habitacion:</label>
                <input type="tel" name="TelefonoHabitacionRepresentante" class="form-control" placeholder="00000000000" disabled="disabled" id="tel_hR" required>
              </div>
              <div class="form-group col-md-5  {{ $errors->has('LugarTrabajoRepresentante') ? 'has-error' : '' }}">
                <label for="LugarTrabajoRepresentante">Lugar de Trabajo:</label>
                <input type="text" name="LugarTrabajoRepresentante" class="form-control" placeholder="Lugar de Trabajo" disabled="disabled" id="ltR" required>
              </div>
              <div class="form-group col-md-5  {{ $errors->has('DireccionTrabjoRepresentante') ? 'has-error' : '' }}">
                <label for="DireccionTrabjoRepresentante">Direccion de Trabajo:</label>
                <input type="text" name="DireccionTrabjoRepresentante" class="form-control" placeholder="Direccion de Trabajo" disabled="disabled" id="dirtR" required>
              </div>
              <div class="form-group col-md-2  {{ $errors->has('TelefonoTrabajoRepresentante') ? 'has-error' : '' }}">
                <label for="TelefonoTrabajoRepresentante">Tlf. de Trabajo:</label>
                <input type="tel" name="TelefonoTrabajoRepresentante" class="form-control" placeholder="00000000000" disabled="disabled" id="tlf_tR" required>
              </div>
              <div class="form-group col-md-4  {{ $errors->has('ProfecionRepresentante') ? 'has-error' : '' }}">
                <label for="ProfecionRepresentante">Profesion:</label>
                <input type="text" name="ProfecionRepresentante" class="form-control" placeholder="Profesion" disabled="disabled" id="prfR" required>
              </div>
              <div class="form-group col-md-4  {{ $errors->has('EmailRepresentante') ? 'has-error' : '' }}">
                <label for="EmailRepresentante">E-Mail:</label>
                <input type="email" name="EmailRepresentante" class="form-control" placeholder="example@mail.com" disabled="disabled" id="emailR" required>
              </div>
              <div class="form-group col-md-4  {{ $errors->has('ParentescoRepresentante') ? 'has-error' : '' }}">
                <label for="ParentescoRepresentante">Parentesco</label>
                <input type="text" name="ParentescoRepresentante" class="form-control" placeholder="Parentesco" disabled="disabled" id="parentR" required>
              </div>
            </div><!--Fin row-->
          </div><!--Fin panel body-->
        </div><!--Fin panel primary-->
        <!--Datos de emergencia-->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos de Emergencia</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4  {{ $errors->has('NombreEmergencia') ? 'has-error' : '' }}">
                <label for="NombreEmergencia">En Caso de Emergencia Llamar:</label>
                <input type="text" name="NombreEmergencia" class="form-control" placeholder="Nombre" disabled="disabled" id="nomE" required>
              </div>
              <div class="form-group col-md-4  {{ $errors->has('TelefonoEmergencia') ? 'has-error' : '' }}">
                <label for="TelefonoEmergencia">Telefono:</label>
                <input type="tel" name="TelefonoEmergencia" class="form-control" placeholder="00000000000" disabled="disabled" id="tlmE" required>
              </div>
              <div class="form-group col-md-4  {{ $errors->has('GradoFamiliarEmergencia') ? 'has-error' : '' }}">
                <label for="GradoFamiliarEmergencia">Grado Familiar</label>
                <input type="text" name="GradoFamiliarEmergencia" class="form-control" placeholder="Familiar" disabled="disabled" id="gfamE" required>
              </div>
              <div class="form-group col-md-4  {{ $errors->has('ViveConEmergencia') ? 'has-error' : '' }}">
                <label for="ViveConEmergencia">Vive Con:</label>
                <select class="form-control" name="ViveConEmergencia" disabled="disabled" id="vc">
                  <option value=""disabled selected>Seleccione una opcion</option>
                  <option value="1">Papa</option>
                  <option value="2">Mama</option>
                  <option value="3">Otro</option>
                </select>
              </div>
              <div class="form-group col-md-4  {{ $errors->has('TransporteEmergencia') ? 'has-error' : '' }}">
                <label for="TransporteEmergencia">Medio de Transporte</label>
                <select class="form-control" name="TransporteEmergencia" disabled="disabled" id="trans">
                  <option value=""disabled selected>Seleccione una opcion</option>
                  <option value="1">Particular</option>
                  <option value="2">Transporte Publico</option>
                </select>
              </div>
              <div class="form-group col-md-4  {{ $errors->has('NombreViveEmergencia') ? 'has-error' : '' }}">
                <label for="NombreViveEmergencia">Nombre con quien vive</label>
                <input type="text" name="NombreViveEmergencia" class="form-control" placeholder="Nombre" disabled="disabled" id="nombV">
              </div>
            </div><!--Fin row-->
          </div><!--Fin panel body-->
        </div><!--Fin panel primary-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Inscribir</h3>
        </div>
        <div class="box-body">
          <div class="form-group {{ $errors->has('Grado') ? 'has-error' : '' }}">
            <label for="Grado">Grado ha cursar:</label>
            <select class="form-control" name="Grado" id="grado" disabled="disabled" required>
              <option value="" disabled selected >Seleccione año escolar</option>
              @php
                $sec = $secciones[0]->codsec;
              @endphp
              @if ($secciones[0]->codsec[0] == "M")
                <option value="{{$sec}}">PRE-ESCOLAR SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[0] == "P" && $secciones[0]->codsec[1] == "1")
                <option value="{{$sec}}">PRIMER GRADO SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[0] == "P" && $secciones[0]->codsec[1] == "2")
                <option value="{{$sec}}">SEGUNDO GRADO SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[0] == "P" && $secciones[0]->codsec[1] == "3")
                <option value="{{$sec}}">TERCER GRADO SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[0] == "P" && $secciones[0]->codsec[1] == "4")
                <option value="{{$sec}}">CUARTO GRADO SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[0] == "P" && $secciones[0]->codsec[1] == "5")
                <option value="{{$sec}}">QUINTO GRADO SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[0] == "P" && $secciones[0]->codsec[1] == "6")
                <option value="{{$sec}}">SEXTO GRADO SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[1] == "1")
                <option value="{{$sec}}">PRIMER AÑO SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[1] == "2")
                <option value="{{$sec}}">SEGUNDO AÑO SECCION {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[1] == "3")
                <option value="{{$sec}}">TERCER AÑO {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[1] == "4")
                <option value="{{$sec}}">CUARTO AÑO {{$secciones[0]->codsec[3]}}</option>
              @elseif ($secciones[0]->codsec[1] == "5")
                <option value="{{$sec}}">QUINTO AÑO {{$secciones[0]->codsec[3]}}</option>
              @endif
              @for ($i=1; $i <sizeof($secciones) ; $i++)
                @if (strnatcasecmp( $secciones[$i]->codsec,$sec) != 0)
                  @if ($secciones[$i]->codsec[0] == "M")
                    <option value="{{$secciones[$i]->codsec}}">PRE-ESCOLAR SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[0] == "P" && $secciones[$i]->codsec[1] == "1")
                    <option value="{{$secciones[$i]->codsec}}">PRIMER GRADO SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[0] == "P" && $secciones[$i]->codsec[1] == "2")
                    <option value="{{$secciones[$i]->codsec}}">SEGUNDO GRADO SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[0] == "P" && $secciones[$i]->codsec[1] == "3")
                    <option value="{{$secciones[$i]->codsec}}">TERCER GRADO SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[0] == "P" && $secciones[$i]->codsec[1] == "4")
                    <option value="{{$secciones[$i]->codsec}}">CUARTO GRADO SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[0] == "P" && $secciones[$i]->codsec[1] == "5")
                    <option value="{{$secciones[$i]->codsec}}">QUINTO GRADO SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[0] == "P" && $secciones[$i]->codsec[1] == "6")
                    <option value="{{$secciones[$i]->codsec}}">SEXTO GRADO SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[1] == "1")
                    <option value="{{$secciones[$i]->codsec}}">PRIMER AÑO SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[1] == "2")
                    <option value="{{$secciones[$i]->codsec}}">SEGUNDO AÑO SECCION {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[1] == "3")
                    <option value="{{$secciones[$i]->codsec}}">TERCER AÑO {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[1] == "4")
                    <option value="{{$secciones[$i]->codsec}}">CUARTO AÑO {{$secciones[$i]->codsec[3]}}</option>
                  @elseif ($secciones[$i]->codsec[1] == "5")
                    <option value="{{$secciones[$i]->codsec}}">QUINTO AÑO {{$secciones[$i]->codsec[3]}}</option>
                  @endif
                  @php
                    $sec = $secciones[$i]->codsec;
                  @endphp
                @endif
              @endfor
            </select>
            <div id="mate_ins" style="display:none">
              <div class="box-header">
                <h3 class="box-title">Materias Inscritas</h3>
              </div>
              <div class="box-body no-padding">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Materia</th>
                      <th>Año</th>
                      <th>Seccion</th>
                      <th>Condicion</th>
                    </tr>
                  </thead>
                  <tbody id="tbody">
                  </tbody>
                </table>
              </div>
            </div>
          </div><!--Fin from group-->
      </div><!--Fin panel body-->
    </div><!--Fin panel primary-->
    <div class="form-group">
      <button class="btn btn-success" type="submit" id="guardar" disabled=disabled><i class="fa  fa-pencil"></i> Inscribir</button>
      <button class="btn btn-info" type="button" id="imprimir" onclick="pdf();"  disabled=disabled><i class="fa fa-print"></i> Imprimir</button>
    </div>
    </form>
  </div><!--Fin car-->
@endsection

@section('js')
  <script src="{{ asset('adminlte/plugins/jspdf/jspdf.debug.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jspdf/faker.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jspdf/jspdf.plugin.autotable.js') }}"></script>
  <script type="text/javascript">

  var doc = new jsPDF('p', 'pt', 'letter');
  var logo = new Image();
  window.onload=function() {
    logo.src = "{{ asset('img/logo.png') }}";
  }
  function encabezado(){
    doc = new jsPDF('p', 'pt', 'letter');
    doc.addImage(logo, 'png', 20, 20,100,100);

    doc.setFontSize(8);

    text = "Unidad Educativa Colegio";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 40, text);

    doc.setFontType("bold");
    text = "{{$colegio[0]->nombre}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 50, text);

    doc.setFontType("default");
    text = "CODIGO PLANTEL {{$colegio[0]->codigodea}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 60, text);

    text = "{{$colegio[0]->direccion}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 70, text);

    text = "{{$colegio[0]->telefono}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 80, text);

    text = "{{$colegio[0]->localidad}} Edo. {{$colegio[0]->zonaeducativa}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 90, text);

    text = "{{$colegio[0]->convenioavec}}";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 100, text);

    texto1 = "Fecha: ";
    var texto2 = "{{$fecha_pdf}}";
    var text = texto1+texto2;
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) -20;
    doc.text(textOffset, 40, text);

    texto1 = "Año Escolar: ";
    var texto2 = "{{$filtros[0]->codlapso}}";
    var text = texto1+texto2;
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) -20;
    doc.text(textOffset, 50, text);

    size =15;
    doc.setFontSize(size);
    text = "PLANILLA DE INSCRIPCIÓN";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 180, text);

    doc.line(20, 190, (doc.internal.pageSize.width - 20), 190); // horizontal line

    size =10;
    doc.setFontSize(size);

    texto1 = "Inscrito en: ";
    var com = ""+document.getElementById('ids2').value;
    if (""+com[0]+com[1] == "M3") {
      texto2 = "Pre-Escolar seccion "+com[3];
    }
    if (""+com[0]+com[1] == "P1") {
      texto2 = "Primer Grado seccion "+com[3];
    }
    if (""+com[0]+com[1] == "P2") {
      texto2 = "Segundo Grado seccion "+com[3];
    }
    if (""+com[0]+com[1] == "P3") {
      texto2 = "Tercer Grado seccion "+com[3];
    }
    if (""+com[0]+com[1] == "P4") {
      texto2 = "Cuarto Grado seccion "+com[3];
    }
    if (""+com[0]+com[1] == "P5") {
      texto2 = "Quinto Grado seccion "+com[3];
    }
    if (""+com[0]+com[1] == "P6") {
      texto2 = "Sexto Grado seccion "+com[3];
    }
    if (""+com[0]+com[1] == "01") {
      texto2 = "Primer Año seccion"+com[3];
    }
    if (""+com[0]+com[1] == "02") {
      texto2 = "Segundo Año seccion "+com[3];
    }
    if (""+com[0]+com[1] == "03") {
      texto2 = "Tercer Año seccion "+com[3];
    }
    if (""+com[0]+com[1] == "D4") {
      texto2 = "Cuarto Año seccion "+com[3];
    }
    if (""+com[0]+com[1] == "D5") {
      texto2 = "Quinto Año seccion "+com[3];
    }
    var text = texto1+texto2;
    doc.text(20, 210, text);

    texto1 = "Tipo de Ingreso: ";
    var com = ""+document.getElementById('ids').value;
    if (com == "N") {
      var texto2 = "Nuevo";
    }
    if (com == "RG") {
      var texto2 = "Regular";
    }

    var text = texto1+texto2;
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 210, text);

    doc.line(20, 220, (doc.internal.pageSize.width - 20), 220); // horizontal line

    size =12;
    doc.setFontSize(size);
    text = "DATOS DEL ESTUDIANTE";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 240, text);

    size =10;
    doc.setFontSize(size);

    texto1 = "Apellidos y Nombres: ";
    var texto2 = document.getElementById("apellidosE").value+", "+document.getElementById("nombresE").value;
    var text = texto1+texto2;
    doc.text(20, 255, text);

    texto1 = "Sexo: ";
    combo =document.getElementById("sexo");
    var texto2 = ""+combo.options[combo.selectedIndex].text;
    var text = texto1+texto2;
    doc.text(400, 255, text);

    texto1 = "C.I./Ced. Escolar: ";
    var texto2 = document.getElementById("nacE").value+"-"+document.getElementById("cedulaE").value;
    var text = texto1+texto2;
    doc.text(20, 270, text);

    texto1 = "Estado Civil: ";
    combo = document.getElementById("est_cil");
    var texto2 = ""+combo.options[combo.selectedIndex].text;
    var text = texto1+texto2;
    doc.text(400, 270, text);

    texto1 = "Lugar de Nacimiento: ";
    var texto2 = ""+document.getElementById("lug_nacE").value;
    var text = texto1+texto2;
    doc.text(20, 285, text);

    texto1 = "Tipo de parto: ";
    combo = document.getElementById("tipo_part");
    var texto2 = ""+combo.options[combo.selectedIndex].text;
    var text = texto1+texto2;
    doc.text(400, 285, text);

    texto1 = "Fecha de Nacimiento: ";
    var texto2 =""+document.getElementById("fec_nacE").value;
    var text = texto1+texto2;
    doc.text(20, 300, text);

    texto1 = "Pais: ";
    combo = document.getElementById("pais");
    var texto2 = ""+combo.options[combo.selectedIndex].text;
    var text = texto1+texto2;
    doc.text(400, 300, text);

    texto1 = "Dirección: ";
    var texto2 = ""+document.getElementById("direcR").value;
    var text = texto1+texto2;
    doc.text(20, 315, text);

    texto1 = "Estado: ";
    combo = document.getElementById("estado");
    var texto2 = ""+combo.options[combo.selectedIndex].text;
    var text = texto1+texto2;
    doc.text(400, 315, text);

    texto1 = "Teléfono Habitación: ";
    var texto2 = document.getElementById("tel_hR").value+"";
    var text = texto1+texto2;
    doc.text(20, 330, text);

    texto1 = "Correo: ";
    var texto2 = ""+document.getElementById("emailE").value;
    var text = texto1+texto2;
    doc.text(400, 330, text);

    doc.line(20, 350, (doc.internal.pageSize.width - 20), 350); // horizontal line

    size =12;
    doc.setFontSize(size);
    text = "DATOS DE LA MADRE";
    doc.text(20, 370, text);

    text = "DATOS DEL PADRE";
    doc.text(400, 370, text);

    size =10;
    doc.setFontSize(size);

    texto1 = "Apellidos y Nombres: ";
    var texto2 = ""+document.getElementById("nombM").value;
    var text = texto1+texto2;
    doc.text(20, 385, text);

    texto1 = "Apellidos y Nombres: ";
    var texto2 = ""+document.getElementById("nombp").value;
    var texto2 = ""+combo.options[combo.selectedIndex].text;
    var text = texto1+texto2;
    doc.text(400, 385, text);

    texto1 = "C.I. : ";
    var texto2 = document.getElementById("nacM").value+"-"+document.getElementById("ced_m").value;
    var text = texto1+texto2;
    doc.text(20, 400, text);

    texto1 = "C.I. : ";
    var texto2 = document.getElementById("nacp").value+"-"+document.getElementById("ced_p").value;
    var text = texto1+texto2;
    doc.text(400, 400, text);

    texto1 = "Ocupación: ";
    var texto2 = ""+document.getElementById("prfM").value;
    var text = texto1+texto2;
    doc.text(20, 415, text);

    texto1 = "Ocupación: ";
    var texto2 = ""+document.getElementById("prfp").value;
    var text = texto1+texto2;
    doc.text(400, 415, text);

    texto1 = "Dirección: ";
    var texto2 =""+document.getElementById("direcM").value;
    var text = texto1+texto2;
    doc.text(20, 430, text);

    texto1 = "Dirección: ";
    var texto2 =""+document.getElementById("direcp").value;
    var text = texto1+texto2;
    doc.text(400, 430, text);

    texto1 = "Teléfono Habitación: ";
    var texto2 = ""+document.getElementById("tel_hM").value;
    var text = texto1+texto2;
    doc.text(20, 445, text);

    texto1 = "Teléfono Habitación:: ";
    var texto2 = ""+document.getElementById("tel_hp").value;
    var text = texto1+texto2;
    doc.text(400, 445, text);

    texto1 = "Teléfono Trabajo: ";
    var texto2 = document.getElementById("tlf_tM").value+"";
    var text = texto1+texto2;
    doc.text(20, 460, text);

    texto1 = "Teléfono Trabajo: ";
    var texto2 = ""+document.getElementById("tlf_tp").value;
    var text = texto1+texto2;
    doc.text(400, 460, text);

    doc.line(20, 475, (doc.internal.pageSize.width - 20), 475); // horizontal line

    size =12;
    doc.setFontSize(size);
    text = "DATOS DEL REPRESENTANTE LEGAL";
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, 490, text);

    size =10;
    doc.setFontSize(size);

    texto1 = "Apellidos y Nombres: ";
    var texto2 = ""+document.getElementById("nombR").value;
    var text = texto1+texto2;
    doc.text(20, 510, text);

    texto1 = "Parentesco: ";
    var texto2 = ""+document.getElementById("parentR").value;
    var text = texto1+texto2;
    doc.text(400, 510, text);

    texto1 = "C.I. : ";
    var texto2 = document.getElementById("nacR").value+"-"+document.getElementById("ced_R").value;
    var text = texto1+texto2;
    doc.text(20, 525, text);

    texto1 = "Teléfono Habitación:: ";
    var texto2 = document.getElementById("nacE").value+"-"+document.getElementById("tel_hR").value;
    var text = texto1+texto2;
    doc.text(400, 525, text);

    texto1 = "Ocupación: ";
    var texto2 = ""+document.getElementById("prfR").value;
    var text = texto1+texto2;
    doc.text(20, 540, text);

    texto1 = "Teléfono Trabajo: ";
    var texto2 = ""+document.getElementById("tlf_tR").value;
    var text = texto1+texto2;
    doc.text(400, 540, text);

    doc.line(20, 550, (doc.internal.pageSize.width - 20), 550); // horizontal line

    texto1 = "En caso de emergencia llamar a: ";
    var texto2 = ""+document.getElementById("nomE").value;
    var text = texto1+texto2;
    doc.text(20, 570, text);

    texto1 = "Telefono: ";
    var texto2 = ""+document.getElementById("tlmE").value;
    var text = texto1+texto2;
    doc.text(400, 570, text);

    texto1 = "Grado Familiar: ";
    var texto2 = ""+document.getElementById("gfamE").value;
    var text = texto1+texto2;
    doc.text(20, 585, text);

    texto1 = "Vive Con: ";
    combo =document.getElementById("vc");
    var texto2 = ""+combo.options[combo.selectedIndex].text;
    var text = texto1+texto2;
    doc.text(400, 585, text);

    texto1 = "Medio de Transporte: ";
    combo =document.getElementById("trans");
    var texto2 = ""+combo.options[combo.selectedIndex].text;
    var text = texto1+texto2;
    doc.text(20, 600, text);

    texto1 = "Nombre con quien vive: ";
    var texto2 = ""+document.getElementById("nombV").value;
    var text = texto1+texto2;
    doc.text(400, 600, text);

    doc.line(20, 620, (doc.internal.pageSize.width - 20), 620); // horizontal line

    doc.line(100, 660, 200, 660); // horizontal line
    text = "Colegio";
    doc.text(135, 680, text);

    doc.line(400, 660, 500, 660); // horizontal line
    text = "Representante";
    doc.text(425, 680, text);





  }
  function pdf() {
        encabezado();
        doc.save('PLANILLA.pdf');
      }
  //Datos estudiante
    $('#cedulaE').select2();;
    $('.datepicker').datepicker({
      autoclose: true
    })
      var band = "{{$band}}"
    $('#cedulaE').change(function(event){
      $.get("actualizardatos/table/"+event.target.value+"",function(response,state){
        //Quitando los disabled a los input
        if (response.inscri != null) {
          var bajar = response.inscri[0].insc_status;
          var inscri = response.inscri[0].insc_bajar;
        }else {
          var bajar = 0;
          var inscri = 0;
        }
        if (inscri == 0) {
          document.getElementById("inscrito").setAttribute('style', 'display:none');
          document.getElementById("imprimir").setAttribute('disabled', 'disabled');
        }else {
          document.getElementById("inscrito").removeAttribute('style');
          document.getElementById("imprimir").removeAttribute('disabled');
        }
        if (bajar == 0) {
          document.getElementById("bajado").setAttribute('style', 'display:none');
        }
        if (bajar == 0 && band) {
          //Datos del estudiante
          document.getElementById("fec_nacE").removeAttribute('disabled');
          document.getElementById("pais").removeAttribute('disabled');
          document.getElementById("estado").removeAttribute('disabled');
          document.getElementById("emailE").removeAttribute('disabled');
          //Datos Madre
          if (response.madre == null) {
            document.getElementById("ced_m").removeAttribute('disabled');
            document.getElementById("nacM").removeAttribute('disabled');
          }
          document.getElementById("nombM").removeAttribute('disabled');
          document.getElementById("direcM").removeAttribute('disabled');
          document.getElementById("tel_cM").removeAttribute('disabled');
          document.getElementById("tel_hM").removeAttribute('disabled');
          document.getElementById("ltM").removeAttribute('disabled');
          document.getElementById("dirtM").removeAttribute('disabled');
          document.getElementById("tlf_tM").removeAttribute('disabled');
          document.getElementById("prfM").removeAttribute('disabled');
          document.getElementById("emailM").removeAttribute('disabled');
          //Datos Padre
          if (response.padre == null) {
            document.getElementById("ced_p").removeAttribute('disabled');
            document.getElementById("nacp").removeAttribute('disabled');
          }
          document.getElementById("nombp").removeAttribute('disabled');
          document.getElementById("direcp").removeAttribute('disabled');
          document.getElementById("tel_cp").removeAttribute('disabled');
          document.getElementById("tel_hp").removeAttribute('disabled');
          document.getElementById("ltp").removeAttribute('disabled');
          document.getElementById("dirtp").removeAttribute('disabled');
          document.getElementById("tlf_tp").removeAttribute('disabled');
          document.getElementById("prfp").removeAttribute('disabled');
          document.getElementById("emailp").removeAttribute('disabled');
          //Datos del representante
          if (response.repre == null) {
            document.getElementById("ced_R").removeAttribute('disabled');
            document.getElementById("nacR").removeAttribute('disabled');
          }
          document.getElementById("nombR").removeAttribute('disabled');
          document.getElementById("direcR").removeAttribute('disabled');
          document.getElementById("tel_cR").removeAttribute('disabled');
          document.getElementById("tel_hR").removeAttribute('disabled');
          document.getElementById("ltR").removeAttribute('disabled');
          document.getElementById("dirtR").removeAttribute('disabled');
          document.getElementById("tlf_tR").removeAttribute('disabled');
          document.getElementById("prfR").removeAttribute('disabled');
          document.getElementById("emailR").removeAttribute('disabled');
          document.getElementById("parentR").removeAttribute('disabled');
          //Datos de Emergencia
          document.getElementById("nomE").removeAttribute('disabled');
          document.getElementById("tlmE").removeAttribute('disabled');
          document.getElementById("gfamE").removeAttribute('disabled');
          document.getElementById("vc").removeAttribute('disabled');
          document.getElementById("trans").removeAttribute('disabled');
          document.getElementById("nombV").removeAttribute('disabled');
          //Guardar
          document.getElementById("guardar").removeAttribute('disabled');
        }else if(response.inscri[0].insc_status == 1){
          document.getElementById("bajado").removeAttribute('style');
          //Datos de estudiante
          document.getElementById("nombresE").setAttribute('disabled', 'disabled');
          document.getElementById("nacE").setAttribute('disabled', 'disabled');
          document.getElementById("apellidosE").setAttribute('disabled', 'disabled');
          document.getElementById("fec_nacE").setAttribute('disabled', 'disabled');
          document.getElementById("plante_proc").setAttribute('disabled', 'disabled');
          document.getElementById("lug_nacE").setAttribute('disabled', 'disabled');
          document.getElementById("pais").setAttribute('disabled', 'disabled');
          document.getElementById("estado").setAttribute('disabled', 'disabled');
          document.getElementById("est_cil").setAttribute('disabled', 'disabled');
          document.getElementById("sexo").setAttribute('disabled', 'disabled');
          document.getElementById("tipo_part").setAttribute('disabled', 'disabled');
          document.getElementById("emailE").setAttribute('disabled', 'disabled');
          //Datos Madre
          document.getElementById("ced_m").setAttribute('disabled', 'disabled');
          document.getElementById("nacM").setAttribute('disabled', 'disabled');
          document.getElementById("nombM").setAttribute('disabled', 'disabled');
          document.getElementById("direcM").setAttribute('disabled', 'disabled');
          document.getElementById("tel_cM").setAttribute('disabled', 'disabled');
          document.getElementById("tel_hM").setAttribute('disabled', 'disabled');
          document.getElementById("ltM").setAttribute('disabled', 'disabled');
          document.getElementById("dirtM").setAttribute('disabled', 'disabled');
          document.getElementById("tlf_tM").setAttribute('disabled', 'disabled');
          document.getElementById("prfM").setAttribute('disabled', 'disabled');
          document.getElementById("emailM").setAttribute('disabled', 'disabled');
          //Datos Padre
          document.getElementById("ced_p").setAttribute('disabled', 'disabled');
          document.getElementById("nacp").setAttribute('disabled', 'disabled');
          document.getElementById("nombp").setAttribute('disabled', 'disabled');
          document.getElementById("direcp").setAttribute('disabled', 'disabled');
          document.getElementById("tel_cp").setAttribute('disabled', 'disabled');
          document.getElementById("tel_hp").setAttribute('disabled', 'disabled');
          document.getElementById("ltp").setAttribute('disabled', 'disabled');
          document.getElementById("dirtp").setAttribute('disabled', 'disabled');
          document.getElementById("tlf_tp").setAttribute('disabled', 'disabled');
          document.getElementById("prfp").setAttribute('disabled', 'disabled');
          document.getElementById("emailp").setAttribute('disabled', 'disabled');
          //Datos del representante
          document.getElementById("ced_R").setAttribute('disabled', 'disabled');
          document.getElementById("nacR").setAttribute('disabled', 'disabled');
          document.getElementById("nombR").setAttribute('disabled', 'disabled');
          document.getElementById("direcR").setAttribute('disabled', 'disabled');
          document.getElementById("tel_cR").setAttribute('disabled', 'disabled');
          document.getElementById("tel_hR").setAttribute('disabled', 'disabled');
          document.getElementById("ltR").setAttribute('disabled', 'disabled');
          document.getElementById("dirtR").setAttribute('disabled', 'disabled');
          document.getElementById("tlf_tR").setAttribute('disabled', 'disabled');
          document.getElementById("prfR").setAttribute('disabled', 'disabled');
          document.getElementById("emailR").setAttribute('disabled', 'disabled');
          document.getElementById("parentR").setAttribute('disabled', 'disabled');
          //Datos de emergencia
          document.getElementById("nomE").setAttribute('disabled', 'disabled');
          document.getElementById("tlmE").setAttribute('disabled', 'disabled');
          document.getElementById("gfamE").setAttribute('disabled', 'disabled');
          document.getElementById("vc").setAttribute('disabled', 'disabled');
          document.getElementById("trans").setAttribute('disabled', 'disabled');
          document.getElementById("nombV").setAttribute('disabled', 'disabled');
          //Guardar
          document.getElementById("guardar").setAttribute('disabled', 'disabled');
        }

        //Datos del estudiante
        document.getElementById("nombresE").value = response.estudiante[0].est_nombres;
        for (var i = 0; i < (document.getElementById("nacE")).length; i++) {
          if (response.estudiante[0].est_nacionalidad == document.getElementById("nacE")[i].value) {
            (document.getElementById("nacE")[i]).setAttribute('selected', 'selected');
          }
        }
        if (response.inscri != null) {
          document.getElementById("ids").value = response.inscri[0].insc_tipo;
        }
        if (response.seccion != null) {
          document.getElementById("ids2").value = ""+response.seccion;
        }

        document.getElementById("apellidosE").value = response.estudiante[0].est_apellidos;
        document.getElementById("fec_nacE").value = response.estudiante[0].est_fecnac;
        document.getElementById("plante_proc").value = response.estudiante[0].nombre;
        document.getElementById("lug_nacE").value = response.estudiante[0].est_lugnac;
        for (var i = 0; i < (document.getElementById("pais")).length; i++) {
          if (response.estudiante[0].est_codpais == document.getElementById("pais")[i].value) {
            document.getElementById("pais")[i].setAttribute('selected', 'selected');
          }
        }
        $('#pais').select2();
        for (var i = 0; i < document.getElementById("estado").length; i++) {
          if (response.estudiante[0].est_estnac == document.getElementById("estado")[i].value) {
            document.getElementById("estado")[i].setAttribute('selected', 'selected');
          }
        }
        $('#estado').select2();
        for (var i = 0; i < document.getElementById("est_cil").length; i++) {
          if (response.estudiante[0].est_edocivil == document.getElementById("est_cil")[i].value) {
            document.getElementById("est_cil")[i].setAttribute('selected', 'selected');
          }
        }
        for (var i = 0; i < document.getElementById("sexo").length; i++) {
          if (response.estudiante[0].est_sexo == document.getElementById("sexo")[i].value) {
            document.getElementById("sexo")[i].setAttribute('selected', 'selected');
          }
        }
        for (var i = 0; i < document.getElementById("tipo_part").length; i++) {
          if (response.estudiante[0].est_tipoparto == document.getElementById("tipo_part")[i].value) {
            document.getElementById("tipo_part")[i].setAttribute('selected', 'selected');
          }
        }
        document.getElementById("emailE").value = response.estudiante[0].est_email;

        //Datos Madre
        if(response.madre != null){
          document.getElementById("ced_m").value = response.madre[0].rep_ced;
          for (var i = 0; i < document.getElementById("nacM").length; i++) {
            if (response.madre[0].rep_nac == document.getElementById("nacM")[i].value) {
              document.getElementById("nacM")[i].setAttribute('selected', 'selected');
            }
          }
          document.getElementById("nombM").value = response.madre[0].rep_nomrep;
          document.getElementById("direcM").value = response.madre[0].rep_dirhabrep;
          document.getElementById("tel_cM").value = response.madre[0].rep_telcel;
          document.getElementById("tel_hM").value = response.madre[0].rep_telhabrep;
          document.getElementById("ltM").value = response.madre[0].rep_lugtrarep;
          document.getElementById("dirtM").value = response.madre[0].rep_dirtrarep;
          document.getElementById("tlf_tM").value = response.madre[0].rep_teltrarep;
          document.getElementById("prfM").value = response.madre[0].rep_profrep;
          document.getElementById("emailM").value = response.madre[0].rep_email;
        }

        //Datos Padre
        if(response.padre != null){
          document.getElementById("ced_p").value = response.padre[0].rep_ced;
          for (var i = 0; i < document.getElementById("nacp").length; i++) {
            if (response.padre[0].rep_nac == document.getElementById("nacp")[i].value) {
              document.getElementById("nacp")[i].setAttribute('selected', 'selected');
            }
          }
          document.getElementById("nombp").value = response.padre[0].rep_nomrep;
          document.getElementById("direcp").value = response.padre[0].rep_dirhabrep;
          document.getElementById("tel_cp").value = response.padre[0].rep_telcel;
          document.getElementById("tel_hp").value = response.padre[0].rep_telhabrep;
          document.getElementById("ltp").value = response.padre[0].rep_lugtrarep;
          document.getElementById("dirtp").value = response.padre[0].rep_dirtrarep;
          document.getElementById("tlf_tp").value = response.padre[0].rep_teltrarep;
          document.getElementById("prfp").value = response.padre[0].rep_profrep;
          document.getElementById("emailp").value = response.padre[0].rep_email;
        }

          //Datos del representantes
          if(response.repre != null){
            document.getElementById("ced_R").value = response.repre[0].rep_ced;
            for (var i = 0; i < document.getElementById("nacR").length; i++) {
              if (response.repre[0].rep_nac == document.getElementById("nacR")[i].value) {
                document.getElementById("nacR")[i].setAttribute('selected', 'selected');
              }
            }
            document.getElementById("nombR").value = response.repre[0].rep_nomrep;
            document.getElementById("direcR").value = response.repre[0].rep_dirhabrep;
            document.getElementById("tel_cR").value = response.repre[0].rep_telcel;
            document.getElementById("tel_hR").value = response.repre[0].rep_telhabrep;
            document.getElementById("ltR").value = response.repre[0].rep_lugtrarep;
            document.getElementById("dirtR").value = response.repre[0].rep_dirtrarep;
            document.getElementById("tlf_tR").value = response.repre[0].rep_teltrarep;
            document.getElementById("prfR").value = response.repre[0].rep_profrep;
            document.getElementById("emailR").value = response.repre[0].rep_email;
            document.getElementById("parentR").value = response.repre[0].rep_parentesco;
          }

          //Datos en caso de Emergencia
          document.getElementById("nomE").value = response.estudiante[0].est_callemer;
          document.getElementById("tlmE").value = response.estudiante[0].est_telfemer;
          document.getElementById("gfamE").value = response.estudiante[0].est_grafam;
          for (var i = 0; i < document.getElementById("vc").length; i++) {
            if(response.estudiante[0].est_vivecon == document.getElementById("vc")[i].value){
              document.getElementById("vc")[i].setAttribute('selected', 'selected');
            }
          }
          for (var i = 0; i < document.getElementById("trans").length; i++) {
            if (response.estudiante[0].est_medtras == document.getElementById("trans")[i].value) {
              document.getElementById("trans")[i].setAttribute('selected', 'selected');
            }
          }
          document.getElementById("nombV").value = response.estudiante[0].rep_vivecondes;

          if ((response.oferta.length) == 0 && {{Auth::user()->tipo_id}} == 3) {
            document.getElementById("grado").removeAttribute('disabled');
            document.getElementById("mate_ins").setAttribute('style', 'display:none');
          }
          else if(response.oferta.length > 0){
            document.getElementById("grado").setAttribute('disabled', 'disabled');
            for (var i = 0; i < document.getElementById("grado").length; i++) {
              document.getElementById("grado")[i].removeAttribute('selected');
            }
            var aux = response.oferta[0].ofac_seccion;
            for (var i = 0; i < document.getElementById("grado").length; i++) {
              if (document.getElementById("grado")[i].value == aux) {
                document.getElementById("grado")[i].setAttribute('selected', 'selected');
              }
            }
            document.getElementById("mate_ins").removeAttribute('style');
            var tb = document.getElementById('tbody');
            tb.innerHTML = "";
            for (var i = 0; i < response.oferta.length; i++) {
              if(response.oferta[i].tipo != 1){
                var tr = document.createElement("tr");
                var tdm = document.createElement("td");
                var tda = document.createElement("td");
                var tds = document.createElement("td");
                var tdc = document.createElement("td");
                aux = response.oferta[i].ofac_seccion.split("");
                tdm.innerHTML = response.oferta[i].des;
                tda.innerHTML = aux[1];
                tds.innerHTML = aux[3];
                tdc.innerHTML = response.oferta[i].ofac_condalum;
                tr.appendChild(tdm);
                tr.appendChild(tda);
                tr.appendChild(tds);
                tr.appendChild(tdc);
                tb.appendChild(tr);
              }
            }
          }
          else if (response.oferta.length == 0 && response.sinfoerta.length > 0) {
            document.getElementById("grado").setAttribute('disabled', 'disabled');
            for (var i = 0; i < document.getElementById("grado").length; i++) {
              document.getElementById("grado")[i].removeAttribute('selected');
            }
            var aux = response.sinfoerta[0].cod_sec;
            for (var i = 0; i < document.getElementById("grado").length; i++) {
              if (document.getElementById("grado")[i].value == aux) {
                document.getElementById("grado")[i].setAttribute('selected', 'selected');
              }
            }
            var tb = document.getElementById('tbody');
            tb.innerHTML = "";
            for (var i = 0; i < response.sinfoerta.length; i++) {
              if(response.sinfoerta[i].tipo != 1){
                var tr = document.createElement("tr");
                var tdm = document.createElement("td");
                var tda = document.createElement("td");
                var tds = document.createElement("td");
                var tdc = document.createElement("td");
                aux = response.sinfoerta[i].cod_sec.split("");
                tdm.innerHTML = response.sinfoerta[i].des;
                tda.innerHTML = aux[1];
                tds.innerHTML = aux[3];
                tdc.innerHTML = response.sinfoerta[i].cod;
                tr.appendChild(tdm);
                tr.appendChild(tda);
                tr.appendChild(tds);
                tr.appendChild(tdc);
                tb.appendChild(tr);
              }
            }
          }
      });
    });
  </script>
@endsection
