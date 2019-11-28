<table class="table table-hover">
  <thead>
    <tr>
      <th style = 'display:none;'>CODIGO</th>       
      <th>DNI</th>
      <th>Paciente</th>
      <th style = 'display:none;'>FN</th>
      <th style = 'display:none;'>direccion</th>
      <th style = 'display:none;'>email</th>              
    </tr>
  </thead>
  <tbody>
      @foreach($listapacientes as $item)
        <tr>  
          <td class='bcodpaciente' style = 'display:none;'>{{$item->Cod_Paciente}}</td>          
          <td class='bdni'>{{$item->dni}}</td>
          <td class='bnombre'>{{$item->nombre}} {{$item->apPaterno}} {{$item->apMaterno}}</td>
          <td class='bfn' style = 'display:none;'>{{$item->fechaNac}}</td>
          <td class='direccion'>{{$item->direccion}}</td>
          <td class='mail' style = 'display:none;'>{{$item->mail}}</td>          
        </tr>
      @endforeach   
  </tbody>
</table>