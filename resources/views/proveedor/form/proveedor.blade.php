<div class="form-group">
  <label class="col-sm-3 control-label">RUC</label>
  <div class="col-sm-6 input-group">

    <input  type="text"
            id="ruc" name='ruc' value="@if(isset($persona)){{old('ruc' ,$persona->ruc)}}@else{{old('ruc')}}@endif" placeholder="ruc"
            data-parsley-minlength="11" data-parsley-maxlength="11" data-parsley-type="number"
            autocomplete="off" class="form-control input-sm" data-aw="3"/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('ruc')  , 
                                          'error' => $errors->first('ruc', ':message') , 
                                          'data' => '3'])

      <span class="input-group-btn">
       <button id='buscarproveedor' type="button" style='height: 37px;' class="btn btn-primary "><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Buscar</font></font></button></span>


  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Razón Social</label>
  <div class="col-sm-6">

    <input  type="text"
            id="razonsocial" name='razonsocial' value="@if(isset($persona)){{old('razonsocial' ,$persona->razonsocial)}}@else{{old('razonsocial')}}@endif" placeholder="Razón Social"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="1"/>

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Nombre Comercial</label>
  <div class="col-sm-6">

    <input  type="text"
            id="nombrecomercial" name='nombrecomercial' value="@if(isset($persona)){{old('nombrecomercial' ,$persona->nombreComercial)}}@else{{old('nombrecomercial')}}@endif" placeholder="Nombre Comercial"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="2"/>

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Tipo contribuyente</label>
  <div class="col-sm-6">

    <input  type="text"
            id="tipocontribuyente" name='tipocontribuyente' value="@if(isset($persona)){{old('tipocontribuyente' ,$persona->tipoContribuyente)}}@else{{old('tipocontribuyente')}}@endif" placeholder="Tipo contribuyente"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="2"/>

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Estado contribuyente</label>
  <div class="col-sm-6">

    <input  type="text"
            id="estadocontribuyente" name='estadocontribuyente' value="@if(isset($persona)){{old('estadocontribuyente' ,$persona->estado)}}@else{{old('estadocontribuyente')}}@endif" placeholder="Estado contribuyente"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="2"/>

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Dirección</label>
  <div class="col-sm-6">

    <input  type="text"
            id="direccion" name='direccion' value="@if(isset($persona)){{old('direccion' ,$persona->direccion)}}@else{{old('direccion')}}@endif" placeholder="Dirección"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="2"/>

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Telefono</label>
  <div class="col-sm-6">

    <input  type="text"
            id="telefono" name='telefono' value="@if(isset($persona)){{old('telefono' ,$persona->Telefono)}}@else{{old('telefono')}}@endif" placeholder="Telefono"

            autocomplete="off" class="form-control input-sm" data-aw="2"/>

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