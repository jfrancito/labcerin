<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use View;
use App\Paciente,App\Persona,App\Cliente;
use App\Departamento,App\Distrito,App\Provincia;
use ZipArchive;
use Session;
use Hashids;
use PDO;

class PacienteController extends Controller
{

	public function actionBuscarPacienteEssalud(Request $request)
	{


		//$persona 			= Persona::where('cod_Persona','=', $codPersona)->first();
		$dni 				= $request['dni'];

		$json = array();	
		$url = "http://app17.susalud.gob.pe/webservice/rest/ws/pac/persona.php?code=".$dni;
		header('Content-Type: text/html; charset =utf-8');
		$json = file_get_contents($url, true);
		$json = mb_convert_encoding($json, 'UTF-8',mb_detect_encoding($json, 'UTF-8, ISO-8859-1', true));
		$persona = json_decode($json, true);


	    $departamento                   = Departamento::where('cod_Departamento','=',$persona['dpto'])->first();
	    $provincia                   	= Provincia::where('cod_Departamento','=',$persona['dpto'])
	    								  ->where('cod_Provincia','=',$persona['prov'])->first();
	    $distrito                   	= Distrito::where('cod_Departamento','=',$persona['dpto'])
	    								  ->where('cod_Provincia','=',$persona['prov'])
	    								  ->where('cod_Distrito','=',$persona['distr'])->first();




		$departamentos					= DB::table('Departamento')->pluck('nombre_Dep','cod_Departamento')->toArray();
		$combodepartamento  			= array(str_pad($departamento->cod_Departamento, 2, "0", STR_PAD_LEFT) => $departamento->nombre_Dep) + $departamentos ;


		$provincias						= DB::table('Provincia')->where('cod_Departamento','=',$persona['dpto'])->pluck('nombre_Prov','cod_Provincia')->toArray();
		$comboprovincia 				= array(str_pad($provincia->cod_Provincia, 2, "0", STR_PAD_LEFT) => $provincia->nombre_Prov) + $provincias ;


		$distritos						= DB::table('distrito')->where('cod_Departamento','=',$persona['dpto'])
										  ->where('cod_Provincia','=',$persona['prov'])->pluck('nombre_Dist','cod_Distrito')->toArray();
		$combodistrito  				= array(str_pad($distrito->cod_Distrito, 2, "0", STR_PAD_LEFT) => $distrito->nombre_Dist) + $distritos ;

		if($persona['sexo'] == '2'){
			$nombresexo = "Femenino";
			$sexo       = 0;
		}else{
			$nombresexo = "Masculino";
			$sexo       = 1;			
		}

		$combosexo  				 	= array($sexo => $nombresexo,-1 => "Seleccione Sexo", 0 => "Femenino" , 1 => "Masculino");
		$comboedad  				 	= array('AÑOS' => "AÑOS", 'MESES' => "MESES" , 'DIAS' => "DIAS");
		return View::make('paciente/ajax/paciente',
						 [
							 'persona' => $persona,
							 'combodepartamento' => $combodepartamento,
							 'comboprovincia' => $comboprovincia,
							 'combodistrito' => $combodistrito,
							 'combosexo' => $combosexo,
							 'comboedad' => $comboedad							 							 
						 ]);

	}	



	public function actionListarPacientes($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/ 

		$listapacientes = DB::table('Persona')
		->where('dni','<>','')
		->orderBy('Persona.Cod_Persona', 'desc')
		->take(20)
	    ->get();

		return View::make('paciente/listapacientes',
						 [
							 'listapacientes' => $listapacientes,
							 'idopcion' => $idopcion
						 ]);

	}	



