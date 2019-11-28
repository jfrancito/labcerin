<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Empresa,App\Local,App\Trabajador,App\Area,App\Horarioempresa,App\Horario,App\Cargoempresa,App\CentroConvenio;
use App\Examen,App\Comprobante,App\Proveedor;
use App\Persona;
use View;
use Session;
use Hashids;


class GeneralAjaxController extends Controller
{


	public function actionAjaxDocumento(Request $request)
	{
		$tipodocumento   	= 	$request['tipodocumento'];
		$numerodocumento   	= 	$request['numerodocumento'];		

		if($tipodocumento=='1'){

			$comprobante 		= Persona::where('dni','=',$numerodocumento)->first();
			return View::make('general/ajax/comprobantedniajax',
			 				 [
			 				 	'comprobante' => $comprobante
			 				 ]);

		}else{

			$comprobante 		= Proveedor::where('ruc','=',$numerodocumento)->first();
			return View::make('general/ajax/comprobanterucajax',
			 				 [
			 				 	'comprobante' => $comprobante
			 				 ]);
		}

	}



	public function actioncomprobanteserieajax(Request $request)
	{

		$comprobante   	= 	$request['comprobante'];
		$lcomprobante 	= 	Comprobante::where('cod_Comprobante','=',$comprobante)->first();


		return View::make('general/ajax/nrocomprobante',
		 				 [
		 				 	'comprobante' => $lcomprobante
		 				 ]);

	}	


	public function actionbuscarexamenajax(Request $request)
	{

		$codexamen   = 	$request['codexamen'];

		$examen = Examen::where('Examen.cod_Examen','=',$codexamen)
		->first();
		
	    if(count($examen)>0){
		   	$examen = $examen->toJson();
		    print_r($examen);
	    }else{
	    	print_r("{}");
	    }
	}	


	public function actionexamenajax(Request $request)
	{

 
		$codtipoexamen   = 	$request['codtipoexamen'];

		$listaexamen = Examen::where('Examen.cod_TipoExamen','=',$codtipoexamen) 
		->pluck('nombre','cod_Examen')->toArray();
	 
		$comboexamen  = array(0 => "Seleccione Examen") + $listaexamen;
	 	 
		 return View::make('general/ajax/examenajax',
		 				 [
		 				 'comboexamen' => $comboexamen
		 				 ]);

	}	

	public function actioncentroconvenioajax(Request $request)
	{

		$planatencion   = 	$request['planatencion'];
		$examen_id   	= 	$request['examen_id'];
		$precio         =   '';

		/**** precio del examen *****/
		$examen = Examen::where('Examen.cod_Examen','=',$examen_id)
		->first();

		if(count($examen)>0){
			$precio         =   $examen->precio;			
		}

		if($planatencion == 'CONVENIO'){
			$CentroConvenio = CentroConvenio::where('tipo','=','C')
							->pluck('razonSocial','cod_CentroConvenio')->toArray();			
		}else{
			$CentroConvenio = CentroConvenio::where('tipo','=','L')
							->pluck('razonSocial','cod_CentroConvenio')->toArray();	
		}

		$combocentroconvenio  =  $CentroConvenio;

		return View::make('general/ajax/centroconvenioajax',
						 [
						 	'combocentroconvenio' => $combocentroconvenio,
						 	'precio' => $precio					 	
						 ]);

	}


	public function actionbuscarmedicomodalajax(Request $request)
	{

		$dniapellidomedico   = 	$request['dniapellidomedico'];
		$tipobuscarmedico    = 	$request['tipobuscarmedico'];

		if($tipobuscarmedico == 'A'){

			$listamedicos = Persona::join('Medico', 'Persona.Cod_Persona', '=', 'Medico.Cod_Medico')
			->where('Persona.apPaterno','like','%'.$dniapellidomedico.'%')
			->orWhere('Persona.apMaterno','like','%'.$dniapellidomedico.'%')
			->orderBy('Persona.apPaterno', 'asc')
			->orderBy('Persona.apMaterno', 'asc')
		    ->get();

		}else{

			$listamedicos = Persona::join('Medico', 'Persona.Cod_Persona', '=', 'Medico.Cod_Medico')
			->where('Persona.dni','like','%'.$dniapellidomedico.'%')
			->orderBy('Persona.apPaterno', 'asc')
			->orderBy('Persona.apMaterno', 'asc')
		    ->get();

		}


		return View::make('general/ajax/listamedico',
						 [
						 	'listamedicos' => $listamedicos
						 ]);



	}


