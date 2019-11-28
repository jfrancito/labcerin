@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
@stop
@section('section')


	<div class="be-content">
		<div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">Lista de Consultas
                  <div class="tools">
                    <a href="{{ url('/agregar-consulta/'.$idopcion) }}" data-toggle="tooltip" data-placement="top" title="Crear Consulta">
                      <span class="icon mdi mdi-plus-circle-o"></span>
                    </a>

                  </div>
                </div>
                <div class="panel-body">
                  <table id="table1" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>DNI</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>                                                
                        <th>Opción</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($listaconsulta as $index => $item) 
                        <tr>
                          <td>{{$index + 1}}</td>
                          <td>{{$item->dni}}</td>
                          <td>{{$item->nombre}} {{$item->apPaterno}} {{$item->apMaterno}}</td>
                          <td>{{date_format(date_create($item->fecha_Examen),'d-m-Y')}}</td>
                          <td>{{date_format(date_create($item->hora_Examen),'H:i:s')}}</td>
                          <td>
                              @if($item->estado=="A")
                                <b class = 'activo'>Atendida </b>
                              @else
                                <b class = 'inactivo'> Pendiente </b>
                              @endif
                          </td>                                                 
                          <td class="rigth">
                            <div class="btn-group btn-hspace">
                              <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                              <ul role="menu" class="dropdown-menu pull-right">
                                <li>
                                  <a href="">Imprimir voucher</a>
                                </li>
                              </ul>
                            </div>
                          </td>
                        </tr>                    
                      @endforeach

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
		</div>
	</div>

@stop

@section('script')


	<script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip(); 
      });
    </script> 
@stop