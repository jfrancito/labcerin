<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use View;
use App\Paciente,App\Persona,App\Cliente,App\Examen,App\Comprobante,App\ReniecTipoDocumentos;
use App\Departamento,App\Distrito,App\Provincia,App\PlanAtencion,App\TipoExamen,App\CentroConvenio,App\Consulta,App\DetalleConsulta;
use App\ListarConsultasWeb,App\ListarDetalleConsultasWeb,App\ResultadoExamen,App\DetResultadoExamen;


use ZipArchive;
use Session;
use Hashids;
use PDO;

class ConsultaController extends Controller
{




	public function actionGuardarResultadoExamen($idopcion,Request $request)
	{


		try{


			$fechaActual 		= date('Y-m-d H:i:s');
			$ffin 				= $request['ffin'];


			DB::beginTransaction();

			$examen_id 			=  $request['examen_id'];
			$observacion 		=  $request['observacion'];
			$respuesta 			=  json_decode($request['xml_productos'], true);
		



			$resultadoexamen 				=  ResultadoExamen::where('codresexamen','=',$examen_id)->first();
			$resultadoexamen->estado 		= 'VAL';
			//$resultadoexamen->usuariocerin 		= session;
			$resultadoexamen->observacion 	= $observacion;
			$resultadoexamen->fechaval 		= $fechaActual;
			$resultadoexamen->save();



			foreach($respuesta as $obj){

				$data_id_coddetalleexamen 		= 	$obj['data_id_coddetalleexamen'];
				$data_valor 					= 	$obj['data_valor'];


				$detalleresultado  				=  DetResultadoExamen::where('coddetresultado','=',$data_id_coddetalleexamen)->first();

				$detalleresultado->valor 		= $data_valor;
				$detalleresultado->estado 		= 'VAL';

				$detalleresultado->fecha 		= $fechaActual;
				$detalleresultado->save();


			}



			DB::commit();

	 		return Redirect::to('/gestion-listado-diario/'.$idopcion)->with('ffin', $ffin);;

			}catch(Exception $ex){
				DB::rollback();
				return Redirect::to('/gestion-listado-diario/'.$idOpcion)->with('errorcommit', 'Ocurrio un error inesperado. Porfavor contacte con el administrador del sistema : '.$ex);	
			}

	}




	public function actionMantenimientoRegistroConsulta(Request $request)
	{

		$data_cod_resultado  		= 	$request['data_cod_resultado'];
		$data_examenres_id  		= 	$request['data_examenres_id'];
		$idopcion  					= 	$request['idopcion'];
		$ffin 						= 	$request['ffin'];




		$listadetalleconsulta 		= 	ListarDetalleConsultasWeb::where('codresultado','=',$data_cod_resultado)
										->where('codresexamen','=',$data_examenres_id)->get();

		$consulta 					= 	ListarConsultasWeb::where('codresultado','=',$data_cod_resultado)
										->where('codresexamen','=',$data_examenres_id)->first();

							
		return View::make('consulta/ajax/mantenimientoconsulta',
						 [
							 'listadetalleconsulta' => $listadetalleconsulta,
							 'consulta' 			=> $consulta,
							 'idopcion' 			=> $idopcion,
							 'ffin' 				=> $ffin,
						 ]);


	}	

	public function actionListadoDiario($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/ 


	    if (Session::get('ffin')){
	    	$fechafin 	=	Session::get('ffin');
	    }else{
		    $fechafin 	= $this->fin;
	    }

	    $fechabusqueda	=  date_format(date_create($fechafin), 'd/m/Y');

		$listaconsulta = ListarConsultasWeb::where('fechaexamen','=',$fechabusqueda)->get();

		//$listaconsulta = ListarConsultasWeb::get();

		return View::make('consulta/listadodiario',
						 [
							 'listaconsulta' 	=> $listaconsulta,
							 'fechafin' 		=> $fechafin,
							 'idopcion' 		=> $idopcion
						 ]);

	}	



	public function actionAjaxListadoDiario(Request $request)
	{

		$ffin 					=  date_format(date_create($request['ffin']), 'd/m/Y');
		$idopcion 				=  $request['idopcion'];
		$funcion 				=  $this;	
		$listaconsulta 			=  ListarConsultasWeb::where('fechaexamen','=',$ffin)->get();


		return View::make('consulta/ajax/alistadodiario',
						 [
						 	'listaconsulta' 	=> $listaconsulta,
						 	'ajax'   			=> true,
						 ]);

	}