	public function actionbuscarpacientemodalajax(Request $request)
	{

		$dniapellido   = 	$request['dniapellido'];
		$tipobuscar    = 	$request['tipobuscar'];

		if($tipobuscar == 'A'){

			$listapacientes = Persona::join('Paciente', 'Persona.Cod_Persona', '=', 'Paciente.Cod_Paciente')
			->where('Persona.apPaterno','like','%'.$dniapellido.'%')
			->orWhere('Persona.apMaterno','like','%'.$dniapellido.'%')
			->orderBy('Persona.apPaterno', 'asc')
			->orderBy('Persona.apMaterno', 'asc')
		    ->get();

		}else{


			$listapacientes = Persona::join('Paciente', 'Persona.Cod_Persona', '=', 'Paciente.Cod_Paciente')
			->where('Persona.dni','like','%'.$dniapellido.'%')
			->orderBy('Persona.apPaterno', 'asc')
			->orderBy('Persona.apMaterno', 'asc')
		    ->get();


		}

		return View::make('general/ajax/listapaciente',
						 [
						 'listapacientes' => $listapacientes
						 ]);


	}


	public function actionbuscarpacienteajax(Request $request)
	{

		$dni   = 	$request['dni'];
		$listaPacientes = Persona::join('Paciente', 'Persona.Cod_Persona', '=', 'Paciente.Cod_Paciente')
		->where('Persona.dni','=',$dni)
		->orderBy('Persona.apPaterno', 'asc')
		->orderBy('Persona.apMaterno', 'asc')
	    ->first();

	    if(count($listaPacientes)>0){
		   	$listaPacientes = $listaPacientes->toJson();
		    print_r($listaPacientes);
	    }else{
	    	print_r("{}");
	    }



	}	


	public function actionAjaxBuscarSunat()
	{

		$ruc = Input::get('ruc');
		$json = array();	
		$url = "http://localhost:82/sunat/datasunat.php?ruc=".$ruc;
		$json = file_get_contents($url, true);
		//$respuesta = json_decode($json, true);
		print_r($json);

	}	

	public function actionAjaxBuscarReniec()
	{

		$dni = Input::get('dni');
		$json = array();	
		$url = "http://app17.susalud.gob.pe/webservice/rest/ws/pac/persona.php?code=".$dni;
		$json = file_get_contents($url, true);
		//$respuesta = json_decode($json, true);
		print_r($json);

	}	


