@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">

<style>
  .form-label { font-size: 0.8rem; font-weight: 600; margin-bottom: 2px; color: #555; }
  .total-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px 14px; }
</style>

<section class="content-header py-2">
  <div class="container-fluid">
    <h5 class="mb-0"><i class="fas fa-hand-holding-usd"></i> Crear Cobro</h5>
  </div>
</section>

<div class="content px-3">

  @include('adminlte-templates::common.errors')

  <div class="card shadow-sm">

    {!! Form::open(['route' => 'cobros.store']) !!}

    <div class="card-body pb-2">

      {{-- Fila 1: N° Comprobante + Cliente + Fecha + Cajero --}}
      <div class="row g-2 mb-2">
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-hashtag"></i> N° Comprobante</label>
          <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control form-control-sm" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label"><i class="fas fa-user"></i> Cliente</label>
          <select name="id_cliente" id="id_cliente" class="form-control form-control-sm" required>
            <option value="">Buscar cliente...</option>
            @foreach($clientes as $cliente)
              <option value="{{ $cliente->id }}">{{ $cliente->ci }} — {{ $cliente->nombre }} {{ $cliente->apellido }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-calendar-alt"></i> Fecha Cobro</label>
          {!! Form::text('fecha_cobro', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control form-control-sm', 'readonly', 'required' => 'required']) !!}
        </div>
        <div class="col-md-2">
          <label class="form-label"><i class="fas fa-user-tie"></i> Cajero</label>
          {!! Form::text('cajeros', Auth::user()->name, ['class' => 'form-control form-control-sm', 'readonly', 'required' => 'required']) !!}
        </div>
      </div>

      {{-- Fila 2: Venta + Observación --}}
      <div class="row g-2 mb-3">
        <div class="col-md-3">
          <label class="form-label"><i class="fas fa-file-invoice"></i> Venta / Factura</label>
          <select name="id_venta" id="id_venta" class="form-control form-control-sm" required>
            <option value="">Seleccione primero un cliente</option>
          </select>
        </div>
        <div class="col-md-5">
          <label class="form-label"><i class="fas fa-sticky-note"></i> Observación</label>
          {!! Form::text('observacion', null, ['class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      {!! Form::hidden('cajero', Auth::user()->id) !!}
      {!! Form::hidden('id_caja', Auth::user()->caja) !!}

      <hr>

      {{-- Botón seleccionar saldos (Bootstrap 4: data-toggle / data-target) --}}
      <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="btnSeleccionarSaldos"
              data-toggle="modal" data-target="#modalSaldos" disabled>
        <i class="fas fa-list-alt"></i> Seleccionar Saldos
      </button>

      {{-- Modal saldos (Bootstrap 4) --}}
      <div class="modal fade" id="modalSaldos" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header py-2">
              <h6 class="modal-title mb-0"><i class="fas fa-coins"></i> Saldos disponibles</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body py-2">
              <table class="table table-bordered table-sm" id="tabla-saldos-modal">
                <thead class="thead-light">
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
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      {{-- Tabla saldos seleccionados --}}
      <h6 class="text-center mb-2"><i class="fas fa-check-circle text-success"></i> Saldos Seleccionados</h6>
      <table class="table table-bordered table-sm" id="tablaSeleccionados">
        <thead class="thead-light">
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

      {{-- Total --}}
      <div class="row justify-content-end mb-2">
        <div class="col-auto">
          <div class="total-box d-flex align-items-center">
            <span class="font-weight-bold mr-2" style="font-size:1rem;">Total:</span>
            {!! Form::text('total', null, [
              'class'    => 'form-control form-control-sm text-right font-weight-bold',
              'readonly' => true,
              'id'       => 'campoTotal',
              'style'    => 'width:160px;font-size:1rem;'
            ]) !!}
          </div>
        </div>
      </div>

    </div>

    <div class="card-footer py-2">
      {!! Form::submit('Confirmar Cobro', ['class' => 'btn btn-success btn-sm']) !!}
      <a href="{{ route('cobros.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
    </div>

    {!! Form::close() !!}

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {

  // ── Select2 en cliente ───────────────────────────────────────────────────────
  $('#id_cliente').select2({
    placeholder: 'Buscar cliente...',
    allowClear: true,
    width: '100%',
    language: {
      noResults: function () { return 'No se encontraron resultados'; },
      searching: function () { return 'Buscando...'; }
    }
  });

  // ── N° comprobante automático ────────────────────────────────────────────────
  $.ajax({
    url: '/numero_comprobante_cobro',
    type: 'GET',
    success: function (response) {
      $('#numero_comprobante').val(response.numero);
    }
  });

  // ── Cargar ventas al cambiar cliente ─────────────────────────────────────────
  $('#id_cliente').on('change', function () {
    const clienteId = $(this).val();
    const selectVenta = $('#id_venta');

    selectVenta.empty().append('<option value="">Seleccione una venta</option>');
    $('#btnSeleccionarSaldos').prop('disabled', true);
    $('#tabla-saldos-modal tbody').empty();

    if (!clienteId) return;

    $.ajax({
      url: '/ventasCreditoPorCliente/' + clienteId,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
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
      error: function () {
        alert('Error al obtener las ventas.');
      }
    });
  });

  // ── Cargar saldos al cambiar venta ───────────────────────────────────────────
  $('#id_venta').on('change', function () {
    const idVenta = $(this).val();
    const tableBody = $('#tabla-saldos-modal tbody');

    tableBody.empty();
    $('#btnSeleccionarSaldos').prop('disabled', !idVenta);

    if (!idVenta) return;

    $.ajax({
      url: '/saldosPorVenta/' + idVenta,
      type: 'GET',
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
      error: function () {
        alert('Error al cargar los saldos');
      }
    });
  });

  // ── Confirmar selección ───────────────────────────────────────────────────────
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
    $('#modalSaldos').modal('hide');
  });

  // ── Eliminar fila ────────────────────────────────────────────────────────────
  $(document).on('click', '.eliminar-fila', function () {
    const saldoId = $(this).data('id');
    $('#fila-' + saldoId).remove();
    $('.seleccionar-saldo[data-id="' + saldoId + '"]').prop('checked', false);
    calcularTotal();
  });

  // ── Calcular total ───────────────────────────────────────────────────────────
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

});
</script>
@endsection
