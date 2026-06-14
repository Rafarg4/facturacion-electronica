<div class="card">
    <div class="card-body">

        <div class="row">

            <div class="form-group col-md-6">
                {!! Form::label('cliente', 'Cliente:') !!}
                {!! Form::select(
                    'cliente',
                    $clientes->pluck('nombre', 'id'),
                    null,
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Seleccione un cliente',
                        'required'
                    ]
                ) !!}
            </div>

            <div class="form-group col-md-3">
                {!! Form::label('tipo_presupuesto', 'Tipo:') !!}
                {!! Form::select(
                    'tipo_presupuesto',
                    [
                        'COMPRA' => 'Compra',
                        'VENTA'  => 'Venta'
                    ],
                    null,
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Seleccione',
                        'required'
                    ]
                ) !!}
            </div>

            <div class="form-group col-md-3">
                {!! Form::label('cod_lista_precio', 'Precio lista:') !!}
                {!! Form::select(
                    'cod_lista_precio',
                    [
                        'Precio 1' => 'Precio 1',
                        'PPrecio 2' => 'PPrecio 2',
                        'Precio 3' => 'Precio 3'
                    ],
                    null,
                    ['class' => 'form-control']
                ) !!}
            </div>

        </div>

        <div class="row">

            <div class="form-group col-md-4">
                {!! Form::label('responsable', 'Responsable:') !!}
                {!! Form::text(
                    'responsable',
                    isset($presupuestoCabecera)
                        ? $presupuestoCabecera->responsable
                        : auth()->user()->name,
                    [
                        'class' => 'form-control',
                        'readonly'
                    ]
                ) !!}
            </div>

            <div class="form-group col-md-8">
                {!! Form::label('descripcion', 'Descripción:') !!}
                {!! Form::textarea(
                    'descripcion',
                    null,
                    [
                        'class' => 'form-control',
                        'rows' => 2,
                        'placeholder' => 'Observaciones del presupuesto'
                    ]
                ) !!}
            </div>

        </div>

    </div>

</div>
<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-md-6">
                <h4>
                    <i class="fa fa-list"></i>
                    Detalle del Presupuesto
                </h4>
            </div>

            <div class="col-md-6 text-right">

                <button
                    type="button"
                    class="btn btn-success"
                    id="agregarDetalle">

                    <i class="fa fa-plus"></i>
                    Agregar Concepto

                </button>

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover" id="tablaDetalle">

                <thead>

                    <tr>

                        <th width="10%" class="text-center">
                            Cant.
                        </th>

                        <th width="45%">
                            Concepto
                        </th>

                        <th width="15%" class="text-right">
                            Precio Unit.
                        </th>

                        <th width="15%" class="text-right">
                            Importe
                        </th>

                        <th width="15%" class="text-center">
                            Acción
                        </th>

                    </tr>

                </thead>

                <tbody>

                </tbody>

            </table>

        </div>

        <div class="row mt-3">

            <div class="col-md-8"></div>

            <div class="col-md-4">

                <table class="table">

                    <tr>
                        <th>Sub Total</th>
                        <td class="text-right">
                            <span id="lblSubTotal">
                                Gs. 0
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Total</th>
                        <td class="text-right">
                            <strong id="lblTotal">
                                Gs. 0
                            </strong>
                        </td>
                    </tr>

                </table>

            </div>

        </div>

        {!! Form::hidden('sub_total', null, ['id' => 'sub_total_field']) !!}
        {!! Form::hidden('total', null, ['id' => 'total_field']) !!}

    </div>

</div>
<script>
    $(document).ready(function(){

    $('#agregarDetalle').click(function(){

        $('#tablaDetalle tbody').append(`
            <tr>

                <td>
                    <input
                        type="number"
                        name="cantidad[]"
                        class="form-control cantidad"
                        value="1">
                </td>

                <td>
                    <input
                        type="text"
                        name="concepto[]"
                        class="form-control">
                </td>

                <td>
                    <input
                        type="number"
                        name="precio_unitario[]"
                        class="form-control precio"
                        value="0">
                </td>

                <td>
                    <input
                        type="text"
                        class="form-control importe"
                        readonly
                        value="0">
                </td>

                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-danger eliminar">

                        <i class="fa fa-trash"></i>

                    </button>

                </td>

            </tr>
        `);

    });

    $(document).on(
        'keyup change',
        '.cantidad, .precio',
        calcularTotales
    );

    $(document).on(
        'click',
        '.eliminar',
        function(){

            $(this).closest('tr').remove();

            calcularTotales();

        }
    );

    function calcularTotales(){

        let subtotal = 0;

        $('#tablaDetalle tbody tr').each(function(){

            let cantidad =
                parseFloat(
                    $(this).find('.cantidad').val()
                ) || 0;

            let precio =
                parseFloat(
                    $(this).find('.precio').val()
                ) || 0;

            let importe =
                cantidad * precio;

            $(this)
                .find('.importe')
                .val(
                    importe.toLocaleString('es-PY')
                );

            subtotal += importe;

        });

        $('#sub_total_field').val(subtotal);
        $('#total_field').val(subtotal);

        $('#lblSubTotal').html(
            'Gs. ' +
            subtotal.toLocaleString('es-PY')
        );

        $('#lblTotal').html(
            'Gs. ' +
            subtotal.toLocaleString('es-PY')
        );

    }

});
</script>