	public function actionTrabajadorAreaEmpresaTodoAjax(Request $request)
	{


		$area_id   				= 	$request['area_id'];
		$empresa_id   			= 	$request['empresa_id'];
		$sede_id   				= 	$request['sede_id'];	

		if($area_id <> '1'){	$area_id 				= 	$this->funciones->decodificarmaestra($area_id);}
		$empresa_id 			= 	$this->funciones->decodificarmaestra($empresa_id);		

		$arrayareas				= 	DB::table('areas')->where('id','=',$area_id)->pluck('id')->toArray();

		if(count($arrayareas)>0 or $area_id =='1'){

			if($area_id == '1'){


				$tempresa  				= 	Empresa::where('id','=',$empresa_id)->first();
				$locales   				= 	Local::where('empresa_id','=',$tempresa->id)
											->where('identificador','=',$sede_id)->get();

			    $arrayarea=array(-1);
			    $i = 0;
				foreach($locales as $item){
					foreach($item->trabajador as $item2){
						$arrayarea[$i]=$item2->area_id;
						$i = $i+1;
					}
				}

				$arraytrabajadores 	=   $this->funciones->arraysedetrabajadorespermiso($sede_id);

				$trabajadores 		=   Trabajador::select(DB::raw("id, apellidopaterno + ' ' + apellidomaterno + ' ' + nombres  as descripcion"))
										//->where('activo','=',1)
										->whereIn('area_id',$arrayarea)
										->whereIn('id',$arraytrabajadores)										
										->pluck('descripcion','id')
										->toArray();

			}else{


				$arraytrabajadores 	=   $this->funciones->arraysedetrabajadorespermiso($sede_id);

				$trabajadores 		=   Trabajador::select(DB::raw("id, apellidopaterno + ' ' + apellidomaterno + ' ' + nombres  as descripcion"))
										//->where('activo','=',1)
										->whereIn('area_id',$arrayareas)
										->whereIn('id',$arraytrabajadores)
										->pluck('descripcion','id')
										->toArray();


			}

			$combotrabajador 	= 	$this->funciones->comboidencriptadotodos($trabajadores,'Seleccione trabajador');


		}else{
			$combotrabajador  	= array('' => "Seleccione trabajador");
		}


		return View::make('general/ajax/combotrabajadorareaempresafiltro',
						 [
						 'combotrabajador' => $combotrabajador
						 ]);
	}


	public function actionAreaEmpresaTodoAjax(Request $request)
	{

		$empresa   				= 	$request['empresa'];
		$sede_id   				= 	$request['sede_id'];		
		$empresa 				= 	$this->funciones->decodificarmaestra($empresa);
		$tempresa  				= 	Empresa::where('id','=',$empresa)->first();

		if(count($tempresa)>0){

			$locales   = Local::where('empresa_id','=',$tempresa->id)->where('identificador','=',$sede_id)->get();
		    $arrayarea=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayarea[$i]=$item2->area_id;
					$i = $i+1;
				}
			}

			$area 			= 	DB::table('areas')->whereIn('id',$arrayarea)->pluck('nombre','id')->toArray();