	public function actionAgregarPacientes($idopcion,Request $request)
	{


		if($_POST)
		{

			DB::beginTransaction();

			try
			{

				/**** Validaciones laravel ****/
				$this->validate($request, [
		            'dni' => 'unique:Persona',
				], [
	            	'dni.unique' => 'DNI ya registrado',
	        	]);
				/******************************/


				$dni 				= $request['dni'];
				$nombre   			= $request['nombre'];								
				$apellidopaterno   	= $request['apellidopaterno'];
				$apellidomaterno 	= $request['apellidomaterno'];
				$fechanacimiento 	= date_format(date_create($request['fechanacimiento']),'Ymd');
				$sexo_id   			= $request['sexo_id'];
				$autogenerado 		= $request['autogenerado'];
				$direccion   		= $request['direccion'];
				$departamento_id 	= $request['departamento_id'];
				$provincia_id   	= $request['provincia_id'];
				$distrito_id 		= $request['distrito_id'];
				$telefonofijo   	= $request['telefonofijo'];
				$celular 			= $request['celular'];
				$email   			= $request['email'];


				$codper 			= '';

				$codpersona         = Persona::where('dni','=',$dni)->first();
				$codpersonadni      = Persona::where('nombre','=',$nombre)->where('apPaterno','=',$apellidopaterno)->where('apMaterno','=',$apellidomaterno)->first();


				if(count($codpersona)<=0 and count($codpersonadni)<=0){

					$tpersona            			=  new Persona;
					$tpersona->TIPODOC 				=  '1';
					$tpersona->nombre 	 			=  $nombre;
					$tpersona->appaterno 	 		=  $apellidopaterno;
					$tpersona->dni 					=  $dni;
					$tpersona->sexo 	 			=  $sexo_id;
					$tpersona->edad 	 			=  '18';	
					$tpersona->fechaNac 	 		=  $fechanacimiento;
					$tpersona->direccion      		=  $direccion;
					$tpersona->telefono 	 		=  $telefonofijo;
					$tpersona->mail 	 			=  $email;
					$tpersona->celular 	 			=  $celular;
					$tpersona->estado 	 			=  'A';
					$tpersona->cod_Distrito 	 	=  $distrito_id;
					$tpersona->cod_Provincia 	 	=  $provincia_id;
					$tpersona->cod_Departamento 	=  $departamento_id;
					$tpersona->apmaterno 	 		=  $apellidomaterno;
					$tpersona->save();

				}

				if(count($codpersonadni)>0){
					$codper = $codpersonadni->cod_Persona;
				}


    			//PARA REGISTRAR PACIENTE 
				$paciente   = Paciente::where('Cod_Paciente','=',$codper)->first();
				if(count($paciente)>0){
					DB::rollback();
					return Redirect::to('/gestion-pacientes/'.$idOpcion)->with('bienhecho', 'El paciente ya existe');	
				}

				$tpaciente            			=  new Paciente;
				$tpaciente->Cod_Paciente 	 	=  $tpersona->cod_Persona;
				$tpaciente->save();

     			//PARA REGISTRAR CLIENTE 
				$paciente   = Cliente::where('Cod_Cliente','=',$codper)->first();

				if(count($codpersonadni)>0){
	
					$tcliente            			=  new Cliente;
					$tcliente->Ruc 					=  '';
					$tcliente->Cod_Cliente 	 		=  $codper;
					$tcliente->RazonSocial 			=  '';					
					$tcliente->save();

				}


			DB::commit();

				return Redirect::to('/gestion-de-pacientes/'.$idopcion)->with('bienhecho', 'Paciente '.$tpersona->nombre.' Registrado con Exito');	
				
			}
			catch(Exception $ex)
			{
				DB::rollback();
				return Redirect::to('/gestion-de-pacientes/'.$idopcion)->with('bienhecho', 'Error inesperado. Por favor contacte con el administrador del sistema');	
				
			}

		}else{

			/******************* validar url **********************/
			$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
		    if($validarurl <> 'true'){return $validarurl;}
		    /******************************************************/


			$departamento 				 = DB::table('Departamento')->pluck('nombre_Dep','cod_Departamento')->toArray();
			$combodepartamento			 = array('' => "Seleccione Departamento") + $departamento;
			$comboprovincia				 = array('' => "Seleccione Provincia");
			$combodistrito				 = array('' => "Seleccione Distrito");
			$combosexo  				 = array(-1 => "Seleccione Sexo", 0 => "Femenino" , 1 => "Masculino");
			$comboedad  				 = array('AÑOS' => "AÑOS", 'MESES' => "MESES" , 'DIAS' => "DIAS");

			return View::make('paciente/agregarpaciente',
						[
							 'combodepartamento' => $combodepartamento,
							 'comboprovincia' => $comboprovincia,
							 'combodistrito' => $combodistrito,
							 'combosexo' => $combosexo,
							 'comboedad' => $comboedad,							 
							 'idopcion' => $idopcion
						]);

		}
	}



