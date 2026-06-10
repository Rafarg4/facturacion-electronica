@extends('layouts.app')

@section('content')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Cargar compra</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('adminlte-templates::common.errors')

    <div class="card">

        {!! Form::open(['route' => 'compras.store']) !!}

        <div class="card-body">

            <div class="row">
                <div class="form-group col-sm-6">
                    {!! Form::label('id_pedido', 'Nro de pedido:') !!}
                    <select name="id_pedido" id="id_pedido" class="form-control" required>
                        <option value="">Seleccione un pedido</option>
                        @foreach($pedidos as $pedido)
                            <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-3">
                    {!! Form::label('fecha_compra', 'Fecha compra:') !!}
                    {!! Form::text('fecha_compra', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
                </div>

                <div class="form-group col-sm-3">
                    {!! Form::label('tipo_comprobante', 'Tipo de Comprobante:') !!}
                    <select name="tipo_comprobante" class="form-control" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="Recibo">Recibo</option>
                        <option value="Factura">Factura</option>
                        <option value="Ticket">Ticket</option>
                    </select>
                </div>

                <div class="form-group col-sm-3">
                    {!! Form::label('numero_comprobante', 'Numero Comprobante:') !!}
                    {!! Form::text('numero_comprobante', null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group col-sm-3">
                    {!! Form::label('forma_pago', 'Forma de Pago:') !!}
                    {!! Form::select('forma_pago', [
                        'Efectivo' => 'Efectivo',
                        'Tarjeta' => 'Tarjeta',
                        'Transferencia' => 'Transferencia'
                    ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una forma de pago', 'required' => 'required']) !!}
                </div>

                <div class="form-group col-sm-6">
                    {!! Form::label('observacion', 'Observacion:') !!}
                    {!! Form::text('observacion', null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>
            </div>

            <!-- Detalle del pedido (se carga dinámicamente) -->
            <div id="detalle-pedido-container" class="mt-4">
              <center><h5>Detalle del Pedido</h5></center>  
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="detalle-pedido-body">
                        <!-- Aquí se insertan los detalles -->
                    </tbody>
                </table>
            </div>
            <!-- Total Field -->
            <div class="container">
                <div class="row justify-content-end">
                    <div class="form-group col-sm-3">
                        <div class="d-flex justify-content-end align-items-center">
                            <span class="mr-2" style="font-size: 24px;">Total:</span>
                            {!! Form::text('total', null, [
                                'class' => 'form-control',
                                'readonly' => true,
                                'id' => 'total-input',
                                'style' => 'text-align: right; font-weight: bold; font-size: 20px; width: 120px;'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('compras.index') }}" class="btn btn-default">Cancelar</a>
            </div>

        {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- JavaScript para mostrar detalles -->
<script>
document.getElementById('id_pedido').addEventListener('change', function () {
    const pedidoId = this.value;
    const tbody = document.getElementById('detalle-pedido-body');
    const totalInput = document.getElementById('total-input');
    tbody.innerHTML = '';
    totalInput.value = '';

    if (pedidoId) {
        fetch(`/pedido_detalles/${pedidoId}`)
            .then(response => response.json())
            .then(data => {
                let total = 0;

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4">No hay detalles para este pedido.</td></tr>';
                    return;
                }

                data.forEach(detalle => {
                    const subtotal = detalle.cantidad * detalle.precio_unitario;
                    total += subtotal;

                    const row = `
                        <tr>
                            <td>${detalle.nombre_producto}</td>
                            <td>${detalle.cantidad}</td>
                            <td>${detalle.precio_unitario}</td>
                            <td>${subtotal.toFixed()}</td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });

                totalInput.value = total.toFixed();
            })
            .catch(error => {
                console.error('Error al obtener detalles del pedido:', error);
                tbody.innerHTML = '<tr><td colspan="4">Error al cargar los datos.</td></tr>';
            });
    }
});
</script>
@endsection
