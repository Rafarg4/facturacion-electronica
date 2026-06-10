 <!-- Bootstrap 5 CSS -->
<style>
/* Solo el estilo necesario para el switch */
.form-check-input[type=checkbox] {
  width: 2.5em;
  height: 1.5em;
  background-color: #dee2e6;
  border-radius: 3em;
  position: relative;
  appearance: none;
  transition: background-color .15s ease-in-out;
}

.form-check-input[type=checkbox]::before {
  content: "";
  position: absolute;
  width: 1em;
  height: 1em;
  background-color: white;
  border-radius: 50%;
  top: 0.25em;
  left: 0.25em;
  transition: transform 0.15s ease-in-out;
}

.form-check-input[type=checkbox]:checked {
  background-color: #0d6efd;
}

.form-check-input[type=checkbox]:checked::before {
  transform: translateX(1em);
}
</style>
 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Nombre</th>
        <th>Descripcion</th>
        <th>Categoria</th>
        <th>Cantidad</th>
        <th>Cantidad Minima</th>
        <th>Precio Venta</th>
        <th>Precio Compra</th>
        <th>Rubro</th>
        <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productos as $producto)
            <tr>
            <td>{{ $producto->nombre }}</td>
            <td>{{ $producto->descripcion }}</td>
            <td>{{ $producto->categoria_nombre }}</td>
            <td>{{ $producto->cantidad }}</td>
            <td>{{ $producto->cantidad_minima }}</td>
            <td>{{ number_format($producto->precio_venta) }}</td>
            <td>{{ number_format($producto->precio_compra) }}</td>
            <td>{{ $producto->rubro_descripcion }}</td>
            <td>
            <div class="form-check form-switch">
              <input 
                class="form-check-input" 
                type="checkbox" 
                id="estadoSwitch{{ $producto->id }}" 
                {{ $producto->estado === 'Activo' ? 'checked' : '' }} 
                onchange="cambiarEstado({{ $producto->id }}, this.checked)">
              <label class="form-check-label" for="estadoSwitch{{ $producto->id }}">
                {{ $producto->estado }}
              </label>
            </div>
            </td> 
                <td width="120">
                    {!! Form::open(['route' => ['productos.destroy', $producto->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('productos.show', [$producto->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('productos.edit', [$producto->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Estas seguro?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
function cambiarEstado(id, activo) {
  const estado = activo ? 'Activo' : 'Inactivo';

  fetch(`/productos/${id}/cambiarEstado`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ estado })
  })
  .then(res => res.json())
  .then(data => {
    // Actualizar el texto de la etiqueta
    document.querySelector(`#estadoSwitch${id}`).nextElementSibling.innerText = estado;
    console.log(data.message);
  })
  .catch(err => console.error('Error:', err));
}
</script>