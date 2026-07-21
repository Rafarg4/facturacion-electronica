@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
  .form-label { font-size: 0.8rem; font-weight: 600; margin-bottom: 2px; color: #555; }
  .form-control, .form-select { font-size: 0.875rem; }
  .btn-quantity { padding: 0.2rem 0.45rem; font-size: 0.8rem; }
  .cantidad-display { text-align: center; font-weight: bold; min-width: 36px; font-size: 0.9rem; }
  #tabla-detalles tbody tr { vertical-align: middle; }
  .panel-productos { position: sticky; top: 10px; }
  .total-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px 14px; }
  .card-seccion .card-header { background: #f8f9fa; font-weight: 600; font-size: 0.9rem; }
  #barra-acciones {
    position: sticky; bottom: 0; z-index: 20;
    background: #fff; border-top: 1px solid #dee2e6;
    box-shadow: 0 -2px 10px rgba(0,0,0,.08);
  }
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
      <div class="row g-3">

        {{-- ══════════════ Columna izquierda: datos de compra ══════════════ --}}
        <div class="col-lg-8">

          {{-- Sección: Datos de la compra --}}
          <div class="card card-seccion mb-3">
            <div class="card-header py-2"><i class="fas fa-truck"></i> Datos de la compra</div>
            <div class="card-body py-2">
              <div class="row g-2">
                <div class="col-md-4">
                  <label class="form-label">Proveedor</label>
                  <select name="id_proveedor" id="id_proveedor" class="form-control form-control-sm" required>
                    <option value="">Buscar proveedor...</option>
                    @foreach($proveedores as $p)
                      <option value="{{ $p->id }}">
                        {{ $p->compania ? $p->compania . ' — ' : '' }}{{ $p->nombre }} {{ $p->apellido }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Fecha Compra</label>
                  {!! Form::text('fecha_compra', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control form-control-sm', 'readonly', 'required' => 'required']) !!}
                </div>
                <div class="col-md-2">
                  <label class="form-label">IVA</label>
                  {!! Form::select('iva', ['10' => '10%', '5' => '5%', 'Exenta' => 'Exenta'], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Seleccione', 'required' => 'required']) !!}
                </div>
                <div class="col-md-4">
                  <label class="form-label">Tipo Comprobante</label>
                  <select name="tipo_comprobante" id="tipo_comprobante" class="form-control form-control-sm" required>
                    <option value="">Seleccione</option>
                    <option value="Recibo">Recibo</option>
                    <option value="Factura">Factura</option>
                    <option value="Ticket">Ticket</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          {{-- Sección: Comprobante y condición --}}
          <div class="card card-seccion mb-3">
            <div class="card-header py-2"><i class="fas fa-receipt"></i> Comprobante y condición</div>
            <div class="card-body py-2">
              <div class="row g-2">
                <div class="col-md-2">
                  <label class="form-label">N° Comprobante</label>
                  {!! Form::text('numero_comprobante', null, ['class' => 'form-control form-control-sm', 'required' => 'required']) !!}
                </div>
                <div class="col-md-3">
                  <label class="form-label">Condición de Compra</label>
                  <select name="condicion_compra" id="condicion_compra" class="form-control form-control-sm" required>
                    <option value="contado">Contado</option>
                    <option value="credito">Crédito</option>
                  </select>
                </div>
                <div class="col-md-2" id="campo-plazo" style="display:none;">
                  <label class="form-label">Plazo</label>
                  <select name="plazo" id="plazo" class="form-control form-control-sm">
                    <option value="30">30 días</option>
                    <option value="60">60 días</option>
                    <option value="90">90 días</option>
                    <option value="120">120 días</option>
                  </select>
                </div>
                <div class="col-md-5">
                  <label class="form-label">Observación</label>
                  {!! Form::text('observacion', null, ['class' => 'form-control form-control-sm']) !!}
                </div>
              </div>
            </div>
          </div>

          {{-- Sección: Productos a comprar + total --}}
          <div class="card card-seccion mb-3">
            <div class="card-header py-2"><i class="fas fa-box-open"></i> Productos a comprar</div>
            <div class="card-body py-2">
              <table class="table table-bordered table-hover table-sm mb-3" id="tabla-detalles">
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

              <div class="row justify-content-end g-2 mb-1">
                <div class="col-auto">
                  <div class="total-box d-flex align-items-center gap-2">
                    <span class="fw-bold">Total:</span>
                    {!! Form::text('total', null, ['class' => 'form-control form-control-sm text-end fw-bold', 'readonly' => true, 'id' => 'total-input', 'style' => 'width:140px;font-size:1rem;']) !!}
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        {{-- ══════════════ Columna derecha: agregar producto por código ══════════════ --}}
        <div class="col-lg-4">
          <div class="card shadow-sm panel-productos">
            <div class="card-header py-2">
              <strong><i class="fas fa-barcode"></i> Agregar producto</strong>
            </div>
            <div class="card-body p-2">

              <label class="form-label">Código de barras / código de producto</label>
              <input type="text" id="buscar-producto" class="form-control form-control-sm mb-2" placeholder="Escanee o ingrese el código" autocomplete="off" autofocus>

              <div class="d-flex gap-2 align-items-center mb-2">
                <label class="form-label mb-0 text-nowrap">Cantidad:</label>
                <input type="number" id="cantidad-a-agregar" class="form-control form-control-sm" value="1" min="1" style="max-width:90px;">
              </div>

              <div class="text-muted small" id="producto-buscando" style="display:none;">
                <i class="fas fa-spinner fa-spin"></i> Buscando...
              </div>

              <small class="text-muted d-block mt-2">
                Escanee el código con el lector o ingréselo manualmente y presione Enter para agregarlo directo al detalle.
              </small>

            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="card-footer py-2" id="barra-acciones">
      {!! Form::submit('Confirmar Compra', ['class' => 'btn btn-success btn-sm']) !!}
      <a href="{{ route('compras.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
    </div>

    {!! Form::close() !!}
  </div>
</div>

<script>
  toastr.options = {
    closeButton: true, newestOnTop: true, progressBar: true,
    positionClass: 'toast-top-right', timeOut: '3000'
  };

  function escapeHtml(str) {
    return String(str ?? '').replace(/[&<>"']/g, c => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));
  }

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
          <strong>${escapeHtml(nombre)}</strong>
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

  // ── Buscar por código (escáner o manual) y agregar directo al detalle ───────
  function buscarYAgregarProducto() {
    const inputCodigo = document.getElementById('buscar-producto');
    const codigo = inputCodigo.value.trim();
    if (!codigo) return;

    const cantidadInput = document.getElementById('cantidad-a-agregar');
    let cantidad = parseInt(cantidadInput.value) || 1;
    if (cantidad < 1) cantidad = 1;

    document.getElementById('producto-buscando').style.display = 'block';

    $.get("{{ route('productos.paraCompra') }}", { q: codigo }, function (r) {
      const productos = r.data || [];
      const producto = productos.find(p => String(p.codigo).trim() === codigo);

      if (!producto) {
        toastr.error('Producto no encontrado para el código: ' + codigo);
        return;
      }

      const costo = parseFloat(producto.costo ?? 0);

      let existente = false;
      document.querySelectorAll('#tabla-detalles tbody tr').forEach(tr => {
        if (tr.querySelector('input[name="id_producto[]"]')?.value == producto.id) {
          const display   = tr.querySelector('.cantidad-display');
          const nuevaCant = parseInt(display.innerText) + cantidad;
          display.innerText = nuevaCant;
          tr.querySelector('.cantidad-hidden').value = nuevaCant;
          existente = true;
        }
      });

      if (!existente) {
        agregarFilaProducto(producto.id, producto.descripcion, costo, cantidad);
      }

      recalcularTotal();
      toastr.success(`${producto.descripcion} agregado (x${cantidad})`);
    }).fail(function () {
      toastr.error('Error al buscar el producto');
    }).always(function () {
      document.getElementById('producto-buscando').style.display = 'none';
      inputCodigo.value = '';
      cantidadInput.value = 1;
      inputCodigo.focus();
    });
  }

  document.getElementById('buscar-producto').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      buscarYAgregarProducto();
    }
  });

  // ── Botones +/- y eliminar ───────────────────────────────────────────────────
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

  // ── Mostrar/ocultar plazo según condición de compra ──────────────────────────
  document.getElementById('condicion_compra').addEventListener('change', function () {
    const campoPlazo = document.getElementById('campo-plazo');
    campoPlazo.style.display = this.value === 'credito' ? '' : 'none';
    document.getElementById('plazo').required = this.value === 'credito';
  });

  // ── Inicialización ──────────────────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', function () {
    $('#id_proveedor').select2({
      theme: 'bootstrap-5',
      placeholder: 'Buscar proveedor...',
      allowClear: true,
      width: '100%',
      language: {
        noResults: function () { return 'No se encontraron resultados'; },
        searching: function () { return 'Buscando...'; }
      }
    });
  });
</script>
@endsection
