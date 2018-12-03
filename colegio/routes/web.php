<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' =>['auth', 'pago']],function(){
  Route::get('/c@mbi@rCl@v3', 'UserController@claves');
  //Route::get('/r0l3s', 'UserController@roles');

  Route::get('/', 'HomeController@index');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('home2', 'HomeController@index')->name('home2');

  Route::resource('users','UserController');
  Route::get('users/{id}/destroy',[
    'uses' => 'UserController@destroy',
    'as'   => 'users.destroy'
  ]);

  Route::resource('menus','MenuController');
  Route::get('menus/{id}/destroy',[
    'uses' => 'MenuController@destroy',
    'as'   => 'menus.destroy'
  ]);
  Route::get('iconos',[
    'uses' => 'MenuController@iconos',
    'as'   => 'menus.iconos'
  ]);

  Route::resource('inscribir','InscribirController');

  Route::get('inscribir_seccion','InscribirController@indexS')->name('inscribir.seccion');
  Route::post('inscribir_seccion','InscribirController@seccion')->name('Iseccion.store');

  Route::resource('planificacion','PlanificacionController');
  Route::get('planificacion/tabla/{id}','PlanificacionController@tabla');

  Route::resource('planificacion_primaria','Planificacion2Controller');

  //Notas secundaria por cedula
  Route::get('secundaria/cedula/notas','NotaController@index_Sec')->name('notas.index');
  Route::post('secundaria/cedula/notas','NotaController@store_Sec_C')->name('notas.store');
  Route::get('secundaria/cedula/notas/tabla/{id}','NotaController@tabla_C');

  //Notas secundaria por Nombre
  Route::get('secundaria/nombre/notas','NotaController@index_Sec')->name('notas.nombre.index');
  Route::post('secundaria/nombre/notas','NotaController@store_Sec_N')->name('notas.nombre.store');
  Route::get('secundaria/nombre/notas/tabla/{id}','NotaController@tabla_N');

  //Notas primaria por cedula
  Route::get('primaria/cedula/notas','NotaController@index_Pri')->name('notas.primaria');
  Route::post('primaria/cedula/notas','NotaController@store_Pri_C')->name('notas.primaria.store');
  Route::get('primaria/cedula/notas/tabla/{id}','NotaController@tabla_C');

  Route::get('boletines','NotaController@bole_sec')->name('boletines');
  Route::get('boletines/listar','NotaController@boletines')->name('boletines_listar');

  Route::get('boletines_primaria','NotaController@bole_sec_primaria')->name('boletines_primaria');
  Route::get('boletines_primaria/listar','NotaController@boletines2')->name('boletines_primaria_listar');

  Route::resource('secciones','SeccionController');
  Route::get('secciones/{id}/destroy',[
    'uses' => 'SeccionController@destroy',
    'as'   => 'secciones.destroy'
  ]);

  Route::get('perfil', 'PerfilController@index')->name('perfil');
  Route::put('perfil/{id}', 'PerfilController@update')->name('perfil.update');

  Route::resource('permisos','PermisoController');
  Route::get('permisos/menus/{id}/{tipo}','PermisoController@menus');

  Route::resource('actualizardatos', 'ActualizarDatosController');
  Route::get('actualizardatos/table/{id}', 'ActualizarDatosController@table');

  Route::get('punto_de_venta', 'InscripcionesPuntoVenta@index')->name('puntoventa');
  Route::post('punto_de_venta','InscripcionesPuntoVenta@store')->name('puntoventa.store');

  Route::get('constancias','Constancias@index')->name('constancias');
  Route::get('reporte','ReporteController@index')->name('reporte');

  Route::get('editardepositosof', 'EditarDepositos@index')->name('editarsof');
  Route::get('editardepositosof/table/{id}', 'EditarDepositos@tables');
  Route::post('editardepositosof', 'EditarDepositos@softservi')->name('editardep.softservi');

  Route::get('editardepositocol', 'EditarDepositos@index2')->name('editarcol');
  Route::get('editardepositocol/table/{id}', 'EditarDepositos@tablec');
  Route::post('editardepositocol', 'EditarDepositos@colegio')->name('editardep.colegio');
  });

  Route::group(['middleware' =>['auth']],function(){
    Route::get('deposito', 'InscripcionesDeposito@index')->name('depositos');
    Route::post('depositos', 'InscripcionesDeposito@softservi')->name('softservi');
    Route::post('depositoc', 'InscripcionesDeposito@colegio')->name('colegio');
    Route::post('depositoj', 'InscripcionesDeposito@padres')->name('padres');
    Route::post('deposito', 'InscripcionesDeposito@siguiente')->name('siguiente');
  });

  Route::get('registrar', 'RegistrarController@index')->name('registro');
  Route::post('registrar','RegistrarController@store')->name('registro.store');
  Route::get('registrar/datos/{id}','RegistrarController@datos')->name('registro.datos');

  Auth::routes();
