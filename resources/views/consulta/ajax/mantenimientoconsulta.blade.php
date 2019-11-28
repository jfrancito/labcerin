  <div class="panel panel-contrast">
    <div class="panel-heading panel-heading-contrast">
          <strong class='glosa'>{{$consulta->EXAMEN}}</strong>
          <span class="panel-subtitle fecha_estado">
          {{$consulta->PACIENTE}}
          </span>                          
          <span class="mdi mdi-close-circle mdi-close-cliente"></span>



          <form method="POST" action="{{ url('/ajax-guardar-resultado-examen/'.$idopcion) }}" class="form-horizontal group-border-dashed form-pedido">

            {{ csrf_field() }}
            <input type="hidden" name="examen_id" id='examen_id' value='{{$consulta->codresexamen}}'>
            <input type="hidden" name="observacion" id='observacion' value=''>
            <input type="hidden" name="xml_productos" id='xml_productos' value="">
            <button type="submit" class="btn btn-space btn-success btn-big btn-guardar btn-guardar-re">
              <i class="icon mdi mdi-check"></i> Guardar
            </button>


          </form>

    </div>
  </div>
  <div class="panel-body">
      
    <div class="scroll_text_q">
        @foreach($listadetalleconsulta as $index => $item) 
        <div  class='col-sm-12 productoseleccion col-mobil-top'
              data_id_coddetalleexamen                 = "{{$item->coddetresultado}}"
              >

             <div class='panel panel-default panel-contrast'>
                  <div class='panel-heading cell-detail'>
                    {{$item->item}}
                    <span class='panel-subtitle cell-detail-producto'>Valor Ref. : {{$item->valorref}}</span>

                    <span class='panel-subtitle cell-detail-producto'>Valor :
                      <input  type="text"
                              id="valor" name='valor' 
                              value="{{$item->valor}}" 
                              placeholder="valor"
                              required = "" class="form-control input-sm" data-parsley-type="number"
                              autocomplete="off" data-aw="1"/>

                    </span>

                  </div>
             </div>
        </div>
        @endforeach
        <div class="row">
          <div  class='col-sm-12'>
                      <span class='panel-subtitle cell-detail-producto'>Observacion :
                        <textarea name='obs' id = 'obs' required="" class="form-control"></textarea>
                      </span>
          </div>
        </div>
    </div>
  </div>

<script type="text/javascript">

  $(document).ready(function(){
    //initialize the javascript
    $('.importe').inputmask({ 'alias': 'numeric', 
    'groupSeparator': ',', 'autoGroup': true, 'digits': 4, 
    'digitsOptional': false, 
    'prefix': '', 
    'placeholder': '0'});

  });
</script>
