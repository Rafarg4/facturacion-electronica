<!-- Id Proveedor Field -->
<div class="form-group col-sm-6">
                  {!! Form::label('id_proveedor', 'Proveedor:') !!}
                  <select name="id_proveedor" class="form-control" required>
                      <option value="">Seleccione un Proveedor</option>
                      @foreach($proveedores as $proveedor)
                          <option value="{{ $proveedor->id }}">{{ $proveedor->ci }} - {{ $proveedor->nombre }} {{ $proveedor->apellido }}</option>
                      @endforeach
                  </select>
              </div>
<!-- Fecha Field -->
 <div class="form-group col-sm-3">
                    {!! Form::label('fecha', 'Fecha venta:') !!}
                    {!! Form::text('fecha', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
 </div>
<!-- Total Field -->
<div class="form-group col-sm-3">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::text('total', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::text('estado', null, ['class' => 'form-control']) !!}
</div>
<h5>Productos</h5>
<table class="table table-bordered" id="productos-table">
  <thead>
    <tr>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Subtotal</th>
      <th>Acción</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <select name="productos[0][producto_id]" class="form-control" required>
          <option value="">Seleccione</option>
          @foreach($productos as $producto)
            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
          @endforeach
        </select>
      </td>
      <td><input type="number" name="productos[0][cantidad]" class="form-control cantidad" min="1" required></td>
      <td><input type="number" name="productos[0][precio_unitario]" class="form-control precio" min="0" step="0.01" required></td>
      <td><input type="text" class="form-control subtotal" readonly></td>
      <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
    </tr>
  </tbody>
</table>
<button type="button" class="btn btn-sm btn-success" id="add-product">+ Agregar producto</button>
<script>
let index = 1;

document.getElementById('add-product').addEventListener('click', () => {
    let table = document.querySelector('#productos-table tbody');
    let newRow = table.rows[0].cloneNode(true);

    // Actualizar los nombres de los campos
    newRow.querySelectorAll('select, input').forEach(input => {
        input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
        input.value = '';
    });

    table.appendChild(newRow);
    index++;
});

// Eliminar fila
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row')) {
        let rows = document.querySelectorAll('#productos-table tbody tr');
        if (rows.length > 1) e.target.closest('tr').remove();
    }
});

// Calcular subtotal
document.addEventListener('input', function (e) {
    const row = e.target.closest('tr');
    const cantidad = row.querySelector('.cantidad').value;
    const precio = row.querySelector('.precio').value;
    const subtotal = row.querySelector('.subtotal');
    subtotal.value = (cantidad * precio).toFixed(2);
});
</script>
