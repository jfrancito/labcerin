  <label class="col-sm-3 control-label">Provincia</label>
  <div class="col-sm-6">
  {!! Form::select( 'provincia_id', $comboprovincia, array(),
                    [
                      'class'       => 'form-control control input-sm' ,
                      'id'          => 'provincia_id',
                      'required'    => '',
                      'data-aw'     => '11'
                    ]) !!}
</div>