	public function actionModificarPacientes($idopcion,$codPersona,Request $request)
	{


		if($_POST)
		{

			DB::beginTransaction();

			try
			{

				/**** Validaciones laravel ****/
				$this->validate($request, [
		            'dni' => 'unique:Persona,dni,'.$codPersona.',cod_Persona'
				], [
	            	'dni.unique' => 'DNI ya registrado',
	        	]);
				/******************************/


				$dni 				= $request['dni'];
				$nombre   			= $request['nombre'];								
				$apellidopaterno   	= $request['apellidopaterno'];
				$apellidomaterno 	= $request['apellidomaterno'];
				$fechanacimiento 	= date_format(date_create($request['fechanacimiento']),'Ymd');
				$sexo_id   			= $request['sexo_id'];
				$autogenerado 		= $request['autogenerado'];
				$direccion   		= $request['direccion'];
				$departamento_id 	= $request['departamento_id'];
				$provincia_id   	= $request['provincia_id'];
				$distrito_id 		= $request['distrito_id'];
				$telefonofijo   	= $request['telefonofijo'];
				$celular 			= $request['celular'];
				$email   			= $request['email'];


				$tpersona            			=  Persona::find($codPersona);
				$tpersona->nombre 	 			=  $nombre;
				$tpersona->appaterno 	 		=  $apellidopaterno;
				$tpersona->dni 					=  $dni;
				$tpersona->sexo 	 			=  $sexo_id;
				$tpersona->edad 	 			=  '18';	
				$tpersona->fechaNac 	 		=  $fechanacimiento;
				$tpersona->direccion      		=  $direccion;
				$tpersona->telefono 	 		=  $telefonofijo;
				$tpersona->mail 	 			=  $email;
				$tpersona->celular 	 			=  $celular;
				$tpersona->estado 	 			=  'A';
				$tpersona->cod_Distrito 	 	=  $distrito_id;
				$tpersona->cod_Provincia 	 	=  $provincia_id;
				$tpersona->cod_Departamento 	=  $departamento_id;
				$tpersona->apmaterno 	 		=  $apellidomaterno;
				$tpersona->save();



			DB::commit();

				return Redirect::to('/gestion-de-pacientes/'.$idopcion)->with('bienhecho', 'Paciente '.$tpersona->nombre.' Modificado con Exito');	
				
			}
			catch(Exception $ex)
			{
				DB::rollback();
				return Redirect::to('/gestion-de-pacientes/'.$idopcion)->with('bienhecho', 'Error inesperado. Por favor contacte con el administrador del sistema');	
				
			}

		}else{

			/******************* validar url **********************/
			$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
		    if($validarurl <> 'true'){return $validarurl;}
		    /******************************************************/


		    $persona 						= Persona::where('cod_Persona','=', $codPersona)->first();

		    $departamento                   = Departamento::where('cod_Departamento','=',$persona->cod_Departamento)->first();
		    $provincia                   	= Provincia::where('cod_Departamento','=',$persona->cod_Departamento)
		    								  ->where('cod_Provincia','=',$persona->cod_Provincia)->first();
		    $distrito                   	= Distrito::where('cod_Departamento','=',$persona->cod_Departamento)
		    								  ->where('cod_Provincia','=',$persona->cod_Provincia)
		    								  ->where('cod_Distrito','=',$persona->cod_Distrito)->first();


			$departamentos					= DB::table('Departamento')->pluck('nombre_Dep','cod_Departamento')->toArray();
			$combodepartamento  			= array(str_pad($departamento->cod_Departamento, 2, "0", STR_PAD_LEFT) => $departamento->nombre_Dep) + $departamentos ;


			$provincias						= DB::table('Provincia')->where('cod_Departamento','=',$persona->cod_Departamento)->pluck('nombre_Prov','cod_Provincia')->toArray();
			$comboprovincia 				= array(str_pad($provincia->cod_Provincia, 2, "0", STR_PAD_LEFT) => $provincia->nombre_Prov) + $provincias ;



			$distritos						= DB::table('distrito')->where('cod_Departamento','=',$persona->cod_Departamento)
											  ->where('cod_Provincia','=',$persona->cod_Provincia)->pluck('nombre_Dist','cod_Distrito')->toArray();
			$combodistrito  				= array(str_pad($distrito->cod_Distrito, 2, "0", STR_PAD_LEFT) => $distrito->nombre_Dist) + $distritos ;


			if($persona->sexo == '0'){
				$nombresexo = "Femenino";
			}else{
				$nombresexo = "Masculino";	
			}

			$combosexo  				 	= array($persona->sexo => $nombresexo,-1 => "Seleccione Sexo", 0 => "Femenino" , 1 => "Masculino");


			return View::make('paciente/modificarpaciente',
						[
							 'combodepartamento' => $combodepartamento,
							 'comboprovincia' => $comboprovincia,
							 'combodistrito' => $combodistrito,
							 'combosexo' => $combosexo,
							 'persona' => $persona,							 
							 'idopcion' => $idopcion
						]);

		}
	}



}
