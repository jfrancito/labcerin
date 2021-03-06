                  
<div class='listaconsulta'>
    <table id="table_group" class="table table table-hover table-fw-widget dt-responsive nowrap" style='width: 100%;'>
      <thead>
        <tr>
          <th>EXAMEN</th>
          <th>ESTADO</th>
          <th>PACIENTE</th>
          <th>PERFIL</th>
          <th>VALIDAR</th>
        </tr>
      </thead>
      <tbody>

        @foreach($listaconsulta as $index => $item) 
          <tr>
            <td>{{$item->examen}}
            </td> 
            <td>{{$item->estadores}}</td>
            <td>

              <?php echo wordwrap($item->paciente.' - '.$item->fechaexamen.' - '.$item->horaexamen.' - '.$item->estadotm ,25,"<br>\n"); ?>

            </td>
            <td>{{$item->perfil}}</td>
            <td>
              
              <span class="badge badge-primary btn-eyes btn-modal btn-detalle-registro-consulta" 
                    data_cod_resultado="{{$item->codresultado}}"
                    data_examenres_id="{{$item->codresexamen}}"
                    >
                <span class="mdi mdi-eye  md-trigger"></span>
              </span>

            </td>
          </tr>                    
        @endforeach

      </tbody>
    </table>
</div>


<div class="row resultado_examen_atender modal_mobil">
  <div class="col-sm-12 col-mobil-top ajax_resultado_examen_atender">

      <div class="panel panel-contrast">
        <div class="panel-heading panel-heading-contrast">
              <strong class='nombre_area'>Nombre cliente</strong>
              <span class="panel-subtitle c_documento-cuenta">documento - cuenta</span>                          
              <span class="mdi mdi-close-circle mdi-close-cliente"></span>
              <span class="mdi mdi-check-circle mdi-check-cliente"
                data_icl=''
                data_pcl=''
              ></span>
        </div>
      </div>
      <div class="panel-body">
          
      </div>

  </div>
</div>


@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif