<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAtencion extends Model
{
	protected 	$table='Plan_Atencion';
	protected 	$primaryKey='cod_PlanAtencion';
	public 		$timestamps=false;

}
?>