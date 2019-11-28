<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\User,App\Grupoopcion,App\Rol,App\RolOpcion,App\Opcion,App\Documento,App\Trabajador,App\Empresa,App\Local,App\Permisousersede;
use App\Permisouserempresa;
use View;
use Session;
use Hashids;


class UserController extends Controller
{

 	public function actionDatoTrabajador(Request $request){

		$dni 			= strtoupper($request['dni']);
		$trabajador     = Trabajador::where('dni', '=', $dni)->first();
		$usuario     	= User::where('dni', '=', $dni)->first();
		
		return View::make('usuario/ajax/datotrabajador',
						 [
						 	'trabajador' => $trabajador,
						 	'usuario' 	 => $usuario
						 ]);
 	}



	
   public function actionLogin(Request $request)
    {

		if($_POST)
		{
			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'name' => 'required',
	            'password' => 'required',

			], [
            	'name.required' => 'El campo Usuario es obligatorio',
            	'password.required' => 'El campo Clave es obligatorio',
        	]);

			/**********************************************************/
			

			$usuario 	 				 = strtoupper($request['name']);
			$clave   	 				 = strtoupper($request['password']);

			$tusuario    				 = User::whereRaw('UPPER(name)=?',[$usuario])->first();

			if(count($tusuario)>0)
			{
				$clavedesifrada 		 = 	strtoupper(Crypt::decrypt($tusuario->password));


				if($clavedesifrada == $clave)
				{
					$listamenu    		 = 	Grupoopcion::where('activo', '=', 1)->orderBy('orden', 'asc')->get();
					
					Session::put('usuario', $tusuario);
					Session::put('listamenu', $listamenu);

					return Redirect::to('bienvenido');
					
						
				}else{
					return Redirect::back()->withInput()->with('errorbd', 'Usuario o clave incorrecto');
				}	
			}else{
				return Redirect::back()->withInput()->with('errorbd', 'Usuario o clave incorrecto');
			}						    

		}else{


			return view('usuario.login');
		}
    }

	public function actionBienvenido()
	{
		return View::make('bienvenido');
	}

	public function actionCerrarSesion()
	{

		Session::forget('usuario');
		Session::forget('listamenu');
		Session::forget('local');

		return Redirect::to('/login');
	}

	public function actionListarUsuarios($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');

	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $listausuarios = User::where('id','<>',1)->orderBy('id', 'asc')->get();

		return View::make('usuario/listausuarios',
						 [
						 	'listausuarios' => $listausuarios,
						 	'idopcion' => $idopcion,
						 ]);
	}


	public function actionAgregarUsuario($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}

	    /******************************************************/

		if($_POST)
		{


			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'name' => 'unique:users',
	            'dni' => 'unique:users',
			], [
            	'name.unique' => 'Usuario ya registrado',
            	'dni.unique' => 'DNI ya registrado',
        	]);
			/******************************/

			$cabecera            	 =	new User;
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->apellido 	 =  $request['apellido'];
			$cabecera->dni 	 		 = 	$request['dni'];
			$cabecera->name  		 =	$request['name'];
			$cabecera->password 	 = 	Crypt::encrypt($request['password']);
			$cabecera->rol_id 	 	 = 	$request['rol_id'];
			$cabecera->save();

 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$request['nombre'].' '.$request['apellido'].' registrado con exito');

		}else{

		
			$rol 					= DB::table('Rols')->where('id','<>',1)->pluck('nombre','id')->toArray();
			$comborol  				= array('' => "Seleccione Rol") + $rol;
		

			return View::make('usuario/agregarusuario',
						[
							'comborol'  => $comborol,						
						  	'idopcion'  => $idopcion
						]);
		}
	}


	public function actionModificarUsuario($idopcion,$idusuario,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idusuario = $this->funciones->decodificarmaestra($idusuario);

		if($_POST)
		{
			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'name' => 'unique:users,name,'.$idusuario.',id',
	            'dni' => 'unique:users,dni,'.$idusuario.',id'
			], [
            	'name.unique' => 'Usuario ya registrado',
            	'dni.unique' => 'DNI ya registrado',
        	]);
			/******************************/

			$cabecera            	 =	User::find($idusuario);
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->apellido 	 =  $request['apellido'];
			$cabecera->dni 	 		 = 	$request['dni'];
			$cabecera->name  		 =	$request['name'];
			$cabecera->password 	 = 	Crypt::encrypt($request['password']);
			$cabecera->activo 	 	 =  $request['activo'];			
			$cabecera->rol_id 	 	 = 	$request['rol_id'];
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$request['nombre'].' '.$request['apellido'].' modificado con exito');


		}else{

			

				$usuario 	= User::where('id', $idusuario)->first();  
				$rol 		= DB::table('Rols')->where('id','<>',1)->pluck('nombre','id')->toArray();
				$comborol  	= array($usuario->rol_id => $usuario->rol->nombre) + $rol;
				



		        return View::make('usuario/modificarusuario', 
		        				[
		        					'usuario'  => $usuario,
									'comborol' => $comborol,
						  			'idopcion' => $idopcion,						  			
		        				]);
		}
	}



	public function actionListarRoles($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listaroles = Rol::where('id','<>',1)->orderBy('id', 'asc')->get();

		return View::make('usuario/listaroles',
						 [
						 	'listaroles' => $listaroles,
						 	'idopcion' => $idopcion,
						 ]);

	}


	public function actionAgregarRol($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'nombre' => 'unique:rols',
			], [
            	'nombre.unique' => 'Rol ya registrado',
        	]);
			/******************************/


			$cabecera            	 =	new Rol;
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->save();

			$listaopcion = Opcion::orderBy('id', 'asc')->get();
			$count = 1;
			foreach($listaopcion as $item){

			    $detalle            =	new RolOpcion;
				$detalle->opcion_id = 	$item->id;
				$detalle->rol_id    =  	$cabecera->id;
				$detalle->orden     =  	$count;
				$detalle->ver       =  	0;
				$detalle->anadir    =  	0;
				$detalle->modificar =  	0;
				$detalle->eliminar  =  	0;
				$detalle->todas     = 	0;
				$detalle->save();
				$count 				= 	$count +1;
			}

 			return Redirect::to('/gestion-de-roles/'.$idopcion)->with('bienhecho', 'Rol '.$request['nombre'].' registrado con exito');
		}else{

		
			return View::make('usuario/agregarrol',
						[
						  	'idopcion' => $idopcion
						]);

		}
	}


	public function actionModificarRol($idopcion,$idrol,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $idrol = $this->funciones->decodificarmaestra($idrol);

		if($_POST)
		{
			//dd($idrol);

			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'nombre' => 'unique:rols,nombre,'.$idrol.',id',
			], [
            	'nombre.unique' => 'Rol ya registrado',
        	]);
			/******************************/

			$cabecera            	 =	Rol::find($idrol);
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->activo 	 	 =  $request['activo'];			
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-roles/'.$idopcion)->with('bienhecho', 'Rol '.$request['nombre'].' modificado con éxito');

		}else{
				$rol = Rol::where('id', $idrol)->first();

		        return View::make('usuario/modificarrol', 
		        				[
		        					'rol'  => $rol,
						  			'idopcion' => $idopcion
		        				]);
		}
	}
	

	public function actionListarPermisos($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listaroles = Rol::where('id','<>',1)->orderBy('id', 'asc')->get();

		return View::make('usuario/listapermisos',
						 [
						 	'listaroles' => $listaroles,
						 	'idopcion' => $idopcion,
						 ]);
	}


	public function actionAjaxListarOpciones(Request $request)
	{
		$idrol =  $request['idrol'];
		$idrol = $this->funciones->decodificarmaestra($idrol);

		$listaopciones = RolOpcion::where('rol_id','=',$idrol)->get();

		return View::make('usuario/ajax/listaopciones',
						 [
							 'listaopciones'   => $listaopciones
						 ]);
	}

	public function actionAjaxActivarPermisos(Request $request)
	{

		$idrolopcion =  $request['idrolopcion'];
		$idrolopcion = $this->funciones->decodificarmaestra($idrolopcion);

		$cabecera            	 =	RolOpcion::find($idrolopcion);
		$cabecera->ver 	     	 =  $request['ver'];
		$cabecera->anadir 	 	 =  $request['anadir'];	
		$cabecera->modificar 	 =  $request['modificar'];
		$cabecera->todas 	 	 =  $request['todas'];	
		$cabecera->save();

		echo("gmail");

	}




	public function pruebas()
	{

            $doc            	=   Documento::where('id', 11)->first();
            dd($doc->sunatdocumentoreferencia->nota_cre_deb);

		dd("hola");
		/*$listaopciones 	= RolOpcion::where('rol_id','=',2)->get();
		$listaopcion 	= Opcion::where('id','=',1)->first();
		foreach($listaopciones as $item){
			dd($item->opcion->grupoopcion->nombre);
		}*/
	}
}
