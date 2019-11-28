<label class="control-label">Nro. Documento</label>
<div class="col-sm-12">

  <input  type="text"
          id="nrodocumento" name='nrodocumento' value="{{$comprobante->serie.'-'.$comprobante->numero}}" placeholder="Nro. Documento"
          required = ""
          disabled="disabled"
          autocomplete="off" class="form-control input-sm" data-aw="2"/>

</div>