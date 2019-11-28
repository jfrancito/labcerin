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

/********************** USUARIOS *************************/

Route::group(['middleware' => ['guestaw']], function () {

	Route::any('/', 'UserController@actionLogin');
	Route::any('/login', 'UserController@actionLogin');

}); 

Route::get('/cerrarsession', 'UserController@actionCerrarSesion');

Route::group(['middleware' => ['authaw']], function () {

	Route::get('/bienvenido', 'UserController@actionBienvenido');

	Route::any('/gestion-de-usuarios/{idopcion}', 'UserController@actionListarUsuarios');
	Route::any('/agregar-usuario/{idopcion}', 'UserController@actionAgregarUsuario');
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', 'UserController@actionModificarUsuario');

	Route::any('/gestion-de-roles/{idopcion}', 'UserController@actionListarRoles');
	Route::any('/agregar-rol/{idopcion}', 'UserController@actionAgregarRol');
	Route::any('/modificar-rol/{idopcion}/{idrol}', 'UserController@actionModificarRol');

	Route::any('/gestion-de-permisos/{idopcion}', 'UserController@actionListarPermisos');
	Route::any('/ajax-listado-de-opciones', 'UserController@actionAjaxListarOpciones');
	Route::any('/ajax-activar-permisos', 'UserController@actionAjaxActivarPermisos');

 	Route::any('/gestion-de-pacientes/{idopcion}', 'PacienteController@actionListarPacientes');
 	Route::any('/agregar-pacientes/{idOpcion}', 'PacienteController@actionAgregarPacientes');
 	Route::any('/modificar-pacientes/{idOpcion}/{codPersona}', 'PacienteController@actionModificarPacientes');
	Route::any('/ajax-buscar-paciente-essalud', 'PacienteController@actionBuscarPacienteEssalud');
	

 	Route::any('/gestion-de-proveedores/{idopcion}', 'ProveedorController@actionListarProveedores');
 	Route::any('/agregar-proveedores/{idopcion}', 'ProveedorController@actionAgregarProveedores');
 	Route::any('/modificar-proveedores/{idopcion}/{codProveedor}', 'ProveedorController@actionModificarProveedores');
	Route::any('/ajax-buscar-proveedor', 'ProveedorController@actionBuscarProveedor');

 	Route::any('/gestion-listado-diario/{idopcion}', 'ConsultaController@actionListadoDiario');
 	Route::any('/ajax-modal-detalle-consulta-mobil', 'ConsultaController@actionModalDetalleConsultaMobil');
 	Route::any('/ajax-mantenimiento-registro-consulta', 'ConsultaController@actionMantenimientoRegistroConsulta');
	Route::any('/ajax-listado-diario', 'ConsultaController@actionAjaxListadoDiario');
	Route::any('/ajax-guardar-resultado-examen/{idopcion}', 'ConsultaController@actionGuardarResultadoExamen');




 	/*Route::any('/agregar-proveedores/{idopcion}', 'ProveedorController@actionAgregarProveedores');
 	Route::any('/modificar-proveedores/{idopcion}/{codProveedor}', 'ProveedorController@actionModificarProveedores');
	Route::any('/ajax-buscar-proveedor', 'ProveedorController@actionBuscarProveedor');*/




 	Route::any('/gestion-de-consulta/{idOpcion}', 'ConsultaController@actionListarConsulta');
 	Route::any('/agregar-consulta/{idOpcion}', 'ConsultaController@actionAgregarConsulta');
 	/*Route::any('/modificar-consulta/{idOpcion}/{codConsulta}', 'ConsultaController@actionModificarConsulta');*/
	Route::any('/ajax-buscar-paciente', 'GeneralAjaxController@actionbuscarpacienteajax');
	Route::any('/ajax-buscar-paciente-modal', 'GeneralAjaxController@actionbuscarpacientemodalajax');
	Route::any('/ajax-select-centro-convenio', 'GeneralAjaxController@actioncentroconvenioajax');
	Route::any('/ajax-select-examen', 'GeneralAjaxController@actionexamenajax');
	Route::any('/ajax-buscar-examen', 'GeneralAjaxController@actionbuscarexamenajax');
	Route::any('/ajax-buscar-medico-modal', 'GeneralAjaxController@actionbuscarmedicomodalajax');	
 	Route::any('/ajax-select-comprobanteserie', 'GeneralAjaxController@actioncomprobanteserieajax');
 	Route::any('/ajax-buscar-documento', 'GeneralAjaxController@actionAjaxDocumento');

 	

	Route::any('/ajax-select-provincia', 'GeneralAjaxController@actionProvinciaAjax');
	Route::any('/ajax-select-distrito', 'GeneralAjaxController@actionDistritoAjax');

	
});

	Route::any('/pruebas', 'UserController@pruebas');