@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Crear Cobro</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'cobros.store']) !!}

            <div class="card-body">

                <div class="row">
                    <!-- Id Cliente Field -->
                   <script>
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Obtener el número de comprobante al cargar la página
                    $(document).ready(function () {
                        $.ajax({
                            url: '/numero_comprobante_cobro',
                            type: 'GET',
                            success: function (response) {
                                $('#numero_comprobante').val(response.numero);
                            },
                            error: function () {
                                alert('Error al obtener el número de comprobante');
                            }
                        });
                    });
                </script>
                <div class="form-group col-sm-3">
                    {!! Form::label('numero_comprobante', 'Número Comprobante:') !!}
                    <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" readonly>
                </div>
                     <div class="form-group col-sm-6">
                                      {!! Form::label('id_cliente', 'Clientes:') !!}
                                      <select name="id_cliente" class="form-control" required>
                                          <option value="">Seleccione un cliente</option>
                                          @foreach($clientes as $cliente)
                                              <option value="{{ $cliente->id }}">{{ $cliente->ci }} - {{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                    <!-- Id Venta Field -->
                    
                    <div class="form-group col-sm-3">
                    {!! Form::label('fecha_cobro', 'Fecha cobro:') !!}
                    {!! Form::text('fecha_cobro', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group col-sm-3">
                        {!! Form::label('id_venta', 'Venta:') !!}
                        <select name="id_venta" id="id_venta" class="form-control" required>
                            <option value="">Seleccione una venta</option>
                        </select>
                    </div>
                    <script>
                    $(document).ready(function() {
                        $('select[name="id_cliente"]').on('change', function () {
                            var clienteId = $(this).val();

                            if (clienteId) {
                                $.ajax({
                                    url: '/ventasCreditoPorCliente/' + clienteId,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function (data) {
                                        let selectVenta = $('#id_venta');
                                        selectVenta.empty(); // Limpiar opciones anteriores
                                        selectVenta.append('<option value="">Seleccione una venta</option>');
                                        
                                        if (data.length > 0) {
                                            $.each(data, function (key, venta) {
                                                selectVenta.append('<option value="' + venta.id + '">N° comprobante: ' + venta.numero_comprobante + ' - Total: Gs.' + venta.total + '</option>');
                                            });
                                        } else {
                                            selectVenta.append('<option value="">No hay ventas a crédito</option>');
                                        }
                                    },
                                    error: function () {
                                        alert('Error al obtener las ventas.');
                                    }
                                });
                            } else {
                                $('#id_venta').empty().append('<option value="">Seleccione una venta</option>');
                            }
                        });
                    });
                </script>

                    <!-- Id Usuario Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('cajeros', 'Cajero:') !!}
                        {!! Form::text('cajeros', Auth::user()->name, ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
                    </div>
                    {!! Form::hidden('cajero', Auth::user()->id) !!}
                      {!! Form::hidden('id_caja', Auth::user()->caja) !!}

                    <!-- Observacion Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('observacion', 'Observacion:') !!}
                        {!! Form::text('observacion', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <hr>
                <!-- Botón para abrir el modal de saldos -->
                <div class="form-group col-sm-3 d-flex align-items-end">
                    <button type="button" class="btn btn-primary" id="btnSeleccionarSaldos" data-toggle="modal" data-target="#modalSaldos">
                        Seleccionar Saldos
                    </button>
                </div>
  <!-- Modal --><hr>
                <div class="modal fade" id="modalSaldos" tabindex="-1" role="dialog" aria-labelledby="modalSaldosLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalSaldosLabel">Saldos disponibles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                         <table class="table table-bordered" id="table">
                          <thead>
                            <tr>
                              <th>Seleccionar</th>
                              <th>N° Cuota</th>
                              <th>Monto cuota</th>
                              <th>Saldo cuota</th>
                              <th>Estado</th>
                              <th>Fecha Vencimiento</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- Aquí se cargarán los datos dinámicamente con JS -->
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" id="confirmarSeleccion" class="btn btn-primary">Seleccionar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <!-- Puedes añadir aquí un botón para confirmar selección si es necesario -->
                      </div>
                    </div>
                  </div>
                </div>
<center><h4>Saldos Seleccionados</h4></center>
<table class="table table-bordered" id="tablaSeleccionados">
    <thead>
        <tr>
            <th>N° Cuota</th>
            <th>Monto cuota</th>
            <th>Saldo cuota</th>
            <th>Monto a pagar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <!-- Se llenará con JS -->
    </tbody>
</table>
<script>
$('#id_venta').on('change', function () {
    let idVenta = $(this).val();
    if (idVenta) {
        $.ajax({
            url: '/saldosPorVenta/' + idVenta,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                let tableBody = $('#table tbody');
                tableBody.empty();

                if (data.length > 0) {
                    data.forEach(function (saldo) {
                        let fila = `
                            <tr>
                                <td>
                                    <input type="checkbox" class="seleccionar-saldo" name="saldos_seleccionados[]" data-id="${saldo.id}" value="${saldo.id}">
                                </td>
                                <td>${saldo.numero_cuota}</td>
                                <td>${saldo.monto}</td>
                                <td>${saldo.saldo}</td>
                                <td>${saldo.estado}</td>
                                <td>${saldo.fecha_vencimiento}</td>
                              
                            </tr>
                        `;
                        tableBody.append(fila);
                    });
                } else {
                    tableBody.append('<tr><td colspan="6">No hay saldos disponibles para esta venta.</td></tr>');
                }
            },
            error: function () {
                alert('Error al cargar los saldos');
            }
        });
    }
});
</script>

<!-- Script para manejar la selección y tabla -->
<script>
$('#confirmarSeleccion').on('click', function () {
    $('.seleccionar-saldo:checked').each(function () {
        const row = $(this).closest('tr');
        const saldoId = $(this).data('id');
        const numeroCuota = row.find('td').eq(1).text();
        const montoTexto = row.find('td').eq(2).text(); // Monto cuota
        const saldoTexto = row.find('td').eq(3).text(); // Saldo cuota
        const monto = montoTexto.replace(/[^0-9.]/g, '');
        const saldo = parseFloat(saldoTexto.replace(/[^\d]/g, '')) || 0;

        if ($('#fila-' + saldoId).length === 0) {
            $('#tablaSeleccionados tbody').append(`
                <tr id="fila-${saldoId}">
                    <td>
                        ${numeroCuota}
                        <input type="hidden" name="cuotas[${saldoId}][numero_cuota]" value="${numeroCuota}">
                    </td>
                    <td>
                        ${montoTexto}
                        <input type="hidden" name="cuotas[${saldoId}][monto]" value="${monto}">
                    </td>
                    <td>
                        ${saldoTexto}
                        <input type="hidden" name="cuotas[${saldoId}][saldo]" value="${saldo}">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="cuotas[${saldoId}][pagado]" step="0.01" min="0" max="${saldo}" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm eliminar-fila" data-id="${saldoId}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `);
        }
    });

    $('#modalSaldos').modal('hide');
});

// Eliminar fila
$(document).on('click', '.eliminar-fila', function () {
    const saldoId = $(this).data('id');
    $('#fila-' + saldoId).remove();
    $('.seleccionar-saldo[data-id="' + saldoId + '"]').prop('checked', false);
});
</script>
<script>
function calcularTotal() {
    let total = 0;

    // Sumamos todos los montos ingresados en los campos "Monto a pagar"
    $('input[name^="cuotas"][name$="[pagado]"]').each(function () {
        const valor = parseFloat($(this).val()) || 0;
        total += valor;
    });

    // Mostramos el total en el campo de texto
    $('input[name="total"]').val(total.toFixed());
}

// Recalcular total cada vez que se cambia el monto a pagar
$(document).on('input', 'input[name^="cuotas"][name$="[pagado]"]', function () {
    calcularTotal();
});

// También llamamos a calcularTotal cuando se agregan nuevas filas
$('#confirmarSeleccion').on('click', function () {
    setTimeout(() => calcularTotal(), 200); // Pequeña espera para asegurar que se agreguen las filas
});

// Recalcular total después de eliminar fila
$(document).on('click', '.eliminar-fila', function () {
    setTimeout(() => calcularTotal(), 100);
});
</script>
</div>
 <div class="container">
                <div class="row justify-content-end">
                    <div class="form-group col-sm-3">
                        <div class="d-flex justify-content-end align-items-center">
                            <span class="mr-2" style="font-size: 24px;">Total:</span>
                            {!! Form::text('total', null, [
                                'class' => 'form-control',
                                'readonly' => true,
                                 'id' => 'campoTotal',
                                'style' => 'text-align: right; font-weight: bold; font-size: 20px; width: 120px;'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('cobros.index') }}" class="btn btn-default">Cancelar</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
