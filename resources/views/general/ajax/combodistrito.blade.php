  <label class="col-sm-3 control-label">Distrito</label>
  <div class="col-sm-6">
    {!! Form::select( 'distrito_id', $combodistrito, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'distrito_id',
                        'required'    => '',
                        'data-aw'     => '12'
                      ]) !!}
  </div>