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
                  <label for="id_cliente"><i class="fas fa-user"></i> Cliente:</label>
                  <select id="id_cliente" name="id_cliente" class="form-control" required>
                      <option value="">Seleccione un cliente</option>
                      @foreach($clientes as $cliente)
                          <option value="{{ $cliente->id }}">{{ $cliente->ci }} - {{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                      @endforeach
                  </select>
              </div>
                <!-- Fecha Venta Field -->
                <div class="form-group col-sm-3">
                    <label for="fecha_venta"><i class="fas fa-calendar-alt"></i> Fecha:</label>
                    {!! Form::text('fecha_venta', \Carbon\Carbon::now()->format('Y-m-d'), ['id' => 'fecha_venta', 'class' => 'form-control', 'readonly', 'required' => 'required']) !!}
                </div>

                <!-- Id Usuario Field -->
                <div class="form-group col-sm-3">
                    <label for="id_usuario"><i class="fas fa-user-tie"></i> Cajero:</label>
                    {!! Form::text('id_usuario', Auth::user()->id, ['id' => 'id_usuario', 'class' => 'form-control', 'readonly', 'required' => 'required']) !!}
                </div>
                 {!! Form::hidden('id_caja', Auth::user()->caja) !!}
                <!-- Tipo Comprobante Field -->
               <div class="form-group col-sm-3">
                    <label for="tipo_comprobante"><i class="fas fa-receipt"></i> Tipo de comprobante:</label>
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
                    <label for="numero_comprobante"><i class="fas fa-hashtag"></i> N° comprobante:</label>
                    <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" readonly>
                </div>

                <!-- Iva Field -->
                <div class="form-group col-sm-3">
                    <label for="iva"><i class="fas fa-percent"></i> IVA:</label>
                    {!! Form::select('iva', [
                        '10' => '10%',
                        '5' => '5%',
                        'Exenta' => 'Exenta'
                    ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione el IVA', 'required' => 'required']) !!}
                </div>

                <div class="form-group col-sm-3">
                    <label for="forma_pago"><i class="fas fa-credit-card"></i> Forma de pago:</label>
                    {!! Form::select('forma_pago', [
                        'Efectivo' => 'Efectivo',
                        'Tarjeta' => 'Tarjeta',
                        'Transferencia' => 'Transferencia'
                    ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una forma de pago', 'required' => 'required']) !!}
                </div>
               
                <div class="form-group col-sm-3">
                    <label for="condicion"><i class="fas fa-hand-holding-usd"></i> Condición:</label>
                    {!! Form::select('condicion_venta', ['contado' => 'Contado', 'credito' => 'Crédito'], null, ['class' => 'form-control', 'id' => 'condicion', 'required' => 'required']) !!}
                </div>

                <div class="form-group col-sm-3" id="plazo-group" style="display: none;">
                    <label for="plazo"><i class="fas fa-clock"></i> Plazo:</label>
                    {!! Form::select('plazo', ['30' => '30 días', '60' => '60 días', '90' => '90 días'], null, ['id' => 'plazo', 'class' => 'form-control']) !!}
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
                    <label for="observacion"><i class="fas fa-sticky-note"></i> Observación:</label>
                    {!! Form::text('observacion', null, ['id' => 'observacion', 'class' => 'form-control','required' => 'required']) !!}
                </div>

                </div>

            <!-- Botón para abrir el modal -->
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalProductos">
                <i class="fas fa-plus"></i> Agregar producto
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="modalProductosLabel" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 95vw;">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalProductosLabel"><i class="fas fa-shopping-cart"></i> Agregar productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <!-- Lado izquierdo: Búsqueda y Filtros -->
                      <div class="col-lg-8">
                        <div class="mb-3">
                          <input type="text" id="buscar-producto" class="form-control form-control-lg" placeholder="Buscar por nombre, código o ID...">
                        </div>

                        <!-- Filtros avanzados -->
                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-dollar-sign"></i> Rango de precio:</label>
                            <div class="d-flex gap-2">
                              <input type="number" id="filtro-precio-min" class="form-control form-control-sm" placeholder="Mín" min="0">
                              <input type="number" id="filtro-precio-max" class="form-control form-control-sm" placeholder="Máx" min="0">
                              <button class="btn btn-outline-secondary btn-sm" id="btn-filtrar-precio"><i class="fas fa-filter"></i></button>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-boxes"></i> Stock:</label>
                            <select id="filtro-stock" class="form-control form-control-sm">
                              <option value="">Todos</option>
                              <option value="bajo">Stock bajo (1-5)</option>
                              <option value="medio">Stock medio (6-20)</option>
                              <option value="alto">Stock alto (>20)</option>
                            </select>
                          </div>
                        </div>

                        <!-- Botones para cantidad rápida -->
                        <div class="mb-3 p-2 bg-light rounded">
                          <small class="text-muted"><i class="fas fa-bolt"></i> Cantidad rápida:</small>
                          <div class="btn-group d-flex mt-2" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm cantidad-rapida" data-cantidad="1">1</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm cantidad-rapida" data-cantidad="5">5</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm cantidad-rapida" data-cantidad="10">10</button>
                            <input type="number" id="cantidad-custom" class="form-control form-control-sm" placeholder="Custom" min="1" style="max-width: 80px;">
                          </div>
                        </div>

                        <!-- Tabla de productos -->
                        <div style="max-height: 500px; overflow-y: auto;">
                          <table class="table table-bordered table-hover table-sm" id="table">
                            <thead class="table-light sticky-top">
                              <tr>
                                <th style="width: 50px;">ID</th>
                                <th>Nombre</th>
                                <th style="width: 70px;">Stock</th>
                                <th style="width: 80px;">Precio</th>
                                <th style="width: 100px;">Cantidad</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($productos as $producto)
                              <tr class="fila-producto" data-producto-id="{{ $producto->id }}" data-nombre="{{ $producto->descripcion }}" data-precio="{{ $producto->precio1 }}" data-stock="{{ $producto->cantidad }}">
                                <td>{{ $producto->id }}</td>
                                <td><strong>{{ $producto->descripcion }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $producto->cantidad }}</span></td>
                                <td>{{ number_format($producto->precio1) }}</td>
                                <td>
                                  <input type="number" class="form-control form-control-sm cantidad-producto" min="1" value="1" max="{{ $producto->cantidad }}" style="width: 100%;">
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <!-- Lado derecho: Productos Recientes y Preview -->
                      <div class="col-lg-4">
                        <!-- Recientes -->
                        <div class="card mb-3">
                          <div class="card-header border-bottom">
                            <h6 class="mb-0"><i class="fas fa-history"></i> Productos recientes</h6>
                          </div>
                          <div class="card-body p-2" style="max-height: 200px; overflow-y: auto;" id="productos-recientes">
                            <small class="text-muted">No hay recientes aún</small>
                          </div>
                        </div>

                        <!-- Preview del carrito -->
                        <div class="card">
                          <div class="card-header border-bottom">
                            <h6 class="mb-0"><i class="fas fa-eye"></i> Vista previa</h6>
                          </div>
                          <div class="card-body p-2" style="max-height: 300px; overflow-y: auto;" id="preview-carrito">
                            <small class="text-muted">Selecciona un producto para previsualizar</small>
                          </div>
                          <div class="card-footer">
                            <button type="button" class="btn btn-outline-secondary w-100" id="btn-agregar-modal">
                              <i class="fas fa-plus-circle"></i> Agregar seleccionado
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr>

            <div class="text-center mb-3"><h4><i class="fas fa-box-open"></i> Productos seleccionados</h4></div>
            <table class="table table-bordered table-hover" id="tabla-detalles">
              <thead class="table-light">
                <tr>
                  <th>Producto</th>
                  <th style="width: 150px;">Cantidad</th>
                  <th>Precio Unitario</th>
                  <th>Subtotal</th>
                  <th style="width: 80px;">Acciones</th>
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

            <!-- Toastr CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

            <!-- Script -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

            <style>
              .btn-quantity {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
              }
              .cantidad-display {
                text-align: center;
                font-weight: bold;
                min-width: 40px;
              }
              .table-detalles-row {
                vertical-align: middle;
              }
              #tabla-detalles tbody tr:hover {
                background-color: #f5f5f5;
              }
              .fila-producto:hover {
                background-color: #f1f1f1 !important;
                cursor: pointer;
              }
              .fila-producto.seleccionada {
                background-color: #e9ecef;
              }
              .btn-reciente {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
              }
              .preview-item {
                padding: 10px;
                border: 1px solid #dee2e6;
                border-radius: 5px;
                margin-bottom: 10px;
                background: #f8f9fa;
              }
              .sticky-top {
                position: sticky;
                top: 0;
                z-index: 10;
              }
            </style>

          <script>
          // ============ CONFIGURACIÓN INICIAL ============
          
          // Configuración de Toastr
          toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          };

          // Mapeo de productos
          const productosDisponibles = {
            @foreach($productos as $producto)
              {{ $producto->id }}: { nombre: '{{ $producto->descripcion }}', stock: {{ $producto->cantidad }}, precio: {{ $producto->precio1 }} },
            @endforeach
          };

          // Estado del modal
          let productoSeleccionado = null;
          let productosRecientes = JSON.parse(localStorage.getItem('productosRecientes')) || [];

          // ============ FUNCIONES AUXILIARES ============

          function actualizarRecientes() {
            const container = document.getElementById('productos-recientes');
            if (productosRecientes.length === 0) {
              container.innerHTML = '<small class="text-muted">No hay recientes aún</small>';
              return;
            }
            container.innerHTML = productosRecientes.map(prod => `
              <button type="button" class="btn btn-light btn-reciente w-100 text-start mb-2 btn-reciente-producto" 
                data-id="${prod.id}" data-nombre="${prod.nombre}" data-precio="${prod.precio}" data-stock="${prod.stock}">
                <small>
                  <strong>${prod.nombre}</strong><br/>
                  <span class="text-muted">$${prod.precio}</span> - 
                  <span class="badge bg-secondary">${prod.stock}</span>
                </small>
              </button>
            `).join('');
          }

          function mostrarPreview(id, nombre, precio, stock) {
            productoSeleccionado = { id, nombre, precio, stock };
            const cantidadInput = document.querySelector(`tr[data-producto-id="${id}"] .cantidad-producto`);
            const cantidad = parseInt(cantidadInput.value) || 1;

            const container = document.getElementById('preview-carrito');
            container.innerHTML = `
              <div class="preview-item">
                <h6><strong>${nombre}</strong></h6>
                <p class="mb-1"><small><strong>ID:</strong> ${id}</small></p>
                <p class="mb-1"><small><strong>Precio:</strong> $${precio}</small></p>
                <p class="mb-3"><small><strong>Stock disponible:</strong> <span class="badge bg-secondary">${stock}</span></small></p>
                <p class="mb-2"><small><strong>Cantidad:</strong> <span class="badge bg-primary">${cantidad}</span></small></p>
                <hr>
                <p class="text-end mb-0"><strong>Subtotal: <span class="text-success">$${(precio * cantidad).toFixed(0)}</span></strong></p>
              </div>
            `;
          }

          function filtrarProductos() {
            const filtro = document.getElementById('buscar-producto').value.toLowerCase();
            const minPrecio = parseInt(document.getElementById('filtro-precio-min').value) || 0;
            const maxPrecio = parseInt(document.getElementById('filtro-precio-max').value) || 999999;
            const filtroStock = document.getElementById('filtro-stock').value;
            const filas = document.querySelectorAll('#table tbody .fila-producto');

            filas.forEach(fila => {
              const nombre = fila.dataset.nombre.toLowerCase();
              const precio = parseInt(fila.dataset.precio);
              const stock = parseInt(fila.dataset.stock);
              const texto = fila.innerText.toLowerCase();

              let cumpleFiltro = texto.includes(filtro) && precio >= minPrecio && precio <= maxPrecio;

              if (filtroStock === 'bajo') cumpleFiltro = cumpleFiltro && stock >= 1 && stock <= 5;
              if (filtroStock === 'medio') cumpleFiltro = cumpleFiltro && stock >= 6 && stock <= 20;
              if (filtroStock === 'alto') cumpleFiltro = cumpleFiltro && stock > 20;

              fila.style.display = cumpleFiltro ? '' : 'none';
            });
          }

          // ============ EVENT LISTENERS ============

          // Búsqueda en tiempo real
          document.getElementById('buscar-producto').addEventListener('keyup', filtrarProductos);

          // Filtros
          document.getElementById('filtro-precio-min').addEventListener('change', filtrarProductos);
          document.getElementById('filtro-precio-max').addEventListener('change', filtrarProductos);
          document.getElementById('filtro-stock').addEventListener('change', filtrarProductos);
          document.getElementById('btn-filtrar-precio').addEventListener('click', filtrarProductos);

          // Cantidad rápida
          document.querySelectorAll('.cantidad-rapida').forEach(btn => {
            btn.addEventListener('click', function() {
              const cantidad = this.dataset.cantidad;
              const filaSeleccionada = document.querySelector('.fila-producto.seleccionada');
              if (filaSeleccionada) {
                const input = filaSeleccionada.querySelector('.cantidad-producto');
                input.value = cantidad;
                mostrarPreview(filaSeleccionada.dataset.productoId, filaSeleccionada.dataset.nombre, 
                               filaSeleccionada.dataset.precio, filaSeleccionada.dataset.stock);
              }
            });
          });

          // Cantidad personalizada
          document.getElementById('cantidad-custom').addEventListener('change', function() {
            if (this.value) {
              const filaSeleccionada = document.querySelector('.fila-producto.seleccionada');
              if (filaSeleccionada) {
                const input = filaSeleccionada.querySelector('.cantidad-producto');
                input.value = this.value;
                mostrarPreview(filaSeleccionada.dataset.productoId, filaSeleccionada.dataset.nombre, 
                               filaSeleccionada.dataset.precio, filaSeleccionada.dataset.stock);
              }
              this.value = '';
            }
          });

          // Click en fila para seleccionar
          document.addEventListener('click', function(e) {
            const fila = e.target.closest('.fila-producto');
            if (fila && !e.target.closest('.cantidad-producto')) {
              document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
              fila.classList.add('seleccionada');
              
              const input = fila.querySelector('.cantidad-producto');
              input.value = 1;
              
              mostrarPreview(fila.dataset.productoId, fila.dataset.nombre, 
                           fila.dataset.precio, fila.dataset.stock);
            }

            // Click en recientes
            if (e.target.closest('.btn-reciente-producto')) {
              const btn = e.target.closest('.btn-reciente-producto');
              const id = btn.dataset.id;
              const fila = document.querySelector(`tr[data-producto-id="${id}"]`);
              if (fila) {
                fila.scrollIntoView({ behavior: 'smooth', block: 'center' });
                document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
                fila.classList.add('seleccionada');
                const input = fila.querySelector('.cantidad-producto');
                input.value = 1;
                mostrarPreview(id, btn.dataset.nombre, btn.dataset.precio, btn.dataset.stock);
              }
            }
          });

          // Doble clic para agregar rápidamente
          document.addEventListener('dblclick', function(e) {
            const fila = e.target.closest('.fila-producto');
            if (fila) {
              document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
              fila.classList.add('seleccionada');
              document.getElementById('btn-agregar-modal').click();
            }
          });

          // Enter para agregar
          document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && document.querySelector('.fila-producto.seleccionada')) {
              document.getElementById('btn-agregar-modal').click();
            }
          });

          // Botón Agregar en el modal
          document.getElementById('btn-agregar-modal').addEventListener('click', function() {
            if (!productoSeleccionado) {
              toastr.warning('Selecciona un producto primero');
              return;
            }

            const { id, nombre, precio, stock } = productoSeleccionado;
            const fila = document.querySelector(`tr[data-producto-id="${id}"]`);
            const cantidadInput = fila.querySelector('.cantidad-producto');
            let cantidad = parseInt(cantidadInput.value) || 1;

            if (cantidad < 1) {
              toastr.warning('La cantidad debe ser mayor a 0');
              cantidadInput.value = 1;
              return;
            }

            if (cantidad > stock) {
              toastr.error(`Solo hay ${stock} unidades disponibles`);
              cantidadInput.value = stock;
              return;
            }

            // Agregar a historial
            productosRecientes = productosRecientes.filter(p => p.id !== id);
            productosRecientes.unshift({ id, nombre, precio, stock });
            productosRecientes = productosRecientes.slice(0, 5);
            localStorage.setItem('productosRecientes', JSON.stringify(productosRecientes));
            actualizarRecientes();

            // Agregar a tabla de ventas
            let productoExistente = false;
            const filasExistentes = document.querySelectorAll('#tabla-detalles tbody tr');
            
            filasExistentes.forEach(filaExistente => {
              const idInput = filaExistente.querySelector('input[name="id_producto[]"]');
              if (idInput.value === id) {
                const cantidadDisplay = filaExistente.querySelector('.cantidad-display');
                const nuevaCantidad = parseInt(cantidadDisplay.innerText) + cantidad;
                
                if (nuevaCantidad > stock) {
                  toastr.error(`Stock insuficiente. Máximo: ${stock} unidades`);
                  return;
                }
                
                cantidadDisplay.innerText = nuevaCantidad;
                productoExistente = true;
              }
            });

            if (!productoExistente) {
              const filaHTML = `
                <tr class="table-detalles-row">
                  <td><input type="hidden" name="id_producto[]" value="${id}"><strong>${nombre}</strong></td>
                  <td>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <button type="button" class="btn btn-outline-danger btn-quantity btn-menos"><i class="fas fa-minus"></i></button>
                      <span class="cantidad-display">${cantidad}</span>
                      <button type="button" class="btn btn-outline-success btn-quantity btn-mas"><i class="fas fa-plus"></i></button>
                    </div>
                  </td>
                  <td><input type="text" name="precio_unitario[]" class="form-control" value="${precio}" readonly /></td>
                  <td><input type="text" name="subtotal[]" class="form-control" readonly style="font-weight: bold; text-align: right;" /></td>
                  <td><button type="button" class="btn btn-danger btn-sm eliminar-fila"><i class="fas fa-trash"></i></button></td>
                </tr>
              `;
              document.querySelector('#tabla-detalles tbody').insertAdjacentHTML('beforeend', filaHTML);
            }

            recalcularTotal();
            toastr.success(`${nombre} agregado (x${cantidad})`);
            cantidadInput.value = 1;
            productoSeleccionado = null;
            document.getElementById('preview-carrito').innerHTML = '<small class="text-muted">Selecciona un producto para previsualizar</small>';
          });

          // ============ FUNCIONES DE CÁLCULO ============

          function recalcularTotal() {
            let total = 0;
            const filas = document.querySelectorAll('#tabla-detalles tbody tr');

            filas.forEach(fila => {
              const cantidadDisplay = fila.querySelector('.cantidad-display');
              const precioInput = fila.querySelector('input[name="precio_unitario[]"]');
              const subtotalInput = fila.querySelector('input[name="subtotal[]"]');

              const cantidad = parseInt(cantidadDisplay.innerText) || 0;
              const precio = parseFloat(precioInput.value) || 0;
              const subtotal = cantidad * precio;

              subtotalInput.value = subtotal.toFixed(0);
              total += subtotal;
            });

            document.querySelector('input[name="total"]').value = total.toFixed(0);
          }

          // ============ EVENT LISTENERS TABLA DETALLES ============

          document.addEventListener('click', function (e) {
            // Botones +/-
            if (e.target.classList.contains('btn-mas') || e.target.closest('.btn-mas')) {
              const boton = e.target.closest('.btn-mas');
              const fila = boton.closest('tr');
              const idInput = fila.querySelector('input[name="id_producto[]"]');
              const productoId = idInput.value;
              const stock = productosDisponibles[productoId].stock;
              const cantidadDisplay = fila.querySelector('.cantidad-display');
              const nuevaCantidad = parseInt(cantidadDisplay.innerText) + 1;

              if (nuevaCantidad > stock) {
                toastr.warning(`Stock insuficiente. Máximo: ${stock} unidades`);
                return;
              }

              cantidadDisplay.innerText = nuevaCantidad;
              recalcularTotal();
            }

            if (e.target.classList.contains('btn-menos') || e.target.closest('.btn-menos')) {
              const boton = e.target.closest('.btn-menos');
              const fila = boton.closest('tr');
              const cantidadDisplay = fila.querySelector('.cantidad-display');
              const cantidadActual = parseInt(cantidadDisplay.innerText);

              if (cantidadActual > 1) {
                cantidadDisplay.innerText = cantidadActual - 1;
                recalcularTotal();
              } else {
                toastr.info('La cantidad mínima es 1');
              }
            }

            // Eliminar fila
            if (e.target.classList.contains('eliminar-fila') || e.target.closest('.eliminar-fila')) {
              const fila = e.target.closest('tr');
              const nombreProducto = fila.querySelector('strong').innerText;
              fila.remove();
              recalcularTotal();
              toastr.info(`${nombreProducto} eliminado de la venta`);
            }
          });

          // Inicializar recientes al cargar
          document.addEventListener('DOMContentLoaded', actualizarRecientes);
          </script>

    @endsection
