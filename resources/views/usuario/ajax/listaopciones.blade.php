<table class="table">
  <thead>
    <tr>
      <th style="text-center">Opciones</th>
      <th class="text-center" >
        <span data-toggle="tooltip" data-placement="top" title="Ver">V</span> 
      </th>
      <th class="text-center" >
        <span data-toggle="tooltip" data-placement="top" title="Agregar">A</span> 
      </th>
      <th class="text-center" >
        <span data-toggle="tooltip" data-placement="top" title="Modificar">M</span> 
      </th>
        <th class="text-center" >
        <span data-toggle="tooltip" data-placement="top" title="Todas">T</span> 
      </th>
    </tr>
  </thead>
  <tbody>

    @foreach($listaopciones as $item)
      <tr>
        <td class="cell-detail">
          <span>{{$item->opcion->nombre}}</span>
          <span class="cell-detail-description">({{$item->opcion->grupoopcion->nombre}})</span>
        </td>
        <td>
          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode($item->id)}}"
                    id="1{{Hashids::encode($item->id)}}"
                    @if ($item->ver == 1) checked @endif
            >
            <label  for="1{{Hashids::encode($item->id)}}"
                    data-atr = "ver"
                    class = "checkbox"                    
                    name="{{Hashids::encode($item->id)}}"
              ></label>
          </div>
        </td> 
        <td>
          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode($item->id)}}"
                    id="2{{Hashids::encode($item->id)}}"
                    @if ($item->anadir == 1) checked @endif
            >
            <label  for="2{{Hashids::encode($item->id)}}"
                    data-atr = "anadir"
                    class = "checkbox"                   
                    name="{{Hashids::encode($item->id)}}"
              ></label>
          </div>
        </td> 
        <td>
          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode($item->id)}}"
                    id="3{{Hashids::encode($item->id)}}"
                    @if ($item->modificar == 1) checked @endif
            >
            <label  for="3{{Hashids::encode($item->id)}}"
                    data-atr = "modificar"
                    class = "checkbox"                    
                    name="{{Hashids::encode($item->id)}}"

              ></label>
          </div>
        </td> 
        <td>
          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode($item->id)}}"
                    id="4{{Hashids::encode($item->id)}}"
                    @if ($item->todas == 1) checked @endif
            >
            <label  for="4{{Hashids::encode($item->id)}}"
                    data-atr = "todas"
                    class = "checkbox"                      
                    name="{{Hashids::encode($item->id)}}"
              ></label>
          </div>
        </td>
      </tr>                    
    @endforeach


  </tbody>
</table>