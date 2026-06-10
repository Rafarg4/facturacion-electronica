@extends('layouts.app')

@section('content')
<style>
/* Asegura que el select2 se vea como form-control */
.select2-container--default .select2-selection--single {
    height: 38px !important;
    padding: 6px 12px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 1rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 24px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
</style>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Crear Pedido</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'pedidos.store']) !!}

            <div class="card-body">

                <div class="row">
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
                    {!! Form::label('fecha', 'Fecha de pedido:') !!}
                    {!! Form::text('fecha', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
 </div>
<!-- Estado Field -->
 <div class="form-group col-sm-3">
                    {!! Form::label('usuario', 'Usuario:') !!}
                    {!! Form::text('usuario', Auth::user()->name, ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
</div>
 {!! Form::hidden('id_usuario', Auth::user()->id) !!}
</div>
<br>
<br>
<button type="button" class="btn btn-sm btn-primary" id="add-product"><i class="fa fa-plus" aria-hidden="true"></i>
 Agregar producto</button>
<center><h5>Seleciona Productos</h5></center>
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
        <select name="productos[0][producto_id]" class="form-control select-producto" required>
            <option value="">Seleccione</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
            @endforeach
        </select>
      </td>
      <td><input type="number" name="productos[0][cantidad]" class="form-control cantidad" min="1" required></td>
      <td><input type="number" name="productos[0][precio_unitario]" class="form-control precio" min="0" step="0.01" required></td>
      <td><input type="text" class="form-control subtotal" readonly></td>
      <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash" aria-hidden="true"></i>
 </button></td>
    </tr>
  </tbody>
</table>

<script>
let index = 1;

document.getElementById('add-product').addEventListener('click', () => {
    let table = document.querySelector('#productos-table tbody');
    let firstRow = table.rows[0];
    let newRow = firstRow.cloneNode(true);

    // Limpiar los campos
    newRow.querySelectorAll('select, input').forEach((input) => {
        // Actualizar el nombre del campo con el nuevo índice
        if (input.name) {
            input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
        }

        if (input.tagName === 'SELECT') {
            $(input).val(null); // limpiar valor
            input.classList.remove("select2-hidden-accessible"); // limpiar clase de Select2
            $(input).next('.select2-container').remove(); // remover contenedor anterior
        } else {
            input.value = '';
        }
    });

    table.appendChild(newRow);

    // Inicializar Select2 SOLO en el nuevo select
    $(newRow).find('.select-producto').select2({
        placeholder: "Seleccione un producto",
        allowClear: true
    });

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
    subtotal.value = (cantidad * precio).toFixed();
});
</script>
<script>
function calcularSubtotal(row) {
    const cantidad = parseFloat(row.querySelector('.cantidad')?.value || 0);
    const precio = parseFloat(row.querySelector('.precio')?.value || 0);
    const subtotal = cantidad * precio;
    if (row.querySelector('.subtotal')) {
        row.querySelector('.subtotal').value = subtotal.toFixed();
    }
    return subtotal;
}

function calcularTotal() {
    let total = 0;
    document.querySelectorAll('#productos-table tbody tr').forEach(row => {
        total += calcularSubtotal(row);
    });
    document.getElementById('total').value = total.toFixed();
}

// Detectar cambios en inputs de cantidad y precio
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
        calcularTotal();
    }
});

// También recalcular al agregar/quitar filas
document.getElementById('add-product').addEventListener('click', () => {
    setTimeout(() => calcularTotal(), 100); // pequeño delay para asegurar que la fila esté lista
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row')) {
        setTimeout(() => calcularTotal(), 100);
    }
});
</script>
    <script>
       $(document).ready(function () {
        $('.select-producto').select2({
            placeholder: "Seleccione un producto",
            allowClear: true,
            width: '100%',
            hight: '38' // Esto asegura que el select tenga el mismo ancho que el form-control
        });
    });

    </script>
<br>
 <div class="container">
                <div class="row justify-content-end">
                    <div class="form-group col-sm-3">
                        <div class="d-flex justify-content-end align-items-center">
                            <span class="mr-2" style="font-size: 24px;">Total:</span>
                            {!! Form::text('total', null, [
                                'class' => 'form-control',
                                'id' => 'total',
                                'readonly' => true,
                                'style' => 'text-align: right; font-weight: bold; font-size: 20px; width: 120px;'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('pedidos.index') }}" class="btn btn-default">Cancelar</a>
            </div>

            {!! Form::close() !!}

        </div>

    </div>
@endsection
