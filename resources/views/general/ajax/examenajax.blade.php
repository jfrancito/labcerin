<label class="control-label">Examen</label>
<div class="col-sm-12">
  {!! Form::select( 'examen_id', $comboexamen, array(),
                    [
                      'class'       => 'form-control control input-sm' ,
                      'id'          => 'examen_id',
                      'required'    => '',
                      'data-aw'     => '10'
                    ]) !!}
</div>