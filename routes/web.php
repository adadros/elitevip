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
Route::get('/', 'ContentController@home')->name('inicio');
//contacto web page
Route::get('/contacto', 'ContactoController@nuevo')->name('contacto');
Route::post('/contacto/send', 'ContactoController@send')->name('contacto_send');
//colabooradores
Route::get('/colaboradores', 'ColaboradoresController@nuevo')->name('colaboradores');
Route::post('/colaboradores/send', 'ColaboradoresController@send')->name('colaboradores_send');
//bolsatrabajo
Route::get('/bolsatrabajo', 'BolsaController@nuevo')->name('bolsatrabajo');
Route::post('/bolsatrabajo/send', 'BolsaController@send')->name('bolsatrabajo_send');
//proveedores
Route::get('/proveedores', 'ProveedorController@nuevo')->name('proveedores');
Route::post('/proveedores/send', 'ProveedorController@send')->name('proveedores_send');

Route::get('/registro', 'RegisterController@nuevo')->name('registro');
Route::get('/inicia-sesion', 'LoginController@inicio')->name('loguear');
Route::post('/registro/new', 'RegisterController@create_new')->name('nuevo_registro');

Route::get('/perfil', 'ProfileController@view')->name('perfil');
Route::get('/eventos', 'EventoController@view')->name('eventos');
Route::get('/admin','AdminController@panel')->name('admin');

/**usuarios*/
Route::get('/admin/usuarios','AdminController@usuarios')->name('admin_usuarios');
Route::get('/admin/usuario/nuevo','AdminController@newUsuario')->name('admin_usuario_nuevo');
Route::get('/admin/usuario/{id}/editar','AdminController@editUsuario')->name('admin_usuario_editar');
Route::post('/admin/usuario/aprobar','AjaxUserController@aprobar')->name('admin_usuario_aprobar');
Route::post('/admin/usuario/guardar','AjaxUserController@guardar')->name('guardar_usuario');

/**paquetes*/
Route::get('/admin/paquetes','AdminController@paquetes')->name('admin_paquetes');
Route::get('/admin/paquete/nuevo','AdminController@newPaquete')->name('admin_paquete_nuevo');
Route::get('/admin/paquete/{id}/editar','AdminController@editPaquete')->name('admin_paquete_editar');
Route::post('/admin/paquete/guardar','AjaxPaquetesController@guardar')->name('guardar_paquete');
Route::post('/admin/paquete/actualizar','AjaxPaquetesController@actualizar')->name('actualizar_paquete');
Route::post('/admin/paquete/eliminar','AjaxPaquetesController@eliminar')->name('eliminar_paquete');
/**secciones*/
Route::get('/admin/secciones','AdminController@secciones')->name('admin_secciones');
Route::get('/admin/seccion/nuevo','AdminController@newSeccion')->name('admin_seccion_nueva');
Route::get('/admin/seccion/{id}/editar','AdminController@editSeccion')->name('admin_seccion_editar');
Route::post('/admin/seccion/guardar','AjaxSeccionController@guardar')->name('guardar_seccion');
Route::post('/admin/seccion/actualizar','AjaxSeccionController@actualizar')->name('actualizar_seccion');
Route::post('/admin/seccion/eliminar','AjaxSeccionController@eliminar')->name('eliminar_seccion');
/**categorias*/
Route::get('/admin/categorias','AdminController@categorias')->name('admin_categorias');



/**eventos*/
Route::get('/admin/eventos','AdminController@eventos')->name('admin_eventos');
Route::get('/admin/evento/nuevo','AdminController@newEvento')->name('admin_evento_nuevo');
Route::get('/admin/evento/{id}/editar','AdminController@editEvento')->name('admin_evento_editar');
Route::post('/admin/evento/guardar','AjaxEventController@guardar')->name('guardar_evento');
Route::post('/admin/evento/eliminar','AjaxEventController@eliminar')->name('admin_evento_eliminar');

/**tickets*/
Route::get('/admin/tickets/{id}','AdminController@tickets')->name('admin_tickets');
Route::get('/admin/ticket/{id}/editar','AdminController@editTicket')->name('admin_ticket_editar');


Route::get('/admin/pagos','AdminController@pagos')->name('admin_pagos');

Route::get('/admin/perfil','AdminController@perfil')->name('admin_perfil');
Route::get('/admin/opciones','AdminController@opciones')->name('admin_opciones');
Route::post('/admin/evtupload','AjaxEventController@uploadPortada')->name('portada_upload');
Route::post('/admin/deleteimage','AjaxEventController@deleteImage')->name('delete_image');

/**modo perfil de usuario*/

Route::get('/evento/{id}/detalle','EventoController@detalle')->name('evento_detalle');
Route::get('/evento/{id}/apartar','EventoController@apartar')->name('evento_apartar');
Route::post('/evento/secciones','EventoController@getseccion')->name('evento_getseccion');
Route::post('/evento/paquetes','EventoController@getpaquetes')->name('evento_getpaquetes');
Route::post('/evento/available','EventoController@getavailable')->name('evento_getavailable');
Route::post('/evento/payform','EventoController@payform')->name('evento_payform');

/**modo pago*/
Route::post('/evento/pagar','PaymentsController@procesa_pago')->name('pagar');
/**modo pago*/


Route::get('/inicio',function(){
    return view('content/home');
})->name('inicio_alternativo');
//Route::get('/registro/nuevo', 'RegisterController@nuevo_registro')->name('nuevo_registro');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('inicio');
