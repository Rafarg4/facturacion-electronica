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
  .card-seccion .card-header { background: #f8f9fa; font-weight: 600; font-size: 0.9rem; }
  .total-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px 14px; }
  .select2-container--bootstrap-5.select2-invalid .select2-selection {
    border-color: #dc3545 !important;
  }
  #tablaSeleccionados.is-invalid {
    outline: 1px solid #dc3545;
  }
  #barra-acciones {
    position: sticky; bottom: 0; z-index: 20;
    background: #fff; border-top: 1px solid #dee2e6;
    box-shadow: 0 -2px 10px rgba(0,0,0,.08);
  }
</style>

<section class="content-header py-2">
  <div class="container-fluid">
    <h5 class="mb-0"><i class="fas fa-hand-holding-usd"></i> Crear Cobro</h5>
  </div>
</section>

<div class="content px-3">
  @include('adminlte-templates::common.errors')

  <div class="card shadow-sm">
    {!! Form::open(['route' => 'cobros.store', 'id' => 'form-cobro']) !!}
    {!! Form::hidden('id_caja', Auth::user()->caja) !!}
    {!! Form::hidden('cajero', Auth::user()->id) !!}

    <div class="card-body pb-2">

      {{-- Sección: Tipo + datos generales --}}
      <div class="card card-seccion mb-3">
        <div class="card-header py-2"><i class="fas fa-hand-holding-usd"></i> Datos del cobro</div>
        <div class="card-body py-2">
          <div class="row g-2">
            <div class="col-md-3">
              <label class="form-label">Cobrar a</label>
              <div class="btn-group w-100" role="group">
                <input type="radio" class="btn-check" name="tipo" id="tipoVenta" value="Venta" checked>
                <label class="btn btn-outline-primary btn-sm" for="tipoVenta"><i class="fas fa-user"></i> Cliente</label>

                <input type="radio" class="btn-check" name="tipo" id="tipoCompra" value="Compra">
                <label class="btn btn-outline-primary btn-sm" for="tipoCompra"><i class="fas fa-truck"></i> Proveedor</label>
              </div>
            </div>
            <div class="col-md-2">
              <label class="form-label">N° Comprobante</label>
              <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control form-control-sm" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Fecha Cobro</label>
              {!! Form::text('fecha_cobro', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control form-control-sm', 'readonly', 'required' => 'required']) !!}
            </div>
            <div class="col-md-2">
              <label class="form-label">Cajero</label>
              {!! Form::text('cajeros', Auth::user()->name, ['class' => 'form-control form-control-sm', 'readonly']) !!}
            </div>
            <div class="col-md-3">
              <label class="form-label">Observación</label>
              {!! Form::text('observacion', null, ['class' => 'form-control form-control-sm']) !!}
            </div>
          </div>
        </div>
      </div>

      {{-- Sección: Cliente/Proveedor + comprobante a crédito --}}
      <div class="card card-seccion mb-3">
        <div class="card-header py-2"><i class="fas fa-file-invoice"></i> Comprobante a crédito</div>
        <div class="card-body py-2">
          <div class="row g-2">
            <div class="col-md-4" id="campo-cliente">
              <label class="form-label">Cliente</label>
              <select name="id_cliente" id="id_cliente" class="form-control form-control-sm" required>
                <option value="">Buscar cliente...</option>
                @foreach($clientes as $cliente)
                  <option value="{{ $cliente->id }}">{{ $cliente->ci }} — {{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4" id="campo-proveedor" style="display:none;">
              <label class="form-label">Proveedor</label>
              <select name="id_proveedor" id="id_proveedor" class="form-control form-control-sm">
                <option value="">Buscar proveedor...</option>
                @foreach($proveedores as $p)
                  <option value="{{ $p->id }}">{{ $p->compania ? $p->compania.' — ' : '' }}{{ $p->nombre }} {{ $p->apellido }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label" id="label-venta">Venta / Factura</label>
              <select name="id_venta" id="id_venta" class="form-control form-control-sm" required>
                <option value="">Seleccione primero un cliente</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      {{-- Sección: Saldos --}}
      <div class="card card-seccion mb-3">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
          <span><i class="fas fa-coins"></i> Saldos</span>
          <button type="button" class="btn btn-outline-primary btn-sm" id="btnSeleccionarSaldos"
                  data-bs-toggle="modal" data-bs-target="#modalSaldos" disabled>
            <i class="fas fa-list-alt"></i> Seleccionar Saldos
          </button>
        </div>
        <div class="card-body py-2">

          <table class="table table-bordered table-sm mb-3" id="tablaSeleccionados">
            <thead class="table-light">
              <tr>
                <th>N° Cuota</th>
                <th>Monto cuota</th>
                <th>Saldo cuota</th>
                <th style="width:180px;">Monto a pagar</th>
                <th style="width:50px;"></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>

          <div class="row justify-content-end g-2 mb-1">
            <div class="col-auto">
              <div class="total-box d-flex align-items-center gap-2">
                <span class="fw-bold">Total:</span>
                {!! Form::text('total', null, [
                  'class'    => 'form-control form-control-sm text-end fw-bold',
                  'readonly' => true,
                  'id'       => 'campoTotal',
                  'style'    => 'width:160px;font-size:1rem;'
                ]) !!}
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

    <div class="card-footer py-2" id="barra-acciones">
      {!! Form::submit('Confirmar Cobro', ['class' => 'btn btn-success btn-sm', 'id' => 'btn-guardar-cobro']) !!}
      <a href="{{ route('cobros.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
    </div>

    {!! Form::close() !!}
  </div>

  {{-- Modal saldos (Bootstrap 5) --}}
  <div class="modal fade" id="modalSaldos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header py-2">
          <h6 class="modal-title mb-0"><i class="fas fa-coins"></i> Saldos disponibles</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body py-2">
          <table class="table table-bordered table-sm" id="tabla-saldos-modal">
            <thead class="table-light">
              <tr>
                <th style="width:40px;">Sel.</th>
                <th>N° Cuota</th>
                <th>Monto cuota</th>
                <th>Saldo cuota</th>
                <th>Estado</th>
                <th>Vencimiento</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <div class="modal-footer py-2">
          <button type="button" id="confirmarSeleccion" class="btn btn-primary btn-sm">
            <i class="fas fa-check"></i> Confirmar selección
          </button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  toastr.options = {
    closeButton: true, newestOnTop: true, progressBar: true,
    positionClass: 'toast-top-right', timeOut: '3000'
  };

  $(document).ready(function () {

    // ── Select2 en cliente y proveedor ───────────────────────────────────────
    $('#id_cliente').select2({
      theme: 'bootstrap-5',
      placeholder: 'Buscar cliente...',
      allowClear: true,
      width: '100%',
      language: { noResults: () => 'No se encontraron resultados', searching: () => 'Buscando...' }
    });

    $('#id_proveedor').select2({
      theme: 'bootstrap-5',
      placeholder: 'Buscar proveedor...',
      allowClear: true,
      width: '100%',
      language: { noResults: () => 'No se encontraron resultados', searching: () => 'Buscando...' }
    });

    // ── N° comprobante automático ────────────────────────────────────────────
    $.ajax({
      url: '/numero_comprobante_cobro',
      type: 'GET',
      success: function (response) {
        $('#numero_comprobante').val(response.numero);
      }
    });

    // ── Alternar Cliente / Proveedor según el tipo de cobro ──────────────────
    function resetVentaSelect(texto) {
      const selectVenta = $('#id_venta');
      selectVenta.empty().append('<option value="">' + texto + '</option>');
      $('#btnSeleccionarSaldos').prop('disabled', true);
      $('#tabla-saldos-modal tbody').empty();
      $('#tablaSeleccionados tbody').empty();
      calcularTotal();
    }

    $('input[name="tipo"]').on('change', function () {
      const esCompra = $(this).val() === 'Compra';

      $('#campo-cliente').toggle(!esCompra);
      $('#campo-proveedor').toggle(esCompra);
      $('#id_cliente').prop('required', !esCompra).val(null).trigger('change.select2');
      $('#id_proveedor').prop('required', esCompra).val(null).trigger('change.select2');
      $('#label-venta').text(esCompra ? 'Compra' : 'Venta / Factura');

      resetVentaSelect(esCompra ? 'Seleccione primero un proveedor' : 'Seleccione primero un cliente');
    });

    // ── Cargar ventas al cambiar cliente ─────────────────────────────────────
    $('#id_cliente').on('change', function () {
      const clienteId = $(this).val();
      resetVentaSelect('Seleccione una venta');
      if (!clienteId) return;

      $.ajax({
        url: '/ventasCreditoPorCliente/' + clienteId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          const selectVenta = $('#id_venta');
          if (data.length > 0) {
            $.each(data, function (key, venta) {
              selectVenta.append(
                '<option value="' + venta.id + '">N° ' + venta.numero_comprobante +
                ' — Total: Gs. ' + Number(venta.total).toLocaleString('es-PY') + '</option>'
              );
            });
          } else {
            selectVenta.append('<option value="" disabled>No hay ventas a crédito</option>');
          }
        },
        error: function () { toastr.error('Error al obtener las ventas.'); }
      });
    });

    // ── Cargar compras al cambiar proveedor ──────────────────────────────────
    $('#id_proveedor').on('change', function () {
      const proveedorId = $(this).val();
      resetVentaSelect('Seleccione una compra');
      if (!proveedorId) return;

      $.ajax({
        url: '/comprasCreditoPorProveedor/' + proveedorId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          const selectVenta = $('#id_venta');
          if (data.length > 0) {
            $.each(data, function (key, compra) {
              selectVenta.append(
                '<option value="' + compra.id + '">N° ' + compra.numero_comprobante +
                ' — Total: Gs. ' + Number(compra.total).toLocaleString('es-PY') + '</option>'
              );
            });
          } else {
            selectVenta.append('<option value="" disabled>No hay compras a crédito</option>');
          }
        },
        error: function () { toastr.error('Error al obtener las compras.'); }
      });
    });

    // ── Cargar saldos al cambiar venta/compra ────────────────────────────────
    $('#id_venta').on('change', function () {
      const idVenta = $(this).val();
      const tipo = $('input[name="tipo"]:checked').val();
      const tableBody = $('#tabla-saldos-modal tbody');

      tableBody.empty();
      $('#btnSeleccionarSaldos').prop('disabled', !idVenta);

      if (!idVenta) return;

      $.ajax({
        url: '/saldosPorVenta/' + idVenta,
        type: 'GET',
        data: { tipo: tipo },
        dataType: 'json',
        success: function (data) {
          if (data.length > 0) {
            data.forEach(function (saldo) {
              tableBody.append(`
                <tr>
                  <td><input type="checkbox" class="seleccionar-saldo" data-id="${saldo.id}"></td>
                  <td>${saldo.numero_cuota}</td>
                  <td>${Number(saldo.monto).toLocaleString('es-PY')}</td>
                  <td>${Number(saldo.saldo).toLocaleString('es-PY')}</td>
                  <td>${saldo.estado}</td>
                  <td>${saldo.fecha_vencimiento}</td>
                </tr>
              `);
            });
          } else {
            tableBody.append('<tr><td colspan="6" class="text-center text-muted">No hay saldos disponibles</td></tr>');
          }
        },
        error: function () { toastr.error('Error al cargar los saldos'); }
      });
    });

    // ── Confirmar selección ───────────────────────────────────────────────────
    $('#confirmarSeleccion').on('click', function () {
      $('.seleccionar-saldo:checked').each(function () {
        const row       = $(this).closest('tr');
        const saldoId   = $(this).data('id');
        const nroCuota  = row.find('td').eq(1).text();
        const montoText = row.find('td').eq(2).text();
        const saldoText = row.find('td').eq(3).text();
        const montoVal  = montoText.replace(/[^0-9]/g, '');
        const saldoVal  = saldoText.replace(/[^0-9]/g, '');

        if ($('#fila-' + saldoId).length === 0) {
          $('#tablaSeleccionados tbody').append(`
            <tr id="fila-${saldoId}">
              <td>
                ${nroCuota}
                <input type="hidden" name="cuotas[${saldoId}][numero_cuota]" value="${nroCuota}">
              </td>
              <td>
                ${montoText}
                <input type="hidden" name="cuotas[${saldoId}][monto]" value="${montoVal}">
              </td>
              <td>
                ${saldoText}
                <input type="hidden" name="cuotas[${saldoId}][saldo]" value="${saldoVal}">
              </td>
              <td>
                <input type="number" class="form-control form-control-sm pagado-input"
                       name="cuotas[${saldoId}][pagado]" min="0" max="${saldoVal}" required>
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-sm eliminar-fila" data-id="${saldoId}">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          `);
        }
      });

      calcularTotal();
      bootstrap.Modal.getInstance(document.getElementById('modalSaldos')).hide();
    });

    // ── Eliminar fila ────────────────────────────────────────────────────────
    $(document).on('click', '.eliminar-fila', function () {
      const saldoId = $(this).data('id');
      $('#fila-' + saldoId).remove();
      $('.seleccionar-saldo[data-id="' + saldoId + '"]').prop('checked', false);
      calcularTotal();
    });

    // ── Calcular total ───────────────────────────────────────────────────────
    $(document).on('input', '.pagado-input', function () {
      calcularTotal();
    });

    function calcularTotal() {
      let total = 0;
      $('.pagado-input').each(function () {
        total += parseFloat($(this).val()) || 0;
      });
      $('#campoTotal').val(Math.round(total).toLocaleString('es-PY'));
    }

    // ── Validación antes de enviar ───────────────────────────────────────────
    $('#form-cobro').on('submit', function (e) {
      const esCompra = $('input[name="tipo"]:checked').val() === 'Compra';
      const quien = esCompra ? $('#id_proveedor') : $('#id_cliente');

      if (!quien.val()) {
        e.preventDefault();
        toastr.error(esCompra ? 'Debe seleccionar un proveedor.' : 'Debe seleccionar un cliente.');
        quien.select2('open');
        return;
      }

      if (!$('#id_venta').val()) {
        e.preventDefault();
        toastr.error('Debe seleccionar ' + (esCompra ? 'una compra.' : 'una venta.'));
        return;
      }

      if ($('#tablaSeleccionados tbody tr').length === 0) {
        e.preventDefault();
        toastr.error('Debe seleccionar al menos un saldo a cancelar.');
        return;
      }
    });

  });
</script>
@endsection
