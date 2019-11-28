<table class="table table-hover">
  <thead>
    <tr>
      <th style = 'display:none;'>CODIGO</th>       
      <th>DNI</th>
      <th>Medico</th>     
    </tr>
  </thead>
  <tbody>
      @foreach($listamedicos as $item)
        <tr>  
          <td class='bcodm' style = 'display:none;'>{{$item->Cod_Medico}}</td>          
          <td class='bdnim'>{{$item->dni}}</td>
          <td class='bnombrem'>{{$item->nombre}} {{$item->apPaterno}} {{$item->apMaterno}}</td>      
        </tr>
      @endforeach   
  </tbody>
</table>
