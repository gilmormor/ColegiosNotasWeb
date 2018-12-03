@extends('main')

@section('title')
  {{ $nombrec[0]->nombre }}
@endsection

@section('content')
  <!-- Default box -->
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
  @endphp
  @if (Auth::user()->tipo_id == 6)
    @if ($fecha_a > $fecha_i)
      <div class="callout callout-info">|
        <h4><i class="icon fa fa-info"></i> Importante!</h4>
        El proceso de inscripcion finalizo.
      </div>
    @elseif ($fecha_a == $fecha_i && $hora_a > $hora_i)
      <div class="callout callout-info">
        <h4><i class="icon fa fa-info"></i> Importante!</h4>
        El proceso de inscripcion finalizo.
      </div>
    @else
      <div class="callout callout-info">
        <h4><i class="icon fa fa-info"></i> Importante!</h4>
        El proceso de inscripcion esta disponible.
      </div>
    @endif
  @endif
@endsection