	public function actionModalDetalleConsultaMobil($idopcion)
	{

		$consulta_id  			= $request['consulta_id'];
				
		$listaconsulta = DB::table('Consulta')
		->join('Persona', 'Persona.cod_Persona', '=', 'Consulta.cod_Paciente')
		->select('Persona.dni','Persona.apPaterno','Persona.apMaterno','Persona.nombre','Consulta.*')
		->take(100)
		->orderBy('Consulta.fecha_Examen', 'desc')
		->orderBy('Consulta.hora_Examen', 'desc')
	    ->get();


		return View::make('consulta/listaconsulta',
						 [
							 'listaconsulta' => $listaconsulta,
							 'idopcion' => $idopcion
						 ]);

	}	










	public function actionListarConsulta($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/ 

		$listaconsulta = DB::table('Consulta')
		->join('Persona', 'Persona.cod_Persona', '=', 'Consulta.cod_Paciente')
		->select('Persona.dni','Persona.apPaterno','Persona.apMaterno','Persona.nombre','Consulta.*')
		->take(100)
		->orderBy('Consulta.fecha_Examen', 'desc')
		->orderBy('Consulta.hora_Examen', 'desc')
	    ->get();


		return View::make('consulta/listaconsulta',
						 [
							 'listaconsulta' => $listaconsulta,
							 'idopcion' => $idopcion
						 ]);

	}	


