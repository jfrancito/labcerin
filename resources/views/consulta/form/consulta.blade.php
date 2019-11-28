
<fieldset class="scheduler-border">
  <legend class="scheduler-border">Datos del Paciente</legend>
    <div class="control-group">


      <div class="col-sm-4">
        <div class="form-group">
          <label class="control-label">DNI BUSCAR</label>
          <div class="col-sm-12 input-group">

            <input  type="text"
                    id="dni" name='dni' value="" placeholder="DNI BUSCAR"
                    data-parsley-minlength="8" data-parsley-maxlength="8" data-parsley-type="number"
                    autocomplete="off" class="solonumero form-control input-sm" maxlength="8" data-aw="3"/>

              <span class="input-group-btn">
               <button id='btnbuscarpaciente' 
               type="button" style='height: 37px;' 
               class="btn btn-primary "><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Buscar</font></font></button></span>


          </div>
        </div>
      </div> 

      <div class="col-sm-4">
        <div class="form-group">
          <label class="control-label">DNI</label>
          <div class="col-sm-12">

            <input  type="text"
                    id="dniguardar" name='dniguardar' value="" placeholder="DNI"
                    readonly="readonly"
                    autocomplete="off" class="form-control input-sm" data-aw="1"/>

          </div>
        </div>
      </div>





      <div class="col-sm-4">

        <div class="form-group">
          <label class="control-label">Edad</label>
          <div class="col-sm-12">

            <input  type="text"
                    id="edad" name='edad' value="@if(isset($persona)){{old('edad' ,$persona->edad)}}@else{{old('edad')}}@endif" placeholder="Apellido Paterno"
                    readonly="readonly"
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

          </div>
        </div>

      </div>

      <div class="col-sm-8">
        <div class="form-group">
          <label class="control-label">Nombres</label>
          <div class="col-sm-12">

            <input  type="text"
                    id="nombrepaciente" name='nombrepaciente' value="@if(isset($persona)){{old('nombrepaciente' ,$persona->nombrepaciente)}}@else{{old('nombrepaciente')}}@endif" placeholder="Nombres"
                    readonly="readonly"
                    autocomplete="off" class="form-control input-sm" data-aw="1"/>

          </div>
        </div>
      </div>


    </div>
</fieldset>


