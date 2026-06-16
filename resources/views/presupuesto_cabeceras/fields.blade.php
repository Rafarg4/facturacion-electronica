<style>
.select2-container--default .select2-selection--single {
    height: 38px !important;
    border: 1px solid #ced4da;
    border-radius: 4px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 38px;
    padding-left: 8px;
    color: #495057;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
.select2-container {
    width: 100% !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #28a745;
}
#tablaDetalle td {
    vertical-align: middle;
}
</style>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-body">

        <div class="row">

            <div class="form-group col-md-6">
                {!! Form::label('id_cliente', 'Cliente:') !!}
                {!! Form::select(
                    'id_cliente',
                    $clientes,
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
                        'placeholder' => 'Seleccione una opción',
                        'required'
                    ]
                ) !!}
            </div>

            <div class="form-group col-md-3">
                {!! Form::label('cod_lista_precio', 'Precio lista:') !!}
                {!! Form::select(
                    'cod_lista_precio',
                    [
                        'Precio 1'  => 'Precio 1',
                        'PPrecio 2' => 'Precio 2',
                        'Precio 3'  => 'Precio 3'
                    ],
                    null,
                    ['class' => 'form-control', 'id' => 'cod_lista_precio']
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
                        : (auth()->user() ? auth()->user()->name : ''),
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
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4>
                    <i class="fa fa-list"></i>
                    Detalle del Presupuesto
                </h4>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success" id="agregarDetalle">
                    <i class="fa fa-plus"></i>
                    Agregar Producto
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tablaDetalle">
                <thead class="thead-light">
                    <tr>
                        <th width="8%" class="text-center">Cant.</th>
                        <th width="47%">Producto / Concepto</th>
                        <th width="18%" class="text-right">Precio Unit.</th>
                        <th width="15%" class="text-right">Importe</th>
                        <th width="12%" class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="row mt-3">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <table class="table table-sm">
                    <tr>
                        <th>Sub Total</th>
                        <td class="text-right">
                            <span id="lblSubTotal">Gs. 0</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td class="text-right">
                            <strong id="lblTotal">Gs. 0</strong>
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
$(document).ready(function () {

    const urlBuscar = '{{ route("productos.buscar") }}';

    function crearFila() {
        return $('<tr>' +
            '<td>' +
                '<input type="number" name="cantidad[]" class="form-control cantidad text-center" value="1" min="1">' +
            '</td>' +
            '<td>' +
                '<select name="concepto[]" class="form-control select-concepto" required>' +
                    '<option value=""></option>' +
                '</select>' +
            '</td>' +
            '<td>' +
                '<input type="number" name="precio_unitario[]" class="form-control precio text-right" value="0" min="0" step="1">' +
            '</td>' +
            '<td>' +
                '<input type="text" class="form-control importe text-right" readonly value="0">' +
            '</td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-danger btn-sm eliminar">' +
                    '<i class="fa fa-trash"></i>' +
                '</button>' +
            '</td>' +
        '</tr>');
    }

    function initSelect2(fila) {
        fila.find('.select-concepto').select2({
            placeholder: 'Buscar por nombre o código...',
            allowClear: true,
            width: '100%',
            minimumInputLength: 1,
            ajax: {
                url: urlBuscar,
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return { results: data.results };
                },
                error: function (xhr) {
                    console.error('Error en búsqueda de productos:', xhr.status, xhr.responseText);
                },
                cache: true
            },
            language: {
                noResults:    function () { return 'No se encontró el producto'; },
                searching:    function () { return 'Buscando...'; },
                inputTooShort: function () { return 'Escriba al menos 1 caracter para buscar'; }
            }
        }).on('select2:select', function (e) {
            const data = e.params.data;

            // Guardar precios en el elemento para recuperarlos al cambiar lista
            $(this).data('precio1', parseFloat(data.precio1) || 0);
            $(this).data('precio2', parseFloat(data.precio2) || 0);
            $(this).data('precio3', parseFloat(data.precio3) || 0);

            const lista = $('#cod_lista_precio').val();
            let precio = parseFloat(data.precio1) || 0;
            if (lista === 'PPrecio 2') precio = parseFloat(data.precio2) || 0;
            else if (lista === 'Precio 3') precio = parseFloat(data.precio3) || 0;

            $(this).closest('tr').find('.precio').val(precio);
            calcularTotales();
        }).on('select2:clear', function () {
            $(this).data('precio1', 0).data('precio2', 0).data('precio3', 0);
            $(this).closest('tr').find('.precio').val(0);
            calcularTotales();
        });
    }

    $('#agregarDetalle').on('click', function () {
        const fila = crearFila();
        $('#tablaDetalle tbody').append(fila);
        initSelect2(fila);
    });

    // Al cambiar lista de precio, recalcular precios de filas con producto seleccionado
    $('#cod_lista_precio').on('change', function () {
        const lista = $(this).val();
        $('#tablaDetalle tbody tr').each(function () {
            const sel = $(this).find('.select-concepto');
            if (!sel.val()) return;

            let precio = parseFloat(sel.data('precio1')) || 0;
            if (lista === 'PPrecio 2') precio = parseFloat(sel.data('precio2')) || 0;
            else if (lista === 'Precio 3') precio = parseFloat(sel.data('precio3')) || 0;

            $(this).find('.precio').val(precio);
        });
        calcularTotales();
    });

    $(document).on('keyup change', '.cantidad, .precio', calcularTotales);

    $(document).on('click', '.eliminar', function () {
        if ($('#tablaDetalle tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
        calcularTotales();
    });

    function calcularTotales() {
        let subtotal = 0;
        $('#tablaDetalle tbody tr').each(function () {
            const cantidad = parseFloat($(this).find('.cantidad').val()) || 0;
            const precio   = parseFloat($(this).find('.precio').val()) || 0;
            const importe  = cantidad * precio;
            $(this).find('.importe').val(importe.toLocaleString('es-PY'));
            subtotal += importe;
        });
        $('#sub_total_field').val(subtotal);
        $('#total_field').val(subtotal);
        $('#lblSubTotal').text('Gs. ' + subtotal.toLocaleString('es-PY'));
        $('#lblTotal').text('Gs. ' + subtotal.toLocaleString('es-PY'));
    }

    // Select2 para clientes
    $('#id_cliente').select2({
        placeholder: 'Buscar cliente...',
        allowClear: true,
        width: '100%',
        language: {
            noResults:  function () { return 'No se encontró el cliente'; },
            searching:  function () { return 'Buscando...'; }
        }
    });

    // Iniciar con una fila al cargar
    $('#agregarDetalle').trigger('click');

});
</script>
