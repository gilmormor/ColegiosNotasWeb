<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class menu extends ServiceProvider
{

    public function boot()
    {
      View::composer(['home',
      'user.index',
      'menus.index',
      'menus.iconos',
      'permisos.index',
      'user.profile',
      'evaluaciones.seccion',
      'evaluaciones.planificacion',
      'evaluaciones.planificacion2',
      'evaluaciones.primaria',
      'evaluaciones.notas',
      'evaluaciones.pdf',
      'academicos.asignar',
      'actualizardatos.index',
      'academicos.inscribir',
      'evaluaciones.boletines',
      'evaluaciones.boletines2',
      'academicos.seccion',
      'evaluaciones.seccion2',
      'Inscripciones.deposito',
      'Inscripciones.punto_venta',
      'Inscripciones.datos',
      'reportes.constancias',
      'reportes.reporte',
      'administrativo.editarsof',
      'administrativo.editarcol'
      ],'App\Http\ViewComposers\MenuComposer');
    }

}