<fieldset class="scheduler-border">
  <legend class="scheduler-border">Datos de la Consulta</legend>
    <div class="control-group">


      <div class="col-sm-6">
        <div class="form-group">

          <label class="control-label">Plan de Atencion</label>
          <div class="col-sm-12">
            {!! Form::select( 'planatencion_id', $comboplanatencion, array(),
                              [
                                'class'       => 'form-control control input-sm' ,
                                'id'          => 'planatencion_id',
                                'data-aw'     => '10'
                              ]) !!}
          </div>
        </div>
      </div>        
      <div class="col-sm-6">
        <div class="form-group ajaxcentro">

          <label class="control-label">Centro</label>
          <div class="col-sm-12">
            {!! Form::select( 'centroconvenio_id', $combocentroconvenio, array(),
                              [
                                'class'       => 'form-control control input-sm' ,
                                'id'          => 'centroconvenio_id',
                                'data-aw'     => '10'
                              ]) !!}
          </div>
        </div>
      </div>    


      <div class="col-sm-4">
        <div class="form-group">

          <label class="control-label">Grupo</label>
          <div class="col-sm-12">
            {!! Form::select( 'tipoexamen_id', $combotipoexamen, array(),
                              [
                                'class'       => 'form-control control input-sm' ,
                                'id'          => 'tipoexamen_id',
                                'data-aw'     => '10'
                              ]) !!}
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="form-group ajaxexamen">

          <label class="control-label">Examen</label>
          <div class="col-sm-12">
            {!! Form::select( 'examen_id', $comboexamen, array(),
                              [
                                'class'       => 'form-control control input-sm' ,
                                'id'          => 'examen_id',
                                'data-aw'     => '10'
                              ]) !!}
          </div>
        </div>
      </div>


      <div class="col-sm-4">

        <div class="form-group">
          <label class="control-label">Precio</label>
          <div class="col-sm-12">

            <input  type="text"
                    id="precio" name='precio' value="" placeholder="0.00"
                    autocomplete="off" class="decimal form-control input-sm" data-aw="2"/>

          </div>
        </div>

      </div>

      <div class="col-sm-4">

        <div class="form-group">
            <label class="control-label">Fecha Consulta
            </label> 
            <div class="col-sm-12"> 
              <div data-min-view="2" data-date-format="dd-mm-yyyy"  class="input-group date datetimepicker">
                        <input size="16" type="text"  placeholder="Fecha Consulta"
                        id='fechaconsulta' name='fechaconsulta' 
                        value="{{date_format(date_create($hoy),'d-m-Y')}}"  
                        class="form-control input-sm">
                        <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
              </div>
            </div>
        </div>

      </div>
      <div class="col-sm-4">

        <div class="form-group">
          <label class="control-label">Hora</label>
          <div class="col-sm-12">

            <input  type="time"
                    id="hora" name='hora' value="{{date('H:i')}}" placeholder="Hora"
                    style = 'margin-top: 5px;'
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

          </div>
        </div>

      </div>

      <div class="col-sm-4">

        <div class="form-group">
            <label class="control-label">Fecha Informe
            </label> 
            <div class="col-sm-12"> 
              <div data-min-view="2" data-date-format="dd-mm-yyyy"  class="input-group date datetimepicker">
                        <input size="16" type="text"  value="{{date_format(date_create($hoy),'d-m-Y')}}" placeholder="Fecha Informe"
                        id='fechainforme' name='fechainforme'     
                        class="form-control input-sm">
                        <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
              </div>
            </div>
        </div>

      </div>


      <div class="col-sm-6">
        <div class="form-group">

          <label class="control-label">Informado</label>
          <div class="col-sm-12">
            {!! Form::select( 'informado_id', $comboinformado, array(),
                              [
                                'class'       => 'form-control control input-sm' ,
                                'id'          => 'informado_id',
                                'data-aw'     => '10'
                              ]) !!}
          </div>
        </div>
      </div>

      <div class="col-sm-6">

        <div class="form-group">
          <label class=" control-label">Trantante</label>
          <div class="col-sm-12">
            <div class="be-radio inline">
              <input type="radio" checked="" name="tratante" id="rad6" value='M' class='tratante'>
              <label for="rad6">Medico</label>
            </div>
            <div class="be-radio inline">
              <input type="radio" checked="" name="tratante" id="rad7" value='C' class='tratante'>
              <label for="rad7">Cerin</label>
            </div>
          </div>
        </div>

      </div>




      <div class="col-sm-6">
        <div class="form-group">
          <label class="control-label">Nombre Tratante</label>
          <div class="col-sm-12">

            <input  type="text"
                    id="nombretratante" name='nombretratante' value="CERIN" placeholder="Nombre Tratante"
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
          <label class="control-label">Medico Solicitante</label>
          <div class="col-sm-12 input-group">

            <input  type="text"
                    id="nombremedico" name='nombremedico' value="" placeholder="Medico Solicitante"
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

              <span class="input-group-btn">
               <button id='btnventastabla' 
               type="button" style='height: 37px;' 
               class="btn btn-primary "><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Agregar</font></font></button></span>

          </div>
        </div>
      </div>


      <div class="col-sm-12">
          <table id='listaventasdiarias'  class="table table-striped table-borderless" >
              <thead>
                <tr>
                    <th>ITEM</th>
                    <th>NOMBRE</th>
                    <th>(S/.) P.UNIT.</th>
                    <th>Accion</th> 
                </tr>
              </thead>
              <tbody>

              </tbody>
        
          </table>          
      </div>


    </div>
</fieldset>


<div class="col-sm-6">
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">Datos del Comprobante</legend>
      <div class="control-group">

        <div class="col-sm-12">
          <div class="form-group">

            <label class="control-label">Tipo Documento</label>
            <div class="col-sm-12">
              {!! Form::select( 'tipodocumento_id', $combotipodocumento, array(),
                                [
                                  'class'       => 'form-control control input-sm' ,
                                  'id'          => 'tipodocumento_id',
                                  'data-aw'     => '10'
                                ]) !!}
            </div>
          </div>
        </div>

      <div class="col-sm-12">
        <div class="form-group">
          <label class="control-label">Numero Documento Buscar</label>
          <div class="col-sm-12 input-group">

            <input  type="text"
                    id="numerodocumento" name='numerodocumento'  placeholder="Numero Documento Buscar"
                    data-parsley-type="number"
                    autocomplete="off" class="solonumero form-control input-sm" data-aw="3"/>

              <span class="input-group-btn">
               <button id='btnbuscardocumento' 
               type="button" style='height: 37px;' 
               class="btn btn-primary "><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Buscar</font></font></button></span>


          </div>
        </div>
      </div>


      <div class='ajaxcomprobante'>

        <div class="col-sm-12">
          <div class="form-group">
            <label class="control-label">Razón Social</label>
            <div class="col-sm-12">
              <input  type="text"
                      id="razonsocial" name='razonsocial' value="{{old('razonsocial')}}" placeholder="Razón Social"
                      readonly="readonly"
                      autocomplete="off" class="form-control input-sm" data-aw="2"/>
            </div>
          </div>
        </div>

        <div class="col-sm-12">
          <div class="form-group">
            <label class="control-label">Dirección</label>
            <div class="col-sm-12">
              <input  type="text"
                      id="direccion" name='direccion' value="{{old('direccion')}}" placeholder="Dirección"
                      readonly="readonly"
                      autocomplete="off" class="form-control input-sm" data-aw="2"/>
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label class="control-label">Email</label>
            <div class="col-sm-12">
              <input  type="text"
                      id="email" name='email' value="{{old('email')}}" placeholder="Email"
                      readonly="readonly"
                      autocomplete="off" class="form-control input-sm" data-aw="2"/>
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label class="control-label">Numero Documento</label>
            <div class="col-sm-12">
              <input  type="text"
                      id="numerodocumentoguardar" name='numerodocumentoguardar' value="{{old('numerodocumentoguardar')}}" placeholder="Numero Documento"
                      readonly="readonly"
                      autocomplete="off" class="form-control input-sm" data-aw="2"/>
            </div>
          </div>
        </div>

      </div>

      </div>
  </fieldset>
