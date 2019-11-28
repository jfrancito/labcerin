<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use View;
use App\Paciente,App\Persona,App\Cliente,App\Proveedor;
use App\Departamento,App\Distrito,App\Provincia;
use ZipArchive;
use Session;
use Hashids;
use PDO;

class ProveedorController extends Controller
{


	public function actionBuscarProveedor(Request $request)
	{


		//$persona 			= Persona::where('cod_Persona','=', $codPersona)->first();
		$ruc 				= $request['ruc'];
		$json = array();	
		$url = "http://alfasweb.com/sunatcerin/datasunat.php?ruc=".$ruc;
		header('Content-Type: text/html; charset =utf-8');
		$json = file_get_contents($url, true);
		$json = mb_convert_encoding($json, 'UTF-8',mb_detect_encoding($json, 'UTF-8, ISO-8859-1', true));
		$persona = json_decode($json, true);

		return View::make('proveedor/ajax/proveedor',
						 [
							 'persona' => $persona,							 
						 ]);

	}	








	public function actionListarProveedores($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/ 

		$listaproveedores = DB::table('Proveedor')
		->orderBy('Proveedor.cod_Proveedor', 'desc')
		->take(100)
	    ->get();

		return View::make('proveedor/listaproveedores',
						 [
							 'listaproveedores' => $listaproveedores,
							 'idopcion' => $idopcion
						 ]);

	}	


	public function actionAgregarProveedores($idopcion,Request $request)
	{


		if($_POST)
		{

			DB::beginTransaction();

			try
			{

				/**** Validaciones laravel ****/
				$this->validate($request, [
		            'ruc' => 'unique:Proveedor',
				], [
	            	'ruc.unique' => 'RUC ya registrado',
	        	]);
				/******************************/


				$ruc 					= $request['ruc'];
				$razonsocial   			= $request['razonsocial'];								
				$nombrecomercial   		= $request['nombrecomercial'];
				$tipocontribuyente 		= $request['tipocontribuyente'];
				$estadocontribuyente 	= $request['estadocontribuyente'];
				$direccion   			= $request['direccion'];
				$telefono 				= $request['telefono'];


				$tpersona            			=  new Proveedor;
				$tpersona->ruc 					=  $ruc;
				$tpersona->razonsocial 	 		=  $razonsocial;
				$tpersona->nombreComercial 	 	=  $nombrecomercial;
				$tpersona->tipoContribuyente 	=  $tipocontribuyente;
				$tpersona->Telefono 	 		=  $telefono;
				$tpersona->direccion 	 		=  $direccion;	
				$tpersona->estado 	 			=  $estadocontribuyente;	
				$tpersona->save();




			DB::commit();

				return Redirect::to('/gestion-de-proveedores/'.$idopcion)->with('bienhecho', 'Proveedor '.$tpersona->nombre.' Registrado con Exito');	
				
			}
			catch(Exception $ex)
			{
				DB::rollback();
				return Redirect::to('/gestion-de-proveedores/'.$idopcion)->with('bienhecho', 'Error inesperado. Por favor contacte con el administrador del sistema');	
				
			}

		}else{

			/******************* validar url **********************/
			$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
		    if($validarurl <> 'true'){return $validarurl;}
		    /******************************************************/


			return View::make('proveedor/agregarproveedor',
						[
							 'idopcion' => $idopcion
						]);

		}
	}



	public function actionModificarProveedores($idopcion,$codProveedor,Request $request)
	{


		if($_POST)
		{

			DB::beginTransaction();

			try
			{

				/**** Validaciones laravel ****/
				$this->validate($request, [
		            'ruc' => 'unique:Proveedor,ruc,'.$codProveedor.',cod_Proveedor'
				], [
	            	'ruc.unique' => 'RUC ya registrado',
	        	]);
				/******************************/



				$ruc 					= $request['ruc'];
				$razonsocial   			= $request['razonsocial'];								
				$nombrecomercial   		= $request['nombrecomercial'];
				$tipocontribuyente 		= $request['tipocontribuyente'];
				$estadocontribuyente 	= $request['estadocontribuyente'];
				$direccion   			= $request['direccion'];
				$telefono 				= $request['telefono'];


				$tpersona            			=  Proveedor::find($codProveedor);
				$tpersona->ruc 					=  $ruc;
				$tpersona->razonsocial 	 		=  $razonsocial;
				$tpersona->nombreComercial 	 	=  $nombrecomercial;
				$tpersona->tipoContribuyente 	=  $tipocontribuyente;
				$tpersona->Telefono 	 		=  $telefono;
				$tpersona->direccion 	 		=  $direccion;	
				$tpersona->estado 	 			=  $estadocontribuyente;	
				$tpersona->save();



			DB::commit();

				return Redirect::to('/gestion-de-proveedores/'.$idopcion)->with('bienhecho', 'Proveedor '.$tpersona->razonsocial.' Modificado con Exito');	
				
			}
			catch(Exception $ex)
			{
				DB::rollback();
				return Redirect::to('/gestion-de-proveedores/'.$idopcion)->with('bienhecho', 'Error inesperado. Por favor contacte con el administrador del sistema');	
				
			}

		}else{

			/******************* validar url **********************/
			$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
		    if($validarurl <> 'true'){return $validarurl;}
		    /******************************************************/

		    $persona 						= Proveedor::where('cod_Proveedor','=', $codProveedor)->first();

			return View::make('proveedor/modificarproveedor',
						[
							 'persona' => $persona,							 
							 'idopcion' => $idopcion
						]);

		}
	}








}
