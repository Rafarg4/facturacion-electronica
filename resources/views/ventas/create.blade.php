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
  .btn-reciente { font-size: 0.72rem; padding: 0.2rem 0.4rem; }
  .sticky-top { position: sticky; top: 0; z-index: 10; }
  .preview-item { padding: 8px; border: 1px solid #dee2e6; border-radius: 5px; background: #f8f9fa; font-size: 0.85rem; }
  .total-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px 14px; }
  .total-gs-box { background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 8px; padding: 10px 14px; }
  .badge-moneda { font-size: 0.7rem; }
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
    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Nueva Venta</h5>
  </div>
</section>

<div class="content px-3">
  @include('adminlte-templates::common.errors')

  <div class="card shadow-sm">
    {!! Form::open(['route' => 'ventas.store']) !!}
    {!! Form::hidden('id_caja', Auth::user()->caja) !!}

    <div class="card-body pb-2">

      {{-- Fila 1: Cliente + Cajero + Fecha + Observacion --}}
      <div class="row g-2 mb-2">
        <div class="col-md-4">
          <label class="form-label"><i class="fas fa-user"></i> Cliente</label>
          <select name="id_cliente" class="form-control form-control-sm" required>
            <option value="">Seleccione un cliente</option>
            @foreach($clientes as $c)
              <option value="{{ $c->id }}">{{ $c->ci }} - {{ $c->nombre }} {{ $c->apellido }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label"><i class="fas fa-user-tie"></i> Cajero</label>
          {!! Form::hidden('id_usuario', Auth::user()->id) !!}
          {!! Form::text('nombre_usuario', Auth::user()->name, ['class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-calendar-alt"></i> Fecha</label>
          {!! Form::text('fecha_venta', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control form-control-sm', 'readonly', 'required' => 'required']) !!}
        </div>
        <div class="col-md-3">
          <label class="form-label"><i class="fas fa-sticky-note"></i> Observación</label>
          {!! Form::text('observacion', null, ['class' => 'form-control form-control-sm', 'required' => 'required']) !!}
        </div>
      </div>

      {{-- Fila 2: Comprobante + N° + IVA + Forma pago + Condición + Plazo --}}
      <div class="row g-2 mb-4">
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-receipt"></i> Comprobante</label>
          <select name="tipo_comprobante" id="tipo_comprobante" class="form-control form-control-sm" required>
            <option value="">Seleccione</option>
            <option value="Recibo">Recibo</option>
            <option value="Factura">Factura</option>
            <option value="Ticket">Ticket</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-hashtag"></i> N° Comprobante</label>
          <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control form-control-sm" readonly>
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-percent"></i> IVA</label>
          {!! Form::select('iva', ['10' => '10%', '5' => '5%', 'Exenta' => 'Exenta'], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Seleccione', 'required' => 'required']) !!}
        </div>
        <div class="col-md-4">
          <label class="form-label"><i class="fas fa-credit-card"></i> Forma de pago</label>
          {!! Form::select('forma_pago', ['Efectivo' => 'Efectivo', 'Tarjeta' => 'Tarjeta', 'Transferencia' => 'Transferencia'], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Seleccione', 'required' => 'required']) !!}
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-hand-holding-usd"></i> Condición</label>
          {!! Form::select('condicion_venta', ['contado' => 'Contado', 'credito' => 'Crédito'], null, ['class' => 'form-control form-control-sm', 'id' => 'condicion', 'required' => 'required']) !!}
        </div>
        <div class="col-md-2" id="plazo-group" style="display:none;">
          <label class="form-label"><i class="fas fa-clock"></i> Plazo</label>
          {!! Form::select('plazo', ['30' => '30 días', '60' => '60 días', '90' => '90 días'], null, ['id' => 'plazo', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      {{-- Botón agregar producto --}}
      <button type="button" class="btn btn-outline-primary btn-sm mb-2" id="btn-abrir-modal" data-bs-toggle="modal" data-bs-target="#modalProductos">
        <i class="fas fa-plus" id="icon-abrir-modal"></i>
        <span id="texto-abrir-modal">Agregar producto</span>
      </button>

      {{-- Modal productos --}}
      <div class="modal fade" id="modalProductos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 90vw;">
          <div class="modal-content" style="position:relative;">
            <div class="modal-loading-overlay" id="modal-loading" style="display:none;">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 mb-0 text-muted fw-semibold" style="font-size:0.9rem;">Cargando productos...</p>
            </div>
            <div class="modal-header py-2">
              <h6 class="modal-title mb-0"><i class="fas fa-shopping-cart"></i> Agregar productos</h6>
              <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-2">
              <div class="row g-2">
                {{-- Izquierda: tabla --}}
                <div class="col-lg-8">
                  <div class="mb-2">
                    <input type="text" id="buscar-producto" class="form-control form-control-sm" placeholder="Buscar por nombre, código o ID...">
                  </div>
                  <div class="row g-2 mb-2">
                    <div class="col-md-6">
                      <div class="d-flex gap-1 align-items-center">
                        <small class="text-muted text-nowrap">Precio:</small>
                        <input type="number" id="filtro-precio-min" class="form-control form-control-sm" placeholder="Mín" min="0">
                        <input type="number" id="filtro-precio-max" class="form-control form-control-sm" placeholder="Máx" min="0">
                        <button class="btn btn-outline-secondary btn-sm" id="btn-filtrar-precio"><i class="fas fa-filter"></i></button>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <select id="filtro-stock" class="form-control form-control-sm">
                        <option value="">Stock: todos</option>
                        <option value="bajo">Bajo (1-5)</option>
                        <option value="medio">Medio (6-20)</option>
                        <option value="alto">Alto (>20)</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <div class="d-flex gap-1 align-items-center">
                        <small class="text-muted text-nowrap">Cant:</small>
                        <button type="button" class="btn btn-outline-secondary btn-sm cantidad-rapida" data-cantidad="1">1</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm cantidad-rapida" data-cantidad="5">5</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm cantidad-rapida" data-cantidad="10">10</button>
                        <input type="number" id="cantidad-custom" class="form-control form-control-sm" placeholder="N" min="1" style="max-width:55px;">
                      </div>
                    </div>
                  </div>

                  <div style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-bordered table-hover table-sm mb-0" id="tabla-productos-modal">
                      <thead class="table-light sticky-top">
                        <tr>
                          <th style="width:75px;">Código</th>
                          <th>Nombre</th>
                          <th style="width:60px;">Moneda</th>
                          <th style="width:65px;">Stock</th>
                          <th style="width:90px;">Precio</th>
                          <th style="width:90px;">Cantidad</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($productos as $producto)
                        <tr class="fila-producto"
                            data-producto-id="{{ $producto->id }}"
                            data-nombre="{{ $producto->descripcion }}"
                            data-precio="{{ $producto->precio1 }}"
                            data-stock="{{ $producto->cantidad }}"
                            data-moneda="{{ $producto->tipo_moneda ?? 'PYG' }}"
                            data-codigo="{{ $producto->codigo }}">
                          <td><small class="text-muted">{{ $producto->codigo }}</small></td>
                          <td><strong>{{ $producto->descripcion }}</strong></td>
                          <td><span class="badge bg-secondary badge-moneda">{{ $producto->tipo_moneda ?? 'PYG' }}</span></td>
                          <td><span class="badge bg-secondary">{{ $producto->cantidad }}</span></td>
                          <td>{{ number_format($producto->precio1) }}</td>
                          <td>
                            <input type="number" class="form-control form-control-sm cantidad-producto" value="1" tabindex="-1">
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

                {{-- Derecha: recientes + preview --}}
                <div class="col-lg-4">
                  <div class="card mb-2">
                    <div class="card-header py-1">
                      <small><i class="fas fa-history"></i> Recientes</small>
                    </div>
                    <div class="card-body p-2" style="max-height:150px;overflow-y:auto;" id="productos-recientes">
                      <small class="text-muted">No hay recientes aún</small>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header py-1">
                      <small><i class="fas fa-eye"></i> Vista previa</small>
                    </div>
                    <div class="card-body p-2" style="max-height:260px;overflow-y:auto;" id="preview-carrito">
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
      <div class="text-center mb-1 mt-2"><strong><i class="fas fa-box-open"></i> Productos seleccionados</strong></div>
      <table class="table table-bordered table-hover table-sm" id="tabla-detalles">
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

      {{-- Panel equivalencias en otras monedas (solo visual) --}}
      @if($cotizaciones->count() > 0)
      <div class="row justify-content-end mb-2">
        <div class="col-auto">
          <div class="card border-info" style="min-width:300px;">
            <div class="card-header bg-info text-white py-1" style="font-size:11px;">
              <i class="fas fa-exchange-alt"></i> Equivalencias (referencial)
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
        </div>
      </div>
      @endif

    </div>

    <div class="card-footer py-2">
      {!! Form::submit('Guardar', ['class' => 'btn btn-primary btn-sm']) !!}
      <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
    </div>

    {!! Form::close() !!}
  </div>
</div>

<script>
  // ── Datos del servidor ──────────────────────────────────────────────────────
  const productosDisponibles = {
    @foreach($productos as $producto)
      {{ $producto->id }}: {
        nombre: @json($producto->descripcion),
        stock: {{ $producto->cantidad }},
        precio: {{ $producto->precio1 }},
        moneda: @json($producto->tipo_moneda ?? 'PYG')
      },
    @endforeach
  };

  // Cotizaciones indexadas por tipo_moneda (compra/venta guardados como strings para preservar formato)
  const cotizaciones = {
    @foreach($cotizaciones as $moneda => $cot)
      @json($moneda): { compra: "{{ $cot->compra }}", venta: "{{ $cot->venta }}" },
    @endforeach
  };

  // ── Estado ──────────────────────────────────────────────────────────────────
  let productoSeleccionado = null;
  let productosRecientes = JSON.parse(localStorage.getItem('productosRecientes')) || [];

  // ── Toastr ──────────────────────────────────────────────────────────────────
  toastr.options = {
    closeButton: true, newestOnTop: true, progressBar: true,
    positionClass: 'toast-top-right', timeOut: '3000'
  };

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
    console.log(`[precioEnGs] ${precio} ${moneda} × (${tasaPyg}/${tasaMoneda}) = ${resultado} GS`);
    return resultado;
  }

  // ── Recientes ───────────────────────────────────────────────────────────────
  function actualizarRecientes() {
    const container = document.getElementById('productos-recientes');
    if (!productosRecientes.length) {
      container.innerHTML = '<small class="text-muted">No hay recientes aún</small>';
      return;
    }
    container.innerHTML = productosRecientes.map(p => `
      <button type="button" class="btn btn-light btn-reciente w-100 text-start mb-1 btn-reciente-producto"
        data-id="${p.id}" data-nombre="${p.nombre}" data-precio="${p.precio}" data-stock="${p.stock}" data-moneda="${p.moneda}">
        <strong>${p.nombre}</strong><br>
        <span class="text-muted">${Number(p.precio).toLocaleString()} ${p.moneda}</span>
        <span class="badge bg-secondary ms-1">${p.stock}</span>
      </button>
    `).join('');
  }

  // ── Preview ─────────────────────────────────────────────────────────────────
  function mostrarPreview(id, nombre, precio, stock, moneda) {
    productoSeleccionado = { id, nombre, precio, stock, moneda };
    const cantidadInput = document.querySelector(`tr[data-producto-id="${id}"] .cantidad-producto`);
    const cantidad = parseInt(cantidadInput?.value) || 1;
    const subtotal = precio * cantidad;
    const subtotalGs = precioEnGs(precio, moneda) * cantidad;
    const esGs = (!moneda || moneda === 'PYG');

    document.getElementById('preview-carrito').innerHTML = `
      <div class="preview-item">
        <strong>${nombre}</strong>
        <p class="mb-1 mt-1"><small>Precio: <strong>${Number(precio).toLocaleString()} ${moneda}</strong></small></p>
        <p class="mb-1"><small>Stock: <span class="badge bg-secondary">${stock}</span></small></p>
        <p class="mb-1"><small>Cantidad: <span class="badge bg-primary">${cantidad}</span></small></p>
        <hr class="my-1">
        <p class="mb-0 text-end">Subtotal: <strong>${Number(subtotal).toLocaleString()} ${moneda}</strong></p>
        ${!esGs ? `<p class="mb-0 text-end text-success">≈ <strong>${Math.round(subtotalGs).toLocaleString()} GS</strong></p>` : ''}
      </div>
    `;
  }

  // ── Filtros ─────────────────────────────────────────────────────────────────
  function filtrarProductos() {
    const filtro = document.getElementById('buscar-producto').value.toLowerCase();
    const minP = parseInt(document.getElementById('filtro-precio-min').value) || 0;
    const maxP = parseInt(document.getElementById('filtro-precio-max').value) || 999999999;
    const filtroStock = document.getElementById('filtro-stock').value;

    document.querySelectorAll('#tabla-productos-modal tbody .fila-producto').forEach(fila => {
      const precio  = parseInt(fila.dataset.precio);
      const stock   = parseInt(fila.dataset.stock);
      const codigo  = (fila.dataset.codigo ?? '').toLowerCase();
      const nombre  = (fila.dataset.nombre ?? '').toLowerCase();
      let ok = (nombre.includes(filtro) || codigo.includes(filtro)) && precio >= minP && precio <= maxP;
      if (filtroStock === 'bajo')  ok = ok && stock >= 1  && stock <= 5;
      if (filtroStock === 'medio') ok = ok && stock >= 6  && stock <= 20;
      if (filtroStock === 'alto')  ok = ok && stock > 20;
      fila.style.display = ok ? '' : 'none';
    });
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
      <tr class="table-detalles-row" data-moneda="${moneda}">
        <td>
          <input type="hidden" name="id_producto[]" value="${id}">
          <strong>${nombre}</strong>
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

  // ── Event listeners filtros ─────────────────────────────────────────────────
  document.getElementById('buscar-producto').addEventListener('keyup', filtrarProductos);
  document.getElementById('filtro-precio-min').addEventListener('change', filtrarProductos);
  document.getElementById('filtro-precio-max').addEventListener('change', filtrarProductos);
  document.getElementById('filtro-stock').addEventListener('change', filtrarProductos);
  document.getElementById('btn-filtrar-precio').addEventListener('click', filtrarProductos);

  // ── Cantidad rápida ─────────────────────────────────────────────────────────
  document.querySelectorAll('.cantidad-rapida').forEach(btn => {
    btn.addEventListener('click', function () {
      const fila = document.querySelector('.fila-producto.seleccionada');
      if (!fila) return;
      fila.querySelector('.cantidad-producto').value = this.dataset.cantidad;
      mostrarPreview(fila.dataset.productoId, fila.dataset.nombre,
        parseFloat(fila.dataset.precio), parseInt(fila.dataset.stock), fila.dataset.moneda);
    });
  });

  document.getElementById('cantidad-custom').addEventListener('change', function () {
    if (!this.value) return;
    const fila = document.querySelector('.fila-producto.seleccionada');
    if (fila) {
      fila.querySelector('.cantidad-producto').value = this.value;
      mostrarPreview(fila.dataset.productoId, fila.dataset.nombre,
        parseFloat(fila.dataset.precio), parseInt(fila.dataset.stock), fila.dataset.moneda);
    }
    this.value = '';
  });

  // ── Click en filas y recientes ──────────────────────────────────────────────
  document.addEventListener('click', function (e) {
    const fila = e.target.closest('.fila-producto');
    if (fila && !e.target.closest('.cantidad-producto')) {
      document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
      fila.classList.add('seleccionada');
      fila.querySelector('.cantidad-producto').value = 1;
      mostrarPreview(fila.dataset.productoId, fila.dataset.nombre,
        parseFloat(fila.dataset.precio), parseInt(fila.dataset.stock), fila.dataset.moneda);
    }

    const btnReciente = e.target.closest('.btn-reciente-producto');
    if (btnReciente) {
      const id = btnReciente.dataset.id;
      const filaTarget = document.querySelector(`tr[data-producto-id="${id}"]`);
      if (filaTarget) {
        filaTarget.scrollIntoView({ behavior: 'smooth', block: 'center' });
        document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
        filaTarget.classList.add('seleccionada');
        filaTarget.querySelector('.cantidad-producto').value = 1;
        mostrarPreview(id, btnReciente.dataset.nombre, parseFloat(btnReciente.dataset.precio),
          parseInt(btnReciente.dataset.stock), btnReciente.dataset.moneda);
      }
    }
  });

  document.addEventListener('dblclick', function (e) {
    const fila = e.target.closest('.fila-producto');
    if (fila) {
      document.querySelectorAll('.fila-producto').forEach(f => f.classList.remove('seleccionada'));
      fila.classList.add('seleccionada');
      document.getElementById('btn-agregar-modal').click();
    }
  });

  document.addEventListener('keypress', function (e) {
    if (e.key === 'Enter' && document.querySelector('.fila-producto.seleccionada')) {
      document.getElementById('btn-agregar-modal').click();
    }
  });

  // ── Botón Agregar en modal ──────────────────────────────────────────────────
  document.getElementById('btn-agregar-modal').addEventListener('click', function () {
    if (!productoSeleccionado) {
      toastr.warning('Selecciona un producto primero');
      return;
    }
    const { id, nombre, precio, stock, moneda } = productoSeleccionado;
    const fila = document.querySelector(`tr[data-producto-id="${id}"]`);
    let cantidad = parseInt(fila.querySelector('.cantidad-producto').value) || 1;

    if (cantidad < 1) { toastr.warning('La cantidad debe ser mayor a 0'); return; }
    if (cantidad > stock) {
      toastr.error(`Solo hay ${stock} unidades disponibles`);
      fila.querySelector('.cantidad-producto').value = stock;
      return;
    }

    productosRecientes = productosRecientes.filter(p => p.id !== id);
    productosRecientes.unshift({ id, nombre, precio, stock, moneda });
    productosRecientes = productosRecientes.slice(0, 5);
    localStorage.setItem('productosRecientes', JSON.stringify(productosRecientes));
    actualizarRecientes();

    let existente = false;
    document.querySelectorAll('#tabla-detalles tbody tr').forEach(tr => {
      if (tr.querySelector('input[name="id_producto[]"]')?.value == id) {
        const display = tr.querySelector('.cantidad-display');
        const nuevaCant = parseInt(display.innerText) + cantidad;
        if (nuevaCant > stock) { toastr.error(`Stock insuficiente. Máx: ${stock}`); existente = true; return; }
        display.innerText = nuevaCant;
        tr.querySelector('.cantidad-hidden').value = nuevaCant;
        existente = true;
      }
    });

    if (!existente) {
      agregarFilaProducto(id, nombre, precio, stock, moneda, cantidad);
    }

    recalcularTotal();
    toastr.success(`${nombre} agregado (x${cantidad})`);
    fila.querySelector('.cantidad-producto').value = 1;
    productoSeleccionado = null;
    document.getElementById('preview-carrito').innerHTML = '<small class="text-muted">Selecciona un producto</small>';
  });

  // ── Botones +/- y eliminar en tabla detalles ────────────────────────────────
  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-mas')) {
      const tr    = e.target.closest('tr');
      const id    = tr.querySelector('input[name="id_producto[]"]').value;
      const stock = productosDisponibles[id]?.stock ?? 999;
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
  });

  // ── Loading overlay del modal ───────────────────────────────────────────────
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

  // ── Inicialización ──────────────────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', function () {
    const condicion  = document.getElementById('condicion');
    const plazoGroup = document.getElementById('plazo-group');
    condicion.addEventListener('change', function () {
      plazoGroup.style.display = this.value === 'credito' ? 'block' : 'none';
    });
    if (condicion.value === 'credito') plazoGroup.style.display = 'block';
    actualizarRecientes();
  });
</script>

@endsection
