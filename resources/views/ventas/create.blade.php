@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
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
  .total-gs-box { background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 8px; padding: 10px 14px; }
  .badge-moneda { font-size: 0.7rem; }
  .card-seccion .card-header { background: #f8f9fa; font-weight: 600; font-size: 0.9rem; }
  #barra-acciones {
    position: sticky; bottom: 0; z-index: 20;
    background: #fff; border-top: 1px solid #dee2e6;
    box-shadow: 0 -2px 10px rgba(0,0,0,.08);
  }
</style>

<section class="content-header py-2">
  <div class="container-fluid">
    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Nueva Venta</h5>
  </div>
</section>

<div class="content px-3">
  @include('adminlte-templates::common.errors')

  <div class="card shadow-sm">
    {!! Form::open(['route' => 'ventas.store', 'id' => 'form-venta']) !!}
    {!! Form::hidden('id_caja', Auth::user()->caja) !!}

    <div class="card-body pb-2">
      <div class="row g-3">

        {{-- ══════════════ Columna izquierda: datos de venta ══════════════ --}}
        <div class="col-lg-8">

          {{-- Sección: Datos de la venta --}}
          <div class="card card-seccion mb-3">
            <div class="card-header py-2"><i class="fas fa-user"></i> Datos de la venta</div>
            <div class="card-body py-2">
              <div class="row g-2">
                <div class="col-md-4">
                  <label class="form-label">Cliente</label>
                  <div class="d-flex gap-1">
                    <select name="id_cliente" id="id_cliente" class="form-control form-control-sm" required>
                      <option value="">Seleccione un cliente</option>
                      @foreach($clientes as $c)
                        <option value="{{ $c->id }}">{{ $c->ci }} - {{ $c->nombre }} {{ $c->apellido }}</option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente" title="Carga rápida de cliente">
                      <i class="fas fa-user-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Cajero</label>
                  {!! Form::hidden('id_usuario', Auth::user()->id) !!}
                  {!! Form::text('nombre_usuario', Auth::user()->name, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                </div>
                <div class="col-md-2">
                  <label class="form-label">Fecha</label>
                  {!! Form::text('fecha_venta', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control form-control-sm', 'readonly', 'required' => 'required']) !!}
                </div>
                <div class="col-md-3">
                  <label class="form-label">Observación</label>
                  {!! Form::text('observacion', null, ['class' => 'form-control form-control-sm']) !!}
                </div>
              </div>
            </div>
          </div>

          {{-- Sección: Comprobante y pago --}}
          <div class="card card-seccion mb-3">
            <div class="card-header py-2"><i class="fas fa-receipt"></i> Comprobante y pago</div>
            <div class="card-body py-2">
              <div class="row g-2">
                <div class="col-md-3">
                  <label class="form-label">Comprobante</label>
                  <select name="tipo_comprobante" id="tipo_comprobante" class="form-control form-control-sm" required>
                    <option value="">Seleccione</option>
                    <option value="Recibo">Recibo</option>
                    <option value="Factura">Factura</option>
                    <option value="Ticket">Ticket</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="form-label">N° Comprobante</label>
                  <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control form-control-sm" readonly>
                </div>
                <div class="col-md-3">
                  <label class="form-label">IVA</label>
                  {!! Form::select('iva', ['10' => '10%', '5' => '5%', 'Exenta' => 'Exenta'], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Seleccione', 'required' => 'required']) !!}
                </div>
                <div class="col-md-3">
                  <label class="form-label">Forma de pago</label>
                  {!! Form::select('forma_pago', ['Efectivo' => 'Efectivo', 'Tarjeta' => 'Tarjeta', 'Transferencia' => 'Transferencia'], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Seleccione', 'required' => 'required']) !!}
                </div>
                <div class="col-md-3">
                  <label class="form-label">Condición</label>
                  {!! Form::select('condicion_venta', ['contado' => 'Contado', 'credito' => 'Crédito'], null, ['class' => 'form-control form-control-sm', 'id' => 'condicion', 'required' => 'required']) !!}
                </div>
                <div class="col-md-3" id="plazo-group" style="display:none;">
                  <label class="form-label">Plazo</label>
                  {!! Form::select('plazo', ['30' => '30 días', '60' => '60 días', '90' => '90 días'], null, ['id' => 'plazo', 'class' => 'form-control form-control-sm']) !!}
                </div>
                <div class="col-md-3">
                  <label class="form-label">Moneda</label>
                  <select name="moneda" id="moneda" class="form-control form-control-sm" required>
                    <option value="PYG">Guaraníes (PYG)</option>
                    <option value="USD">Dólares (USD)</option>
                  </select>
                </div>
                <input type="hidden" name="tipo_cambio" id="tipo_cambio">
              </div>

              @if($empresa && $empresa->facturacion_electronica)
              <div class="mt-2" id="enviar-factura-group" style="display:none;">
                <div class="form-check">
                  {!! Form::checkbox('enviar_factura', 1, false, ['class' => 'form-check-input', 'id' => 'enviar_factura']) !!}
                  <label class="form-check-label" for="enviar_factura">
                    <i class="fas fa-file-invoice"></i> Emitir factura electrónica (SIFEN) para esta venta
                  </label>
                </div>
              </div>
              @endif
            </div>
          </div>

          {{-- Modal carga rápida de cliente --}}
          <div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header py-2">
                  <h6 class="modal-title mb-0"><i class="fas fa-user-plus"></i> Nuevo cliente</h6>
                  <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-2">
                  <div class="row g-2">
                    <div class="col-md-6">
                      <label class="form-label">Nombre</label>
                      <input type="text" id="nuevo-cliente-nombre" class="form-control form-control-sm" maxlength="255">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Apellido</label>
                      <input type="text" id="nuevo-cliente-apellido" class="form-control form-control-sm" maxlength="255">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">C.I.</label>
                      <input type="text" id="nuevo-cliente-ci" class="form-control form-control-sm" maxlength="255">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Teléfono</label>
                      <input type="text" id="nuevo-cliente-telefono" class="form-control form-control-sm" maxlength="255">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Correo</label>
                      <input type="email" id="nuevo-cliente-correo" class="form-control form-control-sm" maxlength="255">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Dirección</label>
                      <input type="text" id="nuevo-cliente-direccion" class="form-control form-control-sm" maxlength="255">
                    </div>
                  </div>
                </div>
                <div class="modal-footer py-2">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary btn-sm" id="btn-guardar-nuevo-cliente">
                    <i class="fas fa-save"></i> Guardar
                  </button>
                </div>
              </div>
            </div>
          </div>

          {{-- Sección: Productos seleccionados + totales --}}
          <div class="card card-seccion mb-3">
            <div class="card-header py-2"><i class="fas fa-box-open"></i> Productos seleccionados</div>
            <div class="card-body py-2">
              <table class="table table-bordered table-hover table-sm mb-3" id="tabla-detalles">
                <thead class="table-light">
                  <tr>
                    <th>Producto</th>
                    <th style="width:130px;">Cantidad</th>
                    <th style="width:110px;">Precio unit.</th>
                    <th style="width:60px;">Moneda</th>
                    <th style="width:110px;">Subtotal</th>
                    <th style="width:110px;">Subtotal GS</th>
                    <th style="width:60px;"></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>

              {{-- Totales --}}
              <div class="row justify-content-end g-2 mb-1">
                <div class="col-auto">
                  <div class="total-box d-flex align-items-center gap-2">
                    <span class="fw-bold">Total:</span>
                    {!! Form::text('total', null, ['class' => 'form-control form-control-sm text-end fw-bold', 'readonly' => true, 'style' => 'width:130px;font-size:1rem;']) !!}
                  </div>
                </div>
                <div class="col-auto">
                  <div class="total-gs-box d-flex align-items-center gap-2">
                    <span class="fw-bold text-success">Total GS:</span>
                    <input type="text" name="total_gs" id="total_gs_display" class="form-control form-control-sm text-end fw-bold" readonly style="width:130px;font-size:1rem;color:#2e7d32;">
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

          {{-- Panel equivalencias en otras monedas (solo visual) --}}
          @if($cotizaciones->count() > 0)
          <div class="card shadow-sm mt-3">
            <div class="card-header py-2">
              <strong><i class="fas fa-exchange-alt"></i> Equivalencias (referencial)</strong>
            </div>
            <div class="card-body p-0">
              <table class="table table-sm mb-0" style="font-size:12px;">
                <thead class="table-light">
                  <tr>
                    <th class="ps-2">Moneda</th>
                    <th class="text-end">Equivalente</th>
                    <th class="text-end pe-2 text-muted" style="font-size:10px;">Tasa compra</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="ps-2"><strong>PYG</strong> <span class="text-muted" style="font-size:10px;">Guaraníes</span></td>
                    <td class="text-end fw-bold text-success" id="equiv-PYG">Gs. 0</td>
                    <td class="text-end pe-2 text-muted" style="font-size:10px;">—</td>
                  </tr>
                  @foreach($cotizaciones as $moneda => $cot)
                    @if($moneda !== 'PYG')
                    <tr>
                      <td class="ps-2"><strong>{{ $moneda }}</strong></td>
                      <td class="text-end" id="equiv-{{ $moneda }}">0</td>
                      <td class="text-end pe-2 text-muted" style="font-size:10px;">{{ number_format($cot->compra, 2) }}</td>
                    </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endif
        </div>

      </div>
    </div>

    <div class="card-footer py-2" id="barra-acciones">
      {!! Form::submit('Guardar venta', ['class' => 'btn btn-primary btn-sm', 'id' => 'btn-guardar-venta']) !!}
      <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
    </div>

    {!! Form::close() !!}
  </div>
</div>

<script>
  // ── Cotizaciones indexadas por tipo_moneda (compra/venta guardados como strings para preservar formato) ──
  const cotizaciones = {
    @foreach($cotizaciones as $moneda => $cot)
      @json($moneda): { compra: "{{ $cot->compra }}", venta: "{{ $cot->venta }}" },
    @endforeach
  };

  // ── Toastr ──────────────────────────────────────────────────────────────────
  toastr.options = {
    closeButton: true, newestOnTop: true, progressBar: true,
    positionClass: 'toast-top-right', timeOut: '3000'
  };

  function escapeHtml(str) {
    return String(str ?? '').replace(/[&<>"']/g, c => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));
  }

  // Parsea números con formato paraguayo: "6.118" → 6118, "6118" → 6118
  function parsearTasa(valor) {
    return parseFloat(String(valor).replace(/\./g, '').replace(',', '.')) || 0;
  }

  // ── Conversión a Guaraníes ──────────────────────────────────────────────────
  // Fórmula: precio × (PYG.compra / moneda.compra)
  // Ejemplo: 58 USD × (6500 / 1) = 377.000 GS
  function precioEnGs(precio, moneda) {
    if (!moneda || moneda === 'PYG') return precio;
    const cotPyg    = cotizaciones['PYG'];
    const cotMoneda = cotizaciones[moneda];
    if (!cotPyg || !cotMoneda) {
      console.warn('[precioEnGs] Sin cotización para:', moneda, '| Disponibles:', Object.keys(cotizaciones));
      return precio;
    }
    const tasaPyg    = parsearTasa(cotPyg.compra);    // ej: 6500
    const tasaMoneda = parsearTasa(cotMoneda.compra); // ej: 1 para USD
    if (tasaMoneda <= 0) return precio;
    const resultado = precio * (tasaPyg / tasaMoneda);
    return resultado;
  }

  // ── Recalcular totales ──────────────────────────────────────────────────────
  function recalcularTotal() {
    let total = 0, totalGs = 0;
    document.querySelectorAll('#tabla-detalles tbody tr').forEach(fila => {
      const cantidad   = parseInt(fila.querySelector('.cantidad-display')?.innerText) || 0;
      const precio     = parseFloat(fila.querySelector('input[name="precio_unitario[]"]')?.value) || 0;
      const moneda     = fila.dataset.moneda || 'PYG';
      const subtotal   = cantidad * precio;
      const subtotalGs = precioEnGs(precio, moneda) * cantidad;

      fila.querySelector('input[name="subtotal[]"]').value     = subtotal.toFixed(0);
      fila.querySelector('input[name="subtotal_gs[]"]').value  = Math.round(subtotalGs);

      total   += subtotal;
      totalGs += subtotalGs;
    });
    document.querySelector('input[name="total"]').value = total.toFixed(0);
    document.getElementById('total_gs_display').value   = Math.round(totalGs);

    // Panel de equivalencias: PYG es el principal, el resto se divide por su tasa de venta
    const elPyg = document.getElementById('equiv-PYG');
    if (elPyg) elPyg.textContent = 'Gs. ' + Math.round(totalGs).toLocaleString('es-PY');

    const tasaPyg = cotizaciones['PYG'] ? parsearTasa(cotizaciones['PYG'].compra) : 1;

    Object.entries(cotizaciones).forEach(([moneda, cot]) => {
      if (moneda === 'PYG') return;
      const el = document.getElementById('equiv-' + moneda);
      if (!el) return;
      // Inverso de precioEnGs: totalGs × (moneda.compra / PYG.compra)
      const tasaMoneda = parsearTasa(cot.compra);
      const equiv = tasaPyg > 0 ? totalGs * (tasaMoneda / tasaPyg) : 0;
      el.textContent = equiv.toLocaleString('es-PY', { maximumFractionDigits: 2 }) + ' ' + moneda;
    });
  }

  // ── Agregar fila a tabla de detalles ────────────────────────────────────────
  function agregarFilaProducto(id, nombre, precio, stock, moneda, cantidad) {
    const subtotal   = precio * cantidad;
    const subtotalGs = precioEnGs(precio, moneda) * cantidad;
    const esGs = (!moneda || moneda === 'PYG');

    const html = `
      <tr class="table-detalles-row" data-moneda="${moneda}" data-stock="${stock}">
        <td>
          <input type="hidden" name="id_producto[]" value="${id}">
          <strong>${escapeHtml(nombre)}</strong>
          ${!esGs ? `<span class="badge bg-info text-dark ms-1 badge-moneda">${moneda}</span>` : ''}
        </td>
        <td>
          <input type="hidden" name="cantidad[]" class="cantidad-hidden" value="${cantidad}">
          <div class="d-flex justify-content-center align-items-center gap-1">
            <button type="button" class="btn btn-outline-danger btn-quantity btn-menos"><i class="fas fa-minus"></i></button>
            <span class="cantidad-display">${cantidad}</span>
            <button type="button" class="btn btn-outline-success btn-quantity btn-mas"><i class="fas fa-plus"></i></button>
          </div>
        </td>
        <td><input type="text" name="precio_unitario[]" class="form-control form-control-sm text-end" value="${precio}" readonly></td>
        <td><span class="badge bg-secondary badge-moneda">${moneda}</span></td>
        <td><input type="text" name="subtotal[]" class="form-control form-control-sm text-end" value="${subtotal.toFixed(0)}" readonly></td>
        <td><input type="text" name="subtotal_gs[]" class="form-control form-control-sm text-end text-success fw-bold" value="${Math.round(subtotalGs)}" readonly></td>
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

    $.get("{{ route('productos.paraVenta') }}", { q: codigo }, function (r) {
      const productos = r.data || [];
      const producto = productos.find(p => String(p.codigo).trim() === codigo);

      if (!producto) {
        toastr.error('Producto no encontrado para el código: ' + codigo);
        return;
      }

      const stock  = parseInt(producto.cantidad) || 0;
      const moneda = producto.tipo_moneda || 'PYG';
      const precio = parseFloat(producto.precio1);

      if (cantidad > stock) {
        toastr.error(`Solo hay ${stock} unidades disponibles de "${producto.descripcion}"`);
        return;
      }

      let existente = false;
      document.querySelectorAll('#tabla-detalles tbody tr').forEach(tr => {
        if (tr.querySelector('input[name="id_producto[]"]')?.value == producto.id) {
          const display   = tr.querySelector('.cantidad-display');
          const nuevaCant = parseInt(display.innerText) + cantidad;
          if (nuevaCant > stock) { toastr.error(`Stock insuficiente. Máx: ${stock}`); existente = true; return; }
          display.innerText = nuevaCant;
          tr.querySelector('.cantidad-hidden').value = nuevaCant;
          existente = true;
        }
      });

      if (!existente) {
        agregarFilaProducto(producto.id, producto.descripcion, precio, stock, moneda, cantidad);
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

  // ── Botones +/- y eliminar en tabla detalles ────────────────────────────────
  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-mas')) {
      const tr    = e.target.closest('tr');
      const stock = parseInt(tr.dataset.stock) || 999;
      const display = tr.querySelector('.cantidad-display');
      const nueva   = parseInt(display.innerText) + 1;
      if (nueva > stock) { toastr.warning(`Máximo: ${stock} unidades`); return; }
      display.innerText = nueva;
      tr.querySelector('.cantidad-hidden').value = nueva;
      recalcularTotal();
    }

    if (e.target.closest('.btn-menos')) {
      const tr      = e.target.closest('tr');
      const display = tr.querySelector('.cantidad-display');
      const actual  = parseInt(display.innerText);
      if (actual > 1) { display.innerText = actual - 1; tr.querySelector('.cantidad-hidden').value = actual - 1; recalcularTotal(); }
      else toastr.info('La cantidad mínima es 1');
    }

    if (e.target.closest('.eliminar-fila')) {
      const tr = e.target.closest('tr');
      const nombre = tr.querySelector('strong').innerText;
      tr.remove();
      recalcularTotal();
      toastr.info(`${nombre} eliminado`);
    }
  });

  // ── Moneda / tipo de cambio ──────────────────────────────────────────────────
  function actualizarTipoCambio() {
    const moneda = $('#moneda').val();
    if (moneda === 'USD' && cotizaciones['PYG']) {
      $('#tipo_cambio').val(parsearTasa(cotizaciones['PYG'].compra).toFixed(4));
    } else {
      $('#tipo_cambio').val('');
    }
  }
  $('#moneda').on('change', actualizarTipoCambio);
  actualizarTipoCambio();

  // ── Evitar doble click / avisar que se está guardando ───────────────────────
  document.getElementById('form-venta').addEventListener('submit', function () {
    const btn = document.getElementById('btn-guardar-venta');
    if (btn.disabled) return;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
  });

  // ── Número de comprobante ───────────────────────────────────────────────────
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $('#tipo_comprobante').on('change', function () {
    const tipo = $(this).val();
    if (tipo) {
      $.get('/obtenerSiguienteNumero', { tipo_comprobante: tipo }, function (r) {
        $('#numero_comprobante').val(r.numero);
      }).fail(() => alert('Error al obtener el número de comprobante'));
    } else {
      $('#numero_comprobante').val('');
    }

    // La facturación electrónica solo aplica a comprobante "Factura"
    if (tipo === 'Factura') {
      $('#enviar-factura-group').show();
    } else {
      $('#enviar-factura-group').hide();
      $('#enviar_factura').prop('checked', false);
    }
  });

  // ── Inicialización ──────────────────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', function () {
    const condicion  = document.getElementById('condicion');
    const plazoGroup = document.getElementById('plazo-group');
    condicion.addEventListener('change', function () {
      plazoGroup.style.display = this.value === 'credito' ? 'block' : 'none';
    });
    if (condicion.value === 'credito') plazoGroup.style.display = 'block';

    $('#id_cliente').select2({
      theme: 'bootstrap-5',
      width: '100%',
      placeholder: 'Seleccione un cliente',
      language: {
        noResults: () => 'No se encontraron clientes',
        searching: () => 'Buscando...'
      }
    });
  });

  // ── Carga rápida de cliente ─────────────────────────────────────────────────
  const modalNuevoClienteEl = document.getElementById('modalNuevoCliente');
  modalNuevoClienteEl.addEventListener('shown.bs.modal', function () {
    document.getElementById('nuevo-cliente-nombre').focus();
  });
  modalNuevoClienteEl.addEventListener('hidden.bs.modal', function () {
    document.getElementById('nuevo-cliente-nombre').value = '';
    document.getElementById('nuevo-cliente-apellido').value = '';
    document.getElementById('nuevo-cliente-ci').value = '';
    document.getElementById('nuevo-cliente-telefono').value = '';
    document.getElementById('nuevo-cliente-correo').value = '';
    document.getElementById('nuevo-cliente-direccion').value = '';
  });

  document.getElementById('btn-guardar-nuevo-cliente').addEventListener('click', function () {
    const nombre     = document.getElementById('nuevo-cliente-nombre').value.trim();
    const apellido   = document.getElementById('nuevo-cliente-apellido').value.trim();
    const ci         = document.getElementById('nuevo-cliente-ci').value.trim();
    const telefono   = document.getElementById('nuevo-cliente-telefono').value.trim();
    const correo     = document.getElementById('nuevo-cliente-correo').value.trim();
    const direccion  = document.getElementById('nuevo-cliente-direccion').value.trim();

    if (!nombre || !ci) {
      toastr.warning('Nombre y C.I. son obligatorios');
      return;
    }

    const btn = this;
    btn.disabled = true;

    $.ajax({
      url: "{{ route('clientes.store') }}",
      method: 'POST',
      dataType: 'json',
      data: { nombre: nombre, apellido: apellido, ci: ci, telefono: telefono, correo: correo, direccion: direccion },
      success: function (r) {
        const cliente = r.data;
        const texto = `${cliente.ci} - ${cliente.nombre}${cliente.apellido ? ' ' + cliente.apellido : ''}`;
        const option = new Option(texto, cliente.id, true, true);
        $('#id_cliente').append(option).trigger('change');
        bootstrap.Modal.getInstance(modalNuevoClienteEl).hide();
        toastr.success('Cliente agregado correctamente');
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.message || 'Error al guardar el cliente';
        toastr.error(msg);
      },
      complete: function () {
        btn.disabled = false;
      }
    });
  });
</script>

@endsection
