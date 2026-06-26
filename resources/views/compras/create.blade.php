@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
  .form-label { font-size: 0.8rem; font-weight: 600; margin-bottom: 2px; color: #555; }
  .form-control, .form-select { font-size: 0.875rem; }
  .btn-quantity { padding: 0.2rem 0.45rem; font-size: 0.8rem; }
  .cantidad-display { text-align: center; font-weight: bold; min-width: 36px; font-size: 0.9rem; }
  #tabla-detalles tbody tr { vertical-align: middle; }
  .fila-producto:hover { background-color: #f1f1f1 !important; cursor: pointer; }
  .fila-producto.seleccionada { background-color: #dde8f5 !important; }
  .sticky-top { position: sticky; top: 0; z-index: 10; }
  .preview-item { padding: 8px; border: 1px solid #dee2e6; border-radius: 5px; background: #f8f9fa; font-size: 0.85rem; }
  .total-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px 14px; }
  .modal-loading-overlay {
    position: absolute; inset: 0; z-index: 9999;
    background: rgba(255,255,255,0.85);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    border-radius: 0.375rem;
  }
  .modal-loading-overlay .spinner-border { width: 2.5rem; height: 2.5rem; }
</style>

<section class="content-header py-2">
  <div class="container-fluid">
    <h5 class="mb-0"><i class="fas fa-boxes"></i> Nueva Compra</h5>
  </div>
</section>

<div class="content px-3">
  @include('adminlte-templates::common.errors')

  <div class="card shadow-sm">
    {!! Form::open(['route' => 'compras.store']) !!}

    <div class="card-body pb-2">

      {{-- Fila 0: Proveedor --}}
      <div class="row g-2 mb-2">
        <div class="col-md-4">
          <label class="form-label"><i class="fas fa-truck"></i> Proveedor</label>
          <select name="id_proveedor" class="form-control form-control-sm" required>
            <option value="">Seleccione un proveedor</option>
            @foreach($proveedores as $p)
              <option value="{{ $p->id }}">
                {{ $p->compania ? $p->compania . ' — ' : '' }}{{ $p->nombre }} {{ $p->apellido }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      {{-- Fila 1: Comprobante + N° + Forma Pago + Fecha + Observacion --}}
      <div class="row g-2 mb-2">
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-receipt"></i> Tipo Comprobante</label>
          <select name="tipo_comprobante" id="tipo_comprobante" class="form-control form-control-sm" required>
            <option value="">Seleccione</option>
            <option value="Recibo">Recibo</option>
            <option value="Factura">Factura</option>
            <option value="Ticket">Ticket</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-hashtag"></i> N° Comprobante</label>
          {!! Form::text('numero_comprobante', null, ['class' => 'form-control form-control-sm', 'required' => 'required']) !!}
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-percent"></i> IVA</label>
          {!! Form::select('iva', ['10' => '10%', '5' => '5%', 'Exenta' => 'Exenta'], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Seleccione', 'required' => 'required']) !!}
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-credit-card"></i> Forma de Pago</label>
          {!! Form::select('forma_pago', [
              'Efectivo'       => 'Efectivo',
              'Tarjeta'        => 'Tarjeta',
              'Transferencia'  => 'Transferencia'
          ], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Seleccione', 'required' => 'required']) !!}
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-calendar-alt"></i> Fecha Compra</label>
          {!! Form::text('fecha_compra', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control form-control-sm', 'readonly', 'required' => 'required']) !!}
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-sticky-note"></i> Observación</label>
          {!! Form::text('observacion', null, ['class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      {{-- Botón agregar producto --}}
      <button type="button" class="btn btn-outline-primary btn-sm mb-2" id="btn-abrir-modal" data-bs-toggle="modal" data-bs-target="#modalProductos">
        <i class="fas fa-plus" id="icon-abrir-modal"></i>
        <span id="texto-abrir-modal">Agregar producto</span>
      </button>

      {{-- Modal productos --}}
      <div class="modal fade" id="modalProductos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 85vw;">
          <div class="modal-content" style="position:relative;">
            <div class="modal-loading-overlay" id="modal-loading" style="display:none;">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 mb-0 text-muted fw-semibold" style="font-size:0.9rem;">Cargando productos...</p>
            </div>
            <div class="modal-header py-2">
              <h6 class="modal-title mb-0"><i class="fas fa-boxes"></i> Seleccionar productos</h6>
              <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-2">
              <div class="row g-2">
                {{-- Izquierda: tabla --}}
                <div class="col-lg-8">
                  <div class="mb-2">
                    <input type="text" id="buscar-producto" class="form-control form-control-sm" placeholder="Buscar por nombre o código...">
                  </div>

                  <div style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-bordered table-hover table-sm mb-0" id="tabla-productos-modal">
                      <thead class="table-light sticky-top">
                        <tr>
                          <th style="width:75px;">Código</th>
                          <th>Nombre</th>
                          <th style="width:80px;">Stock actual</th>
                          <th style="width:100px;">Costo actual</th>
                          <th style="width:90px;">Cantidad</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($productos as $producto)
                        <tr class="fila-producto"
                            data-producto-id="{{ $producto->id }}"
                            data-nombre="{{ $producto->descripcion }}"
                            data-costo="{{ $producto->costo ?? 0 }}"
                            data-stock="{{ $producto->cantidad }}"
                            data-codigo="{{ $producto->codigo ?? '' }}">
                          <td><small class="text-muted">{{ $producto->codigo ?? '-' }}</small></td>
                          <td><strong>{{ $producto->descripcion }}</strong></td>
                          <td><span class="badge bg-secondary">{{ $producto->cantidad }}</span></td>
                          <td>{{ number_format($producto->costo ?? 0) }}</td>
                          <td>
                            <input type="number" class="form-control form-control-sm cantidad-producto" value="1" min="1" tabindex="-1">
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

                {{-- Derecha: preview --}}
                <div class="col-lg-4">
                  <div class="card">
                    <div class="card-header py-1">
                      <small><i class="fas fa-eye"></i> Vista previa</small>
                    </div>
                    <div class="card-body p-2" style="max-height:320px;overflow-y:auto;" id="preview-carrito">
                      <small class="text-muted">Selecciona un producto</small>
                    </div>
                    <div class="card-footer p-2">
                      <button type="button" class="btn btn-primary btn-sm w-100" id="btn-agregar-modal">
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

      {{-- Tabla productos seleccionados --}}
      <div class="text-center mb-1 mt-2"><strong><i class="fas fa-box-open"></i> Productos a comprar</strong></div>
      <table class="table table-bordered table-hover table-sm" id="tabla-detalles">
        <thead class="table-light">
          <tr>
            <th>Producto</th>
            <th style="width:140px;">Cantidad</th>
            <th style="width:130px;">Precio unitario</th>
            <th style="width:120px;">Subtotal</th>
            <th style="width:50px;"></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

      {{-- Total --}}
      <div class="row justify-content-end g-2 mb-1">
        <div class="col-auto">
          <div class="total-box d-flex align-items-center gap-2">
            <span class="fw-bold">Total:</span>
            {!! Form::text('total', null, ['class' => 'form-control form-control-sm text-end fw-bold', 'readonly' => true, 'id' => 'total-input', 'style' => 'width:140px;font-size:1rem;']) !!}
          </div>
        </div>
      </div>

    </div>

    <div class="card-footer py-2">
      {!! Form::submit('Confirmar Compra', ['class' => 'btn btn-success btn-sm']) !!}
      <a href="{{ route('compras.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
    </div>

    {!! Form::close() !!}
  </div>
</div>

<script>
  const productosDisponibles = {
    @foreach($productos as $producto)
      {{ $producto->id }}: {
        nombre: @json($producto->descripcion),
        stock:  {{ $producto->cantidad }},
        costo:  {{ $producto->costo ?? 0 }}
      },
    @endforeach
  };

  let productoSeleccionado = null;

  toastr.options = {
    closeButton: true, newestOnTop: true, progressBar: true,
    positionClass: 'toast-top-right', timeOut: '3000'
  };

  // ── Filtro búsqueda ──────────────────────────────────────────────────────────
  document.getElementById('buscar-producto').addEventListener('keyup', function () {
    const filtro = this.value.toLowerCase();
    document.querySelectorAll('#tabla-productos-modal tbody .fila-producto').forEach(fila => {
      const nombre = (fila.dataset.nombre ?? '').toLowerCase();
      const codigo = (fila.dataset.codigo ?? '').toLowerCase();
      fila.style.display = (nombre.includes(filtro) || codigo.includes(filtro)) ? '' : 'none';
    });
  });

  // ── Preview ──────────────────────────────────────────────────────────────────
  function mostrarPreview(id, nombre, costo, stock) {
    productoSeleccionado = { id, nombre, costo, stock };
    const cantidadInput = document.querySelector(`tr[data-producto-id="${id}"] .cantidad-producto`);
    const cantidad = parseInt(cantidadInput?.value) || 1;
    const subtotal = costo * cantidad;

    document.getElementById('preview-carrito').innerHTML = `
      <div class="preview-item">
        <strong>${nombre}</strong>
        <p class="mb-1 mt-1"><small>Costo actual: <strong>${Number(costo).toLocaleString('es-PY')} Gs.</strong></small></p>
        <p class="mb-1"><small>Stock actual: <span class="badge bg-secondary">${stock}</span></small></p>
        <p class="mb-1"><small>Cantidad a comprar: <span class="badge bg-primary">${cantidad}</span></small></p>
        <hr class="my-1">
        <p class="mb-0 text-end">Subtotal: <strong>${Number(subtotal).toLocaleString('es-PY')} Gs.</strong></p>
      </div>
    `;
  }

  // ── Click en fila ────────────────────────────────────────────────────────────
  document.addEventListener('click', function (e) {
    const fila = e.target.closest('.fila-producto');
    if (fila && !e.target.closest('.cantidad-producto')) {
      document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
      fila.classList.add('seleccionada');
      mostrarPreview(fila.dataset.productoId, fila.dataset.nombre,
        parseFloat(fila.dataset.costo), parseInt(fila.dataset.stock));
    }
  });

  document.addEventListener('dblclick', function (e) {
    const fila = e.target.closest('.fila-producto');
    if (fila) {
      document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
      fila.classList.add('seleccionada');
      mostrarPreview(fila.dataset.productoId, fila.dataset.nombre,
        parseFloat(fila.dataset.costo), parseInt(fila.dataset.stock));
      document.getElementById('btn-agregar-modal').click();
    }
  });

  document.addEventListener('keypress', function (e) {
    if (e.key === 'Enter' && document.querySelector('.fila-producto.seleccionada')) {
      document.getElementById('btn-agregar-modal').click();
    }
  });

  // ── Recalcular total ─────────────────────────────────────────────────────────
  function recalcularTotal() {
    let total = 0;
    document.querySelectorAll('#tabla-detalles tbody tr').forEach(fila => {
      const cantidad = parseInt(fila.querySelector('.cantidad-display')?.innerText) || 0;
      const precio   = parseFloat(fila.querySelector('input[name="precio_unitario[]"]')?.value) || 0;
      const subtotal = cantidad * precio;
      fila.querySelector('input[name="subtotal[]"]').value = subtotal.toFixed(0);
      fila.querySelector('.subtotal-display').innerText = Number(subtotal).toLocaleString('es-PY');
      total += subtotal;
    });
    document.getElementById('total-input').value = Math.round(total).toLocaleString('es-PY');
  }

  // ── Agregar fila a detalle ───────────────────────────────────────────────────
  function agregarFilaProducto(id, nombre, costo, cantidad) {
    const subtotal = costo * cantidad;
    const html = `
      <tr class="tabla-detalles-row">
        <td>
          <input type="hidden" name="id_producto[]" value="${id}">
          <strong>${nombre}</strong>
        </td>
        <td>
          <input type="hidden" name="cantidad[]" class="cantidad-hidden" value="${cantidad}">
          <div class="d-flex justify-content-center align-items-center gap-1">
            <button type="button" class="btn btn-outline-danger btn-quantity btn-menos"><i class="fas fa-minus"></i></button>
            <span class="cantidad-display">${cantidad}</span>
            <button type="button" class="btn btn-outline-success btn-quantity btn-mas"><i class="fas fa-plus"></i></button>
          </div>
        </td>
        <td>
          <input type="number" name="precio_unitario[]" class="form-control form-control-sm text-end precio-input" value="${costo}" min="0" step="1">
        </td>
        <td>
          <input type="hidden" name="subtotal[]" value="${subtotal.toFixed(0)}">
          <span class="subtotal-display">${Number(subtotal).toLocaleString('es-PY')}</span>
        </td>
        <td><button type="button" class="btn btn-danger btn-sm eliminar-fila"><i class="fas fa-trash"></i></button></td>
      </tr>
    `;
    document.querySelector('#tabla-detalles tbody').insertAdjacentHTML('beforeend', html);
  }

  // ── Botón Agregar en modal ───────────────────────────────────────────────────
  document.getElementById('btn-agregar-modal').addEventListener('click', function () {
    if (!productoSeleccionado) {
      toastr.warning('Selecciona un producto primero');
      return;
    }
    const { id, nombre, costo } = productoSeleccionado;
    const fila = document.querySelector(`tr[data-producto-id="${id}"]`);
    const cantidad = parseInt(fila.querySelector('.cantidad-producto').value) || 1;

    if (cantidad < 1) { toastr.warning('La cantidad debe ser mayor a 0'); return; }

    // Si ya está en la tabla, sumar cantidad
    let existente = false;
    document.querySelectorAll('#tabla-detalles tbody tr').forEach(tr => {
      if (tr.querySelector('input[name="id_producto[]"]')?.value == id) {
        const display = tr.querySelector('.cantidad-display');
        const nuevaCant = parseInt(display.innerText) + cantidad;
        display.innerText = nuevaCant;
        tr.querySelector('.cantidad-hidden').value = nuevaCant;
        existente = true;
      }
    });

    if (!existente) {
      agregarFilaProducto(id, nombre, costo, cantidad);
    }

    recalcularTotal();
    toastr.success(`${nombre} agregado (x${cantidad})`);
    fila.querySelector('.cantidad-producto').value = 1;
    productoSeleccionado = null;
    document.getElementById('preview-carrito').innerHTML = '<small class="text-muted">Selecciona un producto</small>';
    document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
  });

  // ── Botones +/- precio y eliminar ────────────────────────────────────────────
  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-mas')) {
      const tr      = e.target.closest('tr');
      const display = tr.querySelector('.cantidad-display');
      display.innerText = parseInt(display.innerText) + 1;
      tr.querySelector('.cantidad-hidden').value = display.innerText;
      recalcularTotal();
    }

    if (e.target.closest('.btn-menos')) {
      const tr      = e.target.closest('tr');
      const display = tr.querySelector('.cantidad-display');
      const actual  = parseInt(display.innerText);
      if (actual > 1) {
        display.innerText = actual - 1;
        tr.querySelector('.cantidad-hidden').value = actual - 1;
        recalcularTotal();
      } else {
        toastr.info('La cantidad mínima es 1');
      }
    }

    if (e.target.closest('.eliminar-fila')) {
      const tr     = e.target.closest('tr');
      const nombre = tr.querySelector('strong').innerText;
      tr.remove();
      recalcularTotal();
      toastr.info(`${nombre} eliminado`);
    }
  });

  // Recalcular cuando se edita el precio directamente
  document.addEventListener('input', function (e) {
    if (e.target.classList.contains('precio-input')) {
      recalcularTotal();
    }
  });

  // ── Loading overlay del modal ────────────────────────────────────────────────
  const modalEl      = document.getElementById('modalProductos');
  const loadingEl    = document.getElementById('modal-loading');
  const btnAbrirIcon = document.getElementById('icon-abrir-modal');
  const btnAbrirTxt  = document.getElementById('texto-abrir-modal');

  modalEl.addEventListener('show.bs.modal', function () {
    loadingEl.style.display = 'flex';
    btnAbrirIcon.className  = 'fas fa-spinner fa-spin';
    btnAbrirTxt.textContent = 'Cargando...';
  });
  modalEl.addEventListener('shown.bs.modal', function () {
    loadingEl.style.display = 'none';
    btnAbrirIcon.className  = 'fas fa-plus';
    btnAbrirTxt.textContent = 'Agregar producto';
    document.getElementById('buscar-producto').focus();
  });
  modalEl.addEventListener('hide.bs.modal', function () {
    btnAbrirIcon.className  = 'fas fa-plus';
    btnAbrirTxt.textContent = 'Agregar producto';
  });
</script>
@endsection