			$comboarea 		= 	$this->funciones->comboidencriptadotodos($area,'Seleccione Area');


		}else{
			$comboarea  	= array('' => "Seleccione Area");
		}


		return View::make('general/ajax/comboareaempresafiltro',
						 [
						 'comboarea' => $comboarea
						 ]);
	}


	public function actionSedeTrabajadoresTodoAjax(Request $request)
	{

		$sede_id   				= 	$request['sede_id'];

	    $arraylocales   		= 	$this->funciones->arraylocalessedespermiso($sede_id);
		$trabajadores 			=   Trabajador::select(DB::raw("id, apellidopaterno + ' ' + apellidomaterno + ' ' + nombres  as descripcion"))
									->where('activo','=',1)
									->whereIn('local_id',$arraylocales)
									->pluck('descripcion','id')
									->toArray();

		$combotrabajador 		= 	$this->funciones->comboidencriptadotodos($trabajadores,'Seleccione trabajador');

		return View::make('general/ajax/combosedetrabajadorfiltro',
						 [
						 'combotrabajador' => $combotrabajador
						 ]);
	}





	public function actionProvinciaAjax(Request $request)
	{
		$departamento_id   = $request['departamentos_id'];

		$provincia = DB::table('Provincia')->where('cod_Departamento','=',$departamento_id)->pluck('nombre_Prov','cod_Provincia')->toArray();
		$comboprovincia  = array(0 => "Seleccione Provincia") + $provincia;

		return View::make('general/ajax/comboprovincia',
						 [
						 'comboprovincia' => $comboprovincia
						
						 ]);
	}	


	public function actionDistritoAjax(Request $request)
	{
		$provincia_id   = $request['provincia_id'];
		$departamento_id   = $request['departamentos_id'];

		$distrito = DB::table('Distrito')->where('cod_Provincia','=',$provincia_id)->where('cod_Departamento','=',$departamento_id)
					->pluck('nombre_Dist','cod_Distrito')->toArray();
		$combodistrito  = array(0 => "Seleccione Distrito") + $distrito;

		return View::make('general/ajax/combodistrito',
						 [
						 'combodistrito' => $combodistrito

						 ]);
	}	

	public function actionHorarioEmpresaIdAjax(Request $request)
	{

		$empresa   = $request['empresa'];
		$tempresa  = Empresa::where('id','=',$empresa)->first();

		if(count($tempresa)>0){
			$locales   = Local::where('empresa_id','=',$tempresa->id)->get();
		    $arrayhorario=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayhorario[$i]=$item2->horario_id;
					$i = $i+1;
				}
			}

			$horario 		= DB::table('horarios')->whereIn('id',$arrayhorario)->pluck('nombre','nombre')->toArray();
			$combohorario  	= array('' => "Seleccione horario") + $horario;

		}else{
			$combohorario  	= array('' => "Seleccione horario");
		}


		return View::make('general/ajax/combohorarioempresa',
						 [
						 'combohorario' => $combohorario
						 ]);
	}


	public function actionLocalEmpresaAjax(Request $request)
	{

		$empresa_id   = $request['empresa_id'];

		$local 		 = DB::table('locales')->where('empresa_id','=',$empresa_id)->pluck('nombreabreviado','id')->toArray();
		$combolocal  = array(0 => "Seleccione local") + $local;

		return View::make('general/ajax/combolocalempresa',
						 [
						 'combolocal' => $combolocal

						 ]);
	}

	public function actionAreaHorarioCargoEmpresaIdAjax(Request $request)
	{


		$empresa   	  = $request['empresa'];
		$tempresa  	  = Empresa::where('id','=',$empresa)->first();

		if(count($tempresa)>0){
			$locales   = Local::where('empresa_id','=',$tempresa->id)->get();
		    $arrayarea=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayarea[$i]=$item2->area_id;
					$i = $i+1;
				}
			}

			$area 			= DB::table('areas')->whereIn('id',$arrayarea)->pluck('nombre','id')->toArray();
			$comboarea  	= array('' => "Seleccione Area") + $area;

			$listahorario   = Horarioempresa::where('empresa_id','=',$empresa)->where('activo','=','1')->pluck('horario_id')->toArray();
			$horario 		= DB::table('horarios')->whereIn('id',$listahorario)->where('activo','=','1')->pluck('nombre','id')->toArray();
			$combohorario  	= array('' => "Seleccione Horario") + $horario;

			$listacargo   	= Cargoempresa::where('empresa_id','=',$empresa)->where('activo','=','1')->pluck('cargo_id')->toArray();
			$cargo			= DB::table('cargos')->whereIn('id',$listacargo)->where('activo','=','1')->pluck('nombre','id')->toArray();
			$combocargo  	= array('' => "Seleccione Cargo") + $cargo;



		}else{
			$comboarea  	= array('' => "Seleccione Area");
			$combohorario  	= array('' => "Seleccione Horario");
			$combocargo  	= array('' => "Seleccione Cargo");
		}


		return View::make('general/ajax/comboareahorariocargoempresa',
						 [
						 'comboarea' 		=> $comboarea,
						 'combohorario' 	=> $combohorario,
						 'combocargo' 		=> $combocargo,
						 ]);
	}


	public function actionAreaEmpresaAjax(Request $request)
	{


		$empresa   = $request['empresa'];
		$tempresa  = Empresa::where('descripcion','=',$empresa)->first();

		if(count($tempresa)>0){
			$locales   = Local::where('empresa_id','=',$tempresa->id)->get();
		    $arrayarea=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayarea[$i]=$item2->area_id;
					$i = $i+1;
				}
			}

			$area 			= DB::table('areas')->whereIn('id',$arrayarea)->pluck('nombre','nombre')->toArray();
			$comboarea  	= array('' => "Seleccione Area") + $area;

		}else{
			$comboarea  	= array('' => "Seleccione Area");
		}


		return View::make('general/ajax/comboareaempresa',
						 [
						 'comboarea' => $comboarea
						 ]);  
	}


	public function actionLocalAjax(Request $request)
	{

		$empresa_id   = $request['empresa_id'];

		$local 		 = DB::table('locales')->where('empresa_id','=',$empresa_id)->pluck('nombreabreviado','id')->toArray();
		$combolocal  = array(0 => "Seleccione local") + $local;

		return View::make('general/ajax/combolocal',
						 [
						 'combolocal' => $combolocal

						 ]);
	}

	public function actionAreaAjax(Request $request)
	{
		$gerencia_id   = $request['gerencia_id'];

		$area = DB::table('areas')->where('gerencia_id','=',$gerencia_id)->pluck('nombre','id')->toArray();
		$comboarea  = array(0 => "Seleccione Área") + $area;

		return View::make('general/ajax/comboarea',
						 [
						 'comboarea' => $comboarea
						
						 ]);
	}	


	public function actionUnidadAjax(Request $request)
	{
		$area_id   = $request['area_id'];

		$unidad = DB::table('unidades')->where('area_id','=',$area_id)->pluck('nombre','id')->toArray();
		$combounidad  = array(0 => "Seleccione Unidad") + $unidad;

		return View::make('general/ajax/combounidad',
						 [
						 'combounidad' => $combounidad
						
						 ]);
	}	

	public function actionCargoAjax(Request $request)
	{
		$unidad_id   = $request['unidad_id'];

		$cargo = DB::table('cargos')->where('unidad_id','=',$unidad_id)->pluck('nombre','id')->toArray();
		$combocargo  = array(0 => "Seleccione Cargo") + $cargo;

		return View::make('general/ajax/combocargo',
						 [
						 'combocargo' => $combocargo

						 ]);
	}



	public function actionTipoDocumentoAcreditaAjax(Request $request)
	{
		$vinculofamiliar_id   = $request['vinculofamiliar_id'];

		$tipodocumentoacredita = DB::table('tipodocumentoacreditas')->where('vinculofamiliar_id','=',$vinculofamiliar_id)->pluck('descripcionabreviado','id')->toArray();
		$combotipodocumentoacredita  = array(0 => "Seleccione Tipo Doc Acredita") + $tipodocumentoacredita;

		return View::make('general/ajax/combotipodocumentoacredita',
						 [
						 'combotipodocumentoacredita' => $combotipodocumentoacredita

						 ]);
	}		


	public function actionTipoInstitucionAjax(Request $request)
	{
		$regimeninstitucion_id   = $request['regimeninstitucion_id'];

		$tipoinstitucion = DB::table('tipoinstituciones')->where('regimeninstitucion_id','=',$regimeninstitucion_id)->pluck('nombre','id')->toArray();
		$combotipoinstitucion  = array('' => "Seleccione Tipo Institucion") + $tipoinstitucion;

		return View::make('general/ajax/combotipoinstitucion',
						 [
						 'combotipoinstitucion' => $combotipoinstitucion
						 ]);
	}	


	public function actionInstitucionAjax(Request $request)
	{
		
		$tipoinstitucion_id   = $request['tipoinstitucion_id'];

		$institucion = DB::table('instituciones')->where('tipoinstitucion_id','=',$tipoinstitucion_id)->pluck('nombre','id')->toArray();
		$comboinstitucion = array('' => "Seleccione Institucion") + $institucion;

		return View::make('general/ajax/comboinstitucion',
						 [
						 'comboinstitucion' => $comboinstitucion
						 ]);
	}


	public function actionCarreraAjax(Request $request)
	{
		$institucion_id = $request['institucion_id'];

		$carrera 		= DB::table('carreras')->where('institucion_id','=',$institucion_id)->pluck('nombre','id')->toArray();
		$combocarrera   = array('' => "Seleccione Carrera") + $carrera;

		return View::make('general/ajax/combocarrera',
						 [
						 'combocarrera' => $combocarrera
						 ]);
	}	
}
