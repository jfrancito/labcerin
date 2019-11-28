<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'opciones';
    public $timestamps=false;

    
    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

    public function grupoopcion()
    {
        return $this->belongsTo('App\Grupoopcion');
    }

    public function rolopcion()
    {
        return $this->hasMany('App\RolOpcion');
    }
    
}