</div>


<div class="col-sm-6">
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">Datos del Pago</legend>
      <div class="control-group">

        <div class="col-sm-6">
          <div class="form-group">
            <label class=" control-label">Tipo de pago</label>
            <div class="col-sm-12">
              <div class="be-radio inline">
                <input type="radio" checked="" name="tipopago" id="tp6" value='E' class='tipopago'>
                <label for="tp6">Efectivo</label>
              </div>
              <div class="be-radio inline">
                <input type="radio"  name="tipopago" id="tp7" value='V' class='tipopago'>
                <label for="tp7">Visa</label>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">

          <div class="form-group">
            <label class="control-label">Monto total</label>
            <div class="col-sm-12">

              <input  type="text"
                      id="montototal" name='montototal' value="" placeholder="0.00"
                      readonly="readonly"
                      autocomplete="off" class="decimal form-control input-sm" data-aw="2"/>

            </div>
          </div>

        </div>

        <div class="col-sm-6">
          <div class="form-group">

            <label class="control-label">Comprobante</label>
            <div class="col-sm-12">
              {!! Form::select( 'comprobante_id', $combocomprobante, array(),
                                [
                                  'class'       => 'form-control control input-sm' ,
                                  'id'          => 'comprobante_id',
                                  'data-aw'     => '10'
                                ]) !!}
            </div>
          </div>
        </div>
        <div class="col-sm-6">

          <div class="form-group">
            <label class="control-label">A Cuenta</label>
            <div class="col-sm-12">

              <input  type="text"
                      id="acuenta" name='acuenta' value="" placeholder="0.00"
                      autocomplete="off" class="decimal form-control input-sm" data-aw="2"/>

            </div>
          </div>

        </div>




        <div class="col-sm-6">

          <div class="form-group ajaxcomprobanteserie">
            <label class="control-label">Nro. Documento</label>
            <div class="col-sm-12">

              <input  type="text"
                      id="nrodocumento" name='nrodocumento' value="" placeholder="Nro. Documento"
                      readonly="readonly"
                      autocomplete="off" class="form-control input-sm" data-aw="2"/>

            </div>
          </div>

        </div>

        <div class="col-sm-6">

          <div class="form-group">
            <label class="control-label">Saldo</label>
            <div class="col-sm-12">

              <input  type="text"
                      id="saldo" name='saldo' value="" placeholder="0.00"
                      readonly="readonly"
                      autocomplete="off" class="decimal form-control input-sm" data-aw="2"/>

            </div>
          </div>

        </div>

      <div class="col-sm-6">
        <div class="form-group">
          <label class="control-label">Sub total</label>
          <div class="col-sm-12">
            <input  type="text"
                    id="subtotal" name='subtotal' value="{{old('subtotal')}}" placeholder="Sub total"
                    readonly="readonly"
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label class="control-label">Igv</label>
          <div class="col-sm-12">
            <input  type="text"
                    id="igv" name='igv' value="{{old('igv')}}" placeholder="Igv"
                    readonly="readonly"
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>
          </div>
        </div>
      </div>

      <div class="col-sm-12">

              <button id='guardardconsulta' type="submit" style = 'width: 100%;margin-top: 30px;' class="btn btn-space btn-primary">Guardar</button>

      </div>


      </div>
  </fieldset>
</div>


<input type="hidden" value="" name="codpaciente" id="codpaciente">
<input type="hidden" value="2" name="codmedico" id="codmedico">
<input type="hidden" value="" name="xml" id="xml">

@include('consulta.modal.paciente')
@include('consulta.modal.medico')

<table class='listaplanes' style='display:none;'>
  @foreach($listaplanatencion as $item)
    <tr>
      <td class='cod'>{{$item->cod_PlanAtencion}}</td>
      <td class='descuento'>{{$item->descuento}}</td>      
    </tr>  
  @endforeach
</table>

