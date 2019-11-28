<div class="form-group">
  <label class="col-sm-3 control-label">DNI</label>
  <div class="col-sm-6 input-group">

    <input  type="text"
            id="dni" name='dni' value="@if(isset($persona)){{old('dni' ,$persona->dni)}}@else{{old('dni')}}@endif" placeholder="DNI"
            data-parsley-minlength="8" data-parsley-maxlength="8" data-parsley-type="number"
            autocomplete="off" class="solonumero form-control input-sm" data-aw="3" maxlength="8"/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('dni')  , 
                                          'error' => $errors->first('dni', ':message') , 
                                          'data' => '3'])

      <span class="input-group-btn">
       <button id='buscarpaciente' type="button" style='height: 37px;' class="btn btn-primary "><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Buscar</font></font></button>
      </span>


  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Nombres</label>
  <div class="col-sm-6">

    <input  type="text"
            id="nombre" name='nombre' value="@if(isset($persona)){{old('nombre' ,$persona->nombre)}}@else{{old('nombre')}}@endif" placeholder="Nombres"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="1"/>

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Apellido Paterno</label>
  <div class="col-sm-6">

    <input  type="text"
            id="apellidopaterno" name='apellidopaterno' value="@if(isset($persona)){{old('apellidopaterno' ,$persona->apPaterno)}}@else{{old('apellidopaterno')}}@endif" placeholder="Apellido Paterno"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="2"/>

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Apellido Materno</label>
  <div class="col-sm-6">

    <input  type="text"
            id="apellidomaterno" name='apellidomaterno' value="@if(isset($persona)){{old('apellidomaterno' ,$persona->apMaterno)}}@else{{old('apellidomaterno')}}@endif" placeholder="Apellido Materno"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="2"/>

  </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label">Fecha Nacimiento
    </label> 
    <div class="col-sm-6"> 
      <div data-min-view="2" data-date-format="dd-mm-yyyy"  class="input-group date datetimepicker">
                <input size="16" type="text" value="@if(isset($persona)){{old('fechanacimiento' ,date_format(date_create($persona->fechaNac),'d-m-Y'))}}@else{{old('fechanacimiento')}}@endif" placeholder="Fecha Nacimiento"
                id='fechanacimiento' name='fechanacimiento'    
                required = ""  
                disabled="disabled"
                class="form-control input-sm">
                <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
      </div>
    </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Edad</label>
  <div class="col-sm-6">

    <input  type="text"
            id="edad" name='edad' value="0 AÑOS" placeholder="Edad"
            required = ""
            autocomplete="off" class="solonumero form-control input-sm" data-aw="4"/>


  </div>
</div>

<div class="form-group">

  <label class="col-sm-3 control-label">Sexo</label>
  <div class="col-sm-6">
    {!! Form::select( 'sexo_id', $combosexo, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'sexo_id',
                        'required'    => '',
                        'data-aw'     => '7'
                      ]) !!}
  </div>
</div>



<div class="form-group">
  <label class="col-sm-3 control-label">Autogenerado</label>
  <div class="col-sm-6">

    <input  type="text"
            id="autogenerado" name='autogenerado' value="{{ old('autogenerado') }}" placeholder="Autogenerado"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="4"/>


  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Dirección</label>
  <div class="col-sm-6">

    <input  type="text"
            id="direccion" name='direccion' value="@if(isset($persona)){{old('direccion' ,$persona->direccion)}}@else{{old('direccion')}}@endif" placeholder="Dirección"
            autocomplete="off" class="form-control input-sm" data-aw="4"/>


  </div>
</div>


<div class="form-group">

  <label class="col-sm-3 control-label">Departamento</label>
  <div class="col-sm-6">
    {!! Form::select( 'departamento_id', $combodepartamento, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'departamentos_id',
                        'required'    => '',
                        'data-aw'     => '10'
                      ]) !!}
  </div>
</div>

<div class="form-group ajaxprovincia">
 @include('general.ajax.comboprovincia', ['comboprovincia' => $comboprovincia])
</div>

<div class="form-group ajaxdistrito">
  @include('general.ajax.combodistrito', ['combodistrito' => $combodistrito])
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Telefono Fijo</label>
  <div class="col-sm-6">

    <input  type="text"
            id="telefonofijo" name='telefonofijo' value="@if(isset($persona)){{old('telefonofijo' ,$persona->telefono)}}@else{{old('telefonofijo')}}@endif" placeholder="Telefono Fijo"

            autocomplete="off" class="form-control input-sm" data-aw="4"/>


  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Celular</label>
  <div class="col-sm-6">

    <input  type="text"
            id="celular" name='celular' value="@if(isset($persona)){{old('celular' ,$persona->celular)}}@else{{old('celular')}}@endif" placeholder="Celular"

            autocomplete="off" class="form-control input-sm" data-aw="4"/>


  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Email</label>
  <div class="col-sm-6">

    <input  type="text"
            id="email" name='email' value="@if(isset($persona)){{old('email' ,$persona->mail)}}@else{{old('email')}}@endif" placeholder="Email"

            autocomplete="off" class="form-control input-sm" data-aw="4"/>


  </div>
</div>

<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <button type="submit" class="btn btn-space btn-primary">Guardar</button>
    </p>
  </div>
</div>