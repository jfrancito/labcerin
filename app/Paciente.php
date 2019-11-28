<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
	protected 	$table='Paciente';
	protected 	$primaryKey='Cod_Paciente';
	public 		$timestamps=false;

}
?>