	public function actionAgregarConsulta($idopcion,Request $request)
	{


		if($_POST)
		{

			DB::beginTransaction();

			try
			{



				$fechaexamen 		= $request['fechaconsulta'];
				$fechainforme 		= $request['fechainforme'];
				$horaexamen 		= $request['horaexamen'];
				$tipopago  			= $request['tipopago'];

				$acuenta 			= $request['acuenta'];
				$saldo 				= $request['saldo'];
				$total 				= $request['montototal'];
				$edad 				= $request['edad'];

				$medicoorden		= $request['medicoorden'];
				$tratante			= $request['tratante'];
				$codPaciente		= $request['codpaciente'];
				$codMedico			= $request['codmedico'];
				$nombremedico		= $request['nombremedico'];


				$tipodocumento		= $request['tipodocumento_id'];
				$comprobante_id		= $request['comprobante_id'];
				$informado_id		= $request['informado_id'];

				$numerodocumento	= $request['numerodocumento'];
				$razonsocial		= $request['razonsocial'];
				$subtotal			= $request['subtotal'];	
				$igv				= $request['igv'];		
				$email				= $request['email'];	

				$numdoc 			= $this->funciones->numerodocumento($comprobante_id);
				$nrotk 				= $this->funciones->numeroticket();


				$xml  	 			= $request['xml'];

				$tconsulta            			=  new Consulta;
				$tconsulta->fecha_Examen 		=  date_format(date_create($fechaexamen),'Ymd');
				$tconsulta->fecha_Informe 		=  date_format(date_create($fechainforme),'Ymd');
				$tconsulta->hora_Examen 		=  date_format(date_create($this->fechaActual),'Ymd H:i:s');
				$tconsulta->numDoc 				=  $numdoc;
				$tconsulta->costo 				=  $total;
				$tconsulta->acuenta				=  $acuenta;
				$tconsulta->saldo				=  $saldo;
				$tconsulta->total_Consulta		=  $total;
				$tconsulta->estado				=  'P';
				$tconsulta->nroTicket			=  $nrotk;				
				$tconsulta->tipopago			=  $tipopago;
				$tconsulta->Cod_Paciente		=  $codPaciente;
				$tconsulta->cod_Comprobante		=  $comprobante_id;
				$tconsulta->cod_Persona			=  $codMedico;
				$tconsulta->MedicoOrden			=  $nombremedico;

				$tconsulta->TIPODOCFE			=  $tipodocumento;
				$tconsulta->NRODOCFE			=  $numerodocumento;
				$tconsulta->RAZONSOCIALFE		=  $razonsocial;
				$tconsulta->SUBTOTAL			=  $subtotal;
				$tconsulta->UsuarioReg			=  Session::get('usuario')->nombre;
				$tconsulta->fechaUserReg		=  date_format(date_create($this->fechaActual),'Ymd H:i:s');;				
				$tconsulta->IGV					=  $igv;
				$tconsulta->CORREOFE		    =  $email;
				$tconsulta->ESTADOFE		    =  '';
				$tconsulta->cod_MedInforma			=  $informado_id;
				$tconsulta->save();





				$listadetalle 	= explode('&&&', $xml);

				for ($i = 0; $i < count($listadetalle)-1; $i++) {

					$detalle 			= explode('***', $listadetalle[$i]);

					$xprecio 			= $detalle[0];
					$xplanatencion 		= $detalle[1];
					$xcentroconvenio 	= $detalle[2];
					$xexamen 			= $detalle[3];
					$xsubtotal 			= $detalle[0];

					$tdetalle            	 		=	new DetalleConsulta;
					$tdetalle->cod_Consulta 	 	=  $tconsulta->cod_Consulta;
					$tdetalle->cod_Examen 	 		=  $xexamen;
					$tdetalle->cod_PlanAtencion 	=  $xplanatencion;
					$tdetalle->cantidad 	     	=  1;
					$tdetalle->monto_total 	 		=  $xsubtotal;
					$tdetalle->informe 	 			=  '';
					$tdetalle->estado 	 			=  'P';
					$tdetalle->cod_CentroConvenio	=  $xcentroconvenio;	
					$tdetalle->save();

				}	

				DB::commit();
				return Redirect::to('/gestion-de-consulta/'.$idopcion)->with('bienhecho', 'Consulta  Registrado con Exito');	
				
			}
			catch(Exception $ex)
			{
				DB::rollback();
				return Redirect::to('/gestion-de-consulta/'.$idOpcion)->with('bienhecho', 'Error inesperado. Por favor contacte con el administrador del sistema');	
				
			}

		}else{


			/******************* validar url **********************/
			$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
		    if($validarurl <> 'true'){return $validarurl;}
		    /******************************************************/

			$listaplanatencion 		= PlanAtencion::get();
			$PlanAtencion 			= PlanAtencion::pluck('descripcion','cod_PlanAtencion')->toArray();
			$comboplanatencion  	= array(0 => "Seleccione Plan") + $PlanAtencion;

			$TipoExamen 			= TipoExamen::pluck('nombre','cod_TipoExamen')->toArray();
			$combotipoexamen  		= array(0 => "Seleccione Grupo") + $TipoExamen;

			$CentroConvenio 		= CentroConvenio::wherein('tipo',array('L', 'C'))->pluck('razonSocial','cod_CentroConvenio')->toArray();
			$combocentroconvenio 	= array(0 => "Seleccione Centro") + $CentroConvenio;

			$Examen 				= Examen::pluck('nombre','cod_Examen')->toArray();
			$comboexamen  			= array(0 => "Seleccione Examen") + $Examen;

			$Comprobante			= Comprobante::pluck('nombre','cod_Comprobante')->toArray();
			$combocomprobante  		= array(0 => "Seleccione Comprobante") + $Comprobante;

			$TipoDocumento 			= ReniecTipoDocumentos::pluck('nombre','id')->toArray();
			$combotipodocumento  	= array(0 => "Seleccione Tipo Documento") + $TipoDocumento;

			$informado 				= Persona::join('Medico', 'Persona.Cod_Persona', '=', 'Medico.Cod_Medico')
			->where('Medico.trabajacerin','=','1')
			->select(DB::raw("nombre+' '+apPaterno +' '+apMaterno as nombres, cod_Persona"))
		    ->pluck('nombres','cod_Persona')->toArray();

			$comboinformado  		= array(0 => "Seleccione Informado") + $informado;


			$hoy	= date('d-m-Y');

			return View::make('consulta/agregarconsulta',
						[
						'comboplanatencion' 	=> $comboplanatencion,
						'combotipoexamen' 		=> $combotipoexamen,
						'combocentroconvenio' 	=> $combocentroconvenio,
						'comboexamen' 			=> $comboexamen,
						'combocomprobante'		=> $combocomprobante,
						'combotipodocumento'	=> $combotipodocumento,
						'comboinformado'		=> $comboinformado,	
						'listaplanatencion' 	=> $listaplanatencion,											
						'idopcion' 				=> $idopcion,
						'hoy' 					=> $hoy,
						]);



		}
	}



}
