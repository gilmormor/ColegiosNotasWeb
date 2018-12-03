<?php

namespace App\Http\Middleware;

use Closure;
use App\Cod_Filtro;

class Pagos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $filtros = Cod_Filtro::all();
      if (($filtros[0]->depsoftservi == 0 && $filtros[0]->depcolegio == 0 && $filtros[0]->depconpadres == 0) || $filtros[0]->depcolegio == 2) {
         return $next($request);
      }
      else {
        if($request->user()->tipo_id != 6){
             return $next($request);
         }else{
           if ($request->user()->pago == 1) {
             return $next($request);
           }else {
             return redirect()->route('depositos');
           }
         }
      }
    }
}
