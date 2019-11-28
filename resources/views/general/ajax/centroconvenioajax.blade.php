  <label class="control-label">Centro</label>
  <div class="col-sm-12">
    {!! Form::select( 'centroconvenio_id', $combocentroconvenio, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'centroconvenio_id',
                        'required'    => '',
                        'data-aw'     => '10'
                      ]) !!}
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#precio').val(reclacularprecio("{!!$precio!!}"));
    });
  </script> 