@extends('layouts.app')

@section('content')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS (con Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Crear Venta</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'ventas.store']) !!}

            <div class="card-body">

                <div class="row">
                    <!-- Id Cliente Field -->
               <div class="form-group col-sm-6">
                  {!! Form::label('id_cliente', 'Clientes:') !!}
                  <select name="id_cliente" class="form-control" required>
                      <option value="">Seleccione un cliente</option>
                      @foreach($clientes as $cliente)
                          <option value="{{ $cliente->id }}">{{ $cliente->ci }} - {{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                      @endforeach
                  </select>
              </div>
                <!-- Fecha Venta Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('fecha_venta', 'Fecha venta:') !!}
                    {!! Form::text('fecha_venta', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
                </div>

                <!-- Id Usuario Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('id_usuario', 'Cajero:') !!}
                    {!! Form::text('id_usuario', Auth::user()->id, ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
                </div>
                 {!! Form::hidden('id_caja', Auth::user()->caja) !!}
                <!-- Tipo Comprobante Field -->
               <div class="form-group col-sm-3">
                    {!! Form::label('tipo_comprobante', 'Tipo de Comprobante:') !!}
                    <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="Recibo">Recibo</option>
                        <option value="Factura">Factura</option>
                        <option value="Ticket">Ticket</option>
                    </select>
                </div>
                  <script>
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });

                  $('#tipo_comprobante').on('change', function () {
                      var tipo = $(this).val();

                      if (tipo) {
                          $.ajax({
                              url: '/obtenerSiguienteNumero',
                              type: 'GET',
                              data: { tipo_comprobante: tipo },
                              success: function (response) {
                                  $('#numero_comprobante').val(response.numero);
                              },
                              error: function () {
                                  alert('Error al obtener el número de comprobante');
                              }
                          });
                      } else {
                          $('#numero_comprobante').val('');
                      }
                  });
              </script>
                <div class="form-group col-sm-3">
                    {!! Form::label('numero_comprobante', 'Número Comprobante:') !!}
                    <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" readonly>
                </div>

                <!-- Iva Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('iva', 'IVA:') !!}
                    {!! Form::select('iva', [
                        '10' => '10%',
                        '5' => '5%',
                        'Exenta' => 'Exenta'
                    ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione el IVA', 'required' => 'required']) !!}
                </div>

                <div class="form-group col-sm-3">
                    {!! Form::label('forma_pago', 'Forma de Pago:') !!}
                    {!! Form::select('forma_pago', [
                        'Efectivo' => 'Efectivo',
                        'Tarjeta' => 'Tarjeta',
                        'Transferencia' => 'Transferencia'
                    ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una forma de pago', 'required' => 'required']) !!}
                </div>
               
                <div class="form-group col-sm-3">
                    {!! Form::label('condicion_venta', 'Condición:') !!}
                    {!! Form::select('condicion_venta', ['contado' => 'Contado', 'credito' => 'Crédito'], null, ['class' => 'form-control', 'id' => 'condicion', 'required' => 'required']) !!}
                </div>

                <div class="form-group col-sm-3" id="plazo-group" style="display: none;">
                    {!! Form::label('plazo', 'Plazo:') !!}
                    {!! Form::select('plazo', ['30' => '30 días', '60' => '60 días', '90' => '90 días'], null, ['class' => 'form-control']) !!}
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const condicionSelect = document.getElementById('condicion');
                        const plazoGroup = document.getElementById('plazo-group');

                        condicionSelect.addEventListener('change', function () {
                            if (this.value === 'credito') {
                                plazoGroup.style.display = 'block';
                            } else {
                                plazoGroup.style.display = 'none';
                            }
                        });

                        // Por si ya está seleccionado al cargar
                        if (condicionSelect.value === 'credito') {
                            plazoGroup.style.display = 'block';
                        }
                    });
                </script>
                <!-- Observacion Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('observacion', 'Observacion:') !!}
                    {!! Form::text('observacion', null, ['class' => 'form-control','required' => 'required']) !!}
                </div>

                </div>

            <!-- Botón para abrir el modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProductos">
                Agregar producto
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="modalProductosLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalProductosLabel">Seleccionar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-bordered" id="table">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Cantidad disponible</th>
                          <th>Precio</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($productos as $producto)
                        <tr>
                          <td>{{ $producto->id }}</td>
                          <td>{{ $producto->nombre }}</td>
                           <td>{{ $producto->cantidad }}</td>
                          <td>{{ number_format($producto->precio_venta) }}</td>
                          <td>
                            <button type="button" class="btn btn-primary btn-sm seleccionar-producto"
                              data-id="{{ $producto->id }}"
                              data-nombre="{{ $producto->nombre }}"
                              data-precio="{{ $producto->precio_venta }}">
                              <i class="fas fa-plus"></i>
                            </button>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <hr>

            <center><h4>Productos seleccionados</h4></center>
            <table class="table table-bordered" id="tabla-detalles">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                  <th>Subtotal</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                {{-- Filas dinámicas aquí --}}
              </tbody>
            </table>
            <hr>
            <!-- Total Field -->
            <div class="container">
                <div class="row justify-content-end">
                    <div class="form-group col-sm-3">
                        <div class="d-flex justify-content-end align-items-center">
                            <span class="mr-2" style="font-size: 24px;">Total:</span>
                            {!! Form::text('total', null, [
                                'class' => 'form-control',
                                'readonly' => true,
                                'style' => 'text-align: right; font-weight: bold; font-size: 20px; width: 120px;'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones finales -->
            <div class="card-footer">
              {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
              <a href="{{ route('ventas.index') }}" class="btn btn-default">Cancelar</a>
            </div>

            {!! Form::close() !!}

            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

            <!-- Script -->
          <script>
          function recalcularTotal() {
            let total = 0;
            const filas = document.querySelectorAll('#tabla-detalles tbody tr');

            filas.forEach(fila => {
              const cantidadInput = fila.querySelector('input[name="cantidad[]"]');
              const precioInput = fila.querySelector('input[name="precio_unitario[]"]');
              const subtotalInput = fila.querySelector('input[name="subtotal[]"]');

              const cantidad = parseFloat(cantidadInput.value) || 0;
              const precio = parseFloat(precioInput.value) || 0;
              const subtotal = cantidad * precio;

              subtotalInput.value = subtotal.toFixed(0);
              total += subtotal;
            });

            document.querySelector('input[name="total"]').value = total.toFixed(0);
          }

          document.addEventListener('click', function (e) {
            if (e.target.classList.contains('seleccionar-producto') || e.target.closest('.seleccionar-producto')) {
              const boton = e.target.closest('.seleccionar-producto');
              const id = boton.dataset.id;
              const nombre = boton.dataset.nombre;
              const precio = parseFloat(boton.dataset.precio);

              let productoExistente = false;

              // Buscar si ya existe una fila con el mismo producto
              const filas = document.querySelectorAll('#tabla-detalles tbody tr');
              filas.forEach(fila => {
                const idInput = fila.querySelector('input[name="id_producto[]"]');
                if (idInput.value === id) {
                  // Ya existe: aumentar cantidad y recalcular
                  const cantidadInput = fila.querySelector('input[name="cantidad[]"]');
                  const nuevaCantidad = parseInt(cantidadInput.value) + 1;
                  cantidadInput.value = nuevaCantidad;
                  productoExistente = true;
                }
              });

              if (!productoExistente) {
                // Agrega nueva fila si no existe el producto
                const fila = `
                  <tr>
                    <td><input type="hidden" name="id_producto[]" value="${id}">${nombre}</td>
                    <td><input type="number" name="cantidad[]" class="form-control" min="1" value="1" /></td>
                    <td><input type="text" name="precio_unitario[]" class="form-control" value="${precio}" /></td>
                    <td><input type="text" name="subtotal[]" class="form-control" readonly /></td>
                    <td><button type="button" class="btn btn-danger btn-sm eliminar-fila"><i class="fas fa-trash"></i></button></td>
                  </tr>
                `;
                document.querySelector('#tabla-detalles tbody').insertAdjacentHTML('beforeend', fila);
              }

              recalcularTotal(); // Actualiza total
            }

            if (e.target.classList.contains('eliminar-fila') || e.target.closest('.eliminar-fila')) {
              const fila = e.target.closest('tr');
              fila.remove();
              recalcularTotal();
            }
          });

          document.addEventListener('input', function (e) {
            if (e.target.name === 'cantidad[]' || e.target.name === 'precio_unitario[]') {
              recalcularTotal();
            }
          });
          </script>

    @endsection
