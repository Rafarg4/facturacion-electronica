<style>
.select2-container--default .select2-selection--single {
    height: 32px !important;
    border: 1px solid #ced4da;
    border-radius: 4px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 32px;
    padding-left: 8px;
    color: #495057;
    font-size: 13px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 30px;
}
.select2-container {
    width: 100% !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #28a745;
}
#tablaDetalle td { vertical-align: middle; font-size: 13px; }
#tablaDetalle th { font-size: 12px; }
.form-group { margin-bottom: 8px; }
.form-control { font-size: 13px; }
label { font-size: 12px; margin-bottom: 2px; font-weight: 600; color: #555; }
.badge-stock { font-size: 10px; padding: 2px 5px; }
.stock-ok   { background: #d4edda; color: #155724; }
.stock-low  { background: #fff3cd; color: #856404; }
.stock-zero { background: #f8d7da; color: #721c24; }
.select2-stock-info { font-size: 11px; color: #666; float: right; }
.panel-productos { position: sticky; top: 10px; }
</style>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row">

    {{-- ══════════════ Columna izquierda: datos del presupuesto y detalle ══════════════ --}}
    <div class="col-lg-8">

        <div class="card mb-2">
            <div class="card-header py-2">
                <strong><i class="fa fa-info-circle"></i> Datos del Presupuesto</strong>
            </div>
            <div class="card-body py-2 px-3">

                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('id_cliente', 'Cliente') !!}
                        {!! Form::select('id_cliente', $clientes, null, [
                            'class'       => 'form-control',
                            'placeholder' => 'Seleccione un cliente',
                            'required'
                        ]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('tipo_moneda', 'Moneda') !!}
                        {!! Form::select('tipo_moneda', [
                            ''    => 'Seleccione una opción',
                            'PYG' => 'Guaraníes (Gs.)',
                            'USD' => 'Dólares ($)',
                            'BRL' => 'Real (R$)',
                            'ARS' => 'Peso ($)',
                        ], null, ['class' => 'form-control', 'id' => 'tipo_moneda', 'required']) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('cod_lista_precio', 'Lista de precio') !!}
                        {!! Form::select('cod_lista_precio', [
                            'Precio 1'  => 'Precio 1',
                            'PPrecio 2' => 'Precio 2',
                            'Precio 3'  => 'Precio 3',
                        ], null, ['class' => 'form-control', 'id' => 'cod_lista_precio']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('responsable', 'Vendedor') !!}
                        {!! Form::text('responsable',
                            isset($presupuestoCabecera)
                                ? $presupuestoCabecera->responsable
                                : (auth()->user() ? auth()->user()->name : ''),
                            ['class' => 'form-control', 'readonly']
                        ) !!}
                    </div>
                    <div class="form-group col-md-8">
                        {!! Form::label('descripcion', 'Descripción *') !!}
                        {!! Form::textarea('descripcion', null, [
                            'class'       => 'form-control',
                            'rows'        => 1,
                            'placeholder' => 'Observaciones',
                            'required'    => true,
                            'style'       => 'resize:none;',
                        ]) !!}
                    </div>
                </div>

                {!! Form::hidden('tipo_presupuesto', 'VENTA') !!}

            </div>
        </div>

        <div class="card">

            <div class="card-header py-2">
                <strong><i class="fa fa-list"></i> Detalle del Presupuesto</strong>
            </div>

            <div class="card-body py-2 px-3">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm" id="tablaDetalle">
                        <thead class="thead-light">
                            <tr>
                                <th width="6%"  class="text-center">Cant.</th>
                                <th width="36%">Producto / Concepto</th>
                                <th width="8%"  class="text-center">Stock</th>
                                <th width="6%"  class="text-center">Mon.</th>
                                <th width="16%" class="text-right">Precio Unit.</th>
                                <th width="13%" class="text-right">Importe</th>
                                <th width="11%" class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="row mt-2">
                    <div class="col-md-7"></div>
                    <div class="col-md-5">

                        <table class="table table-sm mb-0">
                            <tr>
                                <th style="font-size:13px;">Sub Total</th>
                                <td class="text-right" style="font-size:13px;">
                                    <span id="lblSubTotal">Gs. 0</span>
                                </td>
                            </tr>
                            <tr>
                                <th style="font-size:14px;">Total</th>
                                <td class="text-right" style="font-size:14px;">
                                    <strong id="lblTotal">Gs. 0</strong>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>

                {!! Form::hidden('sub_total', null,  ['id' => 'sub_total_field']) !!}
                {!! Form::hidden('total',     null,  ['id' => 'total_field']) !!}
                {!! Form::hidden('total_gs',  null,  ['id' => 'total_gs_field']) !!}

            </div>
        </div>

    </div>

    {{-- ══════════════ Columna derecha: agregar producto por código ══════════════ --}}
    <div class="col-lg-4">
        <div class="card shadow-sm panel-productos">
            <div class="card-header py-2">
                <strong><i class="fa fa-barcode"></i> Agregar producto</strong>
            </div>
            <div class="card-body p-2">

                <div class="form-group">
                    {!! Form::label('buscarCodigoBarra', 'Código de barras / código de producto') !!}
                    <input type="text" id="buscarCodigoBarra" class="form-control form-control-sm" placeholder="Escanee o ingrese el código" autocomplete="off" autofocus>
                </div>

                <div class="form-group d-flex align-items-center" style="gap:8px;">
                    {!! Form::label('cantidadCodigoBarra', 'Cantidad:', ['class' => 'mb-0']) !!}
                    <input type="number" id="cantidadCodigoBarra" class="form-control form-control-sm" value="1" min="1" style="max-width:90px;">
                </div>

                <small class="text-muted d-block mt-2">
                    Escanee el código con el lector o ingréselo manualmente y presione Enter para agregarlo directo al detalle.
                </small>

            </div>
        </div>

        {{-- Panel cotización --}}
        <div id="panel_cotizacion" style="display:none;">
            <div class="card shadow-sm mt-3">
                <div class="card-header py-2">
                    <strong><i class="fas fa-exchange-alt"></i> Cotización &mdash; <span id="lbl_titulo_moneda"></span></strong>
                </div>
                <div class="card-body py-1 px-3" style="font-size:12px;">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td>Tasa compra</td>
                            <td class="text-right">
                                1 <span id="lbl_tasa_moneda"></span> = <span id="lbl_tasa_venta">-</span> Gs.
                            </td>
                        </tr>
                        <tr>
                            <td>Total <span id="lbl_moneda_orig"></span></td>
                            <td class="text-right" id="lbl_total_orig">0</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
$(document).ready(function () {

    const urlBuscar     = '{{ route("productos.buscar") }}';
    const urlCotizacion = '{{ url("/cotizacion-por-moneda") }}';
    const simbolos      = { PYG: 'Gs.', USD: '$', BRL: 'R$', ARS: '$' };

    let tasaVenta    = 1;
    let monedaActual = '';
    const tasasCache = {};

    function parseNumber(value) {
        if (value === null || value === undefined) {
            return NaN;
        }
        const normalized = String(value).trim().replace(/\./g, '').replace(',', '.');
        return parseFloat(normalized);
    }

    // Obtiene la tasa de compra de una moneda (con caché)
    function getTasa(moneda, callback) {
        moneda = String(moneda || '').trim().toUpperCase();
        if (!moneda) { callback(1); return; }
        if (tasasCache[moneda]) { callback(tasasCache[moneda]); return; }
        $.getJSON(urlCotizacion + '/' + moneda, function (data) {
            const tasa = parseNumber(data.compra);
            if (!isFinite(tasa) || tasa <= 0) {
                alert('⚠️ La cotización de ' + moneda + ' no tiene un valor válido en el campo "compra". Verifíquela en el sistema.');
                callback(1);
                return;
            }
            tasasCache[moneda] = tasa;
            callback(tasa);
        }).fail(function (xhr) {
            if (xhr.status === 404) {
                alert('⚠️ No se encontró cotización para ' + moneda + '.\nDebe cargar la cotización de ' + moneda + ' antes de usar esta moneda.');
            }
            callback(1);
        });
    }

    // Convierte un precio a la moneda seleccionada en el encabezado
    function convertirPrecio(precio, callback) {
        const destino = String(monedaActual || '').toUpperCase();

        if (!destino) {
            callback(precio);
            return;
        }

        getTasa(destino, function (tasaDestino) {
            const convertido = precio * tasaDestino;
            callback(convertido);
        });
    }

    // Reconvierte todas las filas con producto ya seleccionado
    function reconvertirTodasLasFilas() {
        const lista = $('#cod_lista_precio').val();
        const filas = [];

        $('#tablaDetalle tbody tr').each(function () {
            const sel = $(this).find('.select-concepto');
            if (!sel.val()) return;

            let precioBase = parseFloat(sel.data('precio1')) || 0;
            if (lista === 'PPrecio 2') precioBase = parseFloat(sel.data('precio2')) || 0;
            else if (lista === 'Precio 3') precioBase = parseFloat(sel.data('precio3')) || 0;

            filas.push({ tr: $(this), precioBase, monedaProd: sel.data('tipo_moneda') || '' });
        });

        if (!filas.length) { calcularTotales(); return; }

        let pendientes = filas.length;
        filas.forEach(function (f) {
            // Actualiza el badge de moneda del producto
            f.tr.find('.moneda-badge').text(f.monedaProd)
               .removeClass('badge-secondary badge-warning badge-info badge-success')
               .addClass(f.monedaProd === 'PYG' ? 'badge-success' : 'badge-warning');

            convertirPrecio(f.precioBase, function (precioFinal) {
                f.tr.find('.precio').val(Math.round(precioFinal * 100) / 100);
                if (--pendientes === 0) calcularTotales();
            });
        });
    }

    // ─── Fila de detalle ─────────────────────────────────────────────────────
    function crearFila() {
        return $('<tr>' +
            '<td>' +
                '<input type="number" name="cantidad[]" class="form-control form-control-sm cantidad text-center" value="1" min="1">' +
            '</td>' +
            '<td>' +
                '<select name="concepto[]" class="form-control form-control-sm select-concepto" required>' +
                    '<option value=""></option>' +
                '</select>' +
            '</td>' +
            '<td class="text-center">' +
                '<span class="badge badge-stock stock-badge">--</span>' +
            '</td>' +
            '<td class="text-center">' +
                '<span class="badge badge-secondary moneda-badge">-</span>' +
            '</td>' +
            '<td>' +
                '<input type="number" name="precio_unitario[]" class="form-control form-control-sm precio text-right" value="0" min="0" step="0.01">' +
            '</td>' +
            '<td>' +
                '<input type="text" class="form-control form-control-sm importe text-right" readonly value="0">' +
            '</td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-danger btn-sm eliminar">' +
                    '<i class="fa fa-trash"></i>' +
                '</button>' +
            '</td>' +
        '</tr>');
    }

    function badgeStock(stock) {
        const n = parseFloat(stock) || 0;
        if (n <= 0)  return '<span class="badge badge-stock stock-zero">Sin stock</span>';
        if (n <= 5)  return '<span class="badge badge-stock stock-low">' + n + ' en stock</span>';
        return '<span class="badge badge-stock stock-ok">' + n + ' en stock</span>';
    }

    // ─── Aplica los datos de un producto (select2 o escaneo) a una fila ────────
    function aplicarProductoAFila(tr, data) {
        const monedaProd = String(data.tipo_moneda || 'PYG').toUpperCase();
        const sel = tr.find('.select-concepto');

        sel.data('precio1',     parseNumber(data.precio1) || 0);
        sel.data('precio2',     parseNumber(data.precio2) || 0);
        sel.data('precio3',     parseNumber(data.precio3) || 0);
        sel.data('stock',       parseNumber(data.stock) || 0);
        sel.data('tipo_moneda', monedaProd);

        const lista = $('#cod_lista_precio').val();
        let precioBase = parseNumber(data.precio1) || 0;
        if (lista === 'PPrecio 2') precioBase = parseNumber(data.precio2) || 0;
        else if (lista === 'Precio 3') precioBase = parseNumber(data.precio3) || 0;

        tr.find('.stock-badge').replaceWith(badgeStock(data.stock));
        tr.find('.moneda-badge').text(monedaProd).removeClass('badge-secondary badge-warning badge-info badge-success')
          .addClass(monedaProd === 'PYG' ? 'badge-success' : 'badge-warning');

        convertirPrecio(precioBase, function (precioFinal) {
            tr.find('.precio').val(Math.round(precioFinal * 100) / 100);
            calcularTotales();
        });
    }

    // ─── Select2 de producto ─────────────────────────────────────────────────
    function initSelect2(fila) {
        fila.find('.select-concepto').select2({
            placeholder: 'Buscar por nombre o código...',
            allowClear: true,
            width: '100%',
            minimumInputLength: 1,
            dropdownParent: $('body'),
            ajax: {
                url: urlBuscar,
                dataType: 'json',
                delay: 300,
                data: function (params) { return { q: params.term }; },
                processResults: function (data) { return { results: data.results }; },
                error: function (xhr) { console.error('Búsqueda:', xhr.status, xhr.responseText); },
                cache: true
            },
            templateResult: function (item) {
                if (item.loading) return item.text;
                const stock = parseFloat(item.stock) || 0;
                const color = stock <= 0 ? '#dc3545' : (stock <= 5 ? '#856404' : '#155724');
                return $('<span>' + item.text +
                    ' <small style="color:' + color + ';float:right;">Stock: ' + stock + '</small>' +
                '</span>');
            },
            language: {
                noResults:     function () { return 'No se encontró el producto'; },
                searching:     function () { return 'Buscando...'; },
                inputTooShort: function () { return 'Escriba al menos 1 caracter'; }
            }
        }).on('select2:select', function (e) {
            aplicarProductoAFila($(this).closest('tr'), e.params.data);
        }).on('select2:clear', function () {
            $(this).data('precio1', 0).data('precio2', 0).data('precio3', 0)
                   .data('stock', 0).data('tipo_moneda', 'PYG');
            const tr = $(this).closest('tr');
            tr.find('.precio').val(0);
            tr.find('.stock-badge').replaceWith('<span class="badge badge-stock stock-badge">--</span>');
            tr.find('.moneda-badge').text('-').removeClass('badge-warning badge-info badge-success').addClass('badge-secondary');
            calcularTotales();
        });
    }

    // ─── Eliminar fila ──────────────────────────────────────────────────────
    $(document).on('click', '.eliminar', function () {
        $(this).closest('tr').remove();
        calcularTotales();
    });

    // ─── Buscar por código de barras (escáner o manual) y agregar directo ─────
    function buscarProductoPorCodigoYAgregar() {
        const inputCodigo = $('#buscarCodigoBarra');
        const codigo = inputCodigo.val().trim();
        if (!codigo) return;

        const cantidadInput = $('#cantidadCodigoBarra');
        let cantidad = parseInt(cantidadInput.val()) || 1;
        if (cantidad < 1) cantidad = 1;

        $.getJSON(urlBuscar, { q: codigo }, function (data) {
            const productos = data.results || [];
            const producto  = productos.find(function (p) { return String(p.codigo || '').trim() === codigo; });

            if (!producto) {
                alert('Producto no encontrado para el código: ' + codigo);
                return;
            }

            let filaExistente = null;
            $('#tablaDetalle tbody tr').each(function () {
                if ($(this).find('.select-concepto').val() === producto.id) {
                    filaExistente = $(this);
                    return false;
                }
            });

            if (filaExistente) {
                const cantInput = filaExistente.find('.cantidad');
                cantInput.val((parseInt(cantInput.val()) || 0) + cantidad);
            } else {
                const fila = crearFila();
                $('#tablaDetalle tbody').append(fila);
                initSelect2(fila);

                const sel    = fila.find('.select-concepto');
                const texto  = (producto.codigo ? '[' + producto.codigo + '] ' : '') + producto.id;
                const option = new Option(texto, producto.id, true, true);
                sel.append(option).trigger('change');

                aplicarProductoAFila(fila, producto);
                fila.find('.cantidad').val(cantidad);
            }

            calcularTotales();
        }).fail(function () {
            alert('Error al buscar el producto');
        }).always(function () {
            inputCodigo.val('');
            cantidadInput.val(1);
            inputCodigo.focus();
        });
    }

    $('#buscarCodigoBarra').on('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarProductoPorCodigoYAgregar();
        }
    });

    // ─── Lista de precio ──────────────────────────────────────────────────────
    $('#cod_lista_precio').on('change', function () {
        const lista  = $(this).val();
        const filas  = [];

        $('#tablaDetalle tbody tr').each(function () {
            const sel = $(this).find('.select-concepto');
            if (!sel.val()) return;

            let precioBase = parseFloat(sel.data('precio1')) || 0;
            if (lista === 'PPrecio 2') precioBase = parseFloat(sel.data('precio2')) || 0;
            else if (lista === 'Precio 3') precioBase = parseFloat(sel.data('precio3')) || 0;

            filas.push({ tr: $(this), precioBase, monedaProd: sel.data('tipo_moneda') || '' });
        });

        if (!filas.length) return;

        let pendientes = filas.length;
        filas.forEach(function (f) {
            convertirPrecio(f.precioBase, f.monedaProd, function (precioFinal) {
                f.tr.find('.precio').val(Math.round(precioFinal * 100) / 100);
                if (--pendientes === 0) calcularTotales();
            });
        });
    });

    $(document).on('keyup change', '.cantidad, .precio', calcularTotales);

    // ─── Cálculo de totales ───────────────────────────────────────────────────
    function calcularTotales() {
        let subtotal = 0;
        const simbolo = simbolos[monedaActual] || monedaActual || '';

        $('#tablaDetalle tbody tr').each(function () {
            const cantidad = parseFloat($(this).find('.cantidad').val()) || 0;
            const precio   = parseFloat($(this).find('.precio').val())   || 0;
            const importe  = cantidad * precio;
            $(this).find('.importe').val(importe.toLocaleString('es-PY'));
            subtotal += importe;
        });

        $('#total_field').val(subtotal);
        $('#lblSubTotal').text(simbolo + ' ' + subtotal.toLocaleString('es-PY'));
        $('#lblTotal').text(simbolo + ' ' + subtotal.toLocaleString('es-PY'));

        actualizarConversion(subtotal);
    }

    function actualizarConversion(subtotal) {
        const simbolo = simbolos[monedaActual] || monedaActual || '';

        if (!monedaActual) {
            $('#sub_total_field').val(subtotal);
            $('#total_field').val(subtotal);
            $('#total_gs_field').val(subtotal);
            $('#panel_cotizacion').hide();
            return;
        }

        const totalPYG = Math.round(subtotal * tasaVenta);
        const totalSeleccionado = subtotal;

        $('#sub_total_field').val(totalSeleccionado);
        $('#total_field').val(totalSeleccionado);
        $('#total_gs_field').val(totalPYG);

        if (monedaActual === 'PYG') {
            $('#lbl_total_orig').text('Gs. ' + totalSeleccionado.toLocaleString('es-PY'));
            $('#lbl_total_pyg').text('Gs. ' + totalPYG.toLocaleString('es-PY'));
            $('#panel_cotizacion').show();
            return;
        }

        // Moneda extranjera: mostrar panel con equivalente en Gs.
        $('#lbl_total_orig').text(simbolo + ' ' + totalSeleccionado.toLocaleString('es-PY'));
        $('#lbl_total_pyg').text('Gs. ' + totalPYG.toLocaleString('es-PY'));
        $('#panel_cotizacion').show();
    }

    // ─── Cotización ──────────────────────────────────────────────────────────
    function fetchCotizacion(moneda) {
        moneda = String(moneda || '').trim().toUpperCase();
        // Sin selección: limpiar estado
        if (!moneda) {
            monedaActual = '';
            tasaVenta    = 1;
            $('#panel_cotizacion').hide();
            reconvertirTodasLasFilas();
            return;
        }

        monedaActual = moneda;
        $.getJSON(urlCotizacion + '/' + moneda, function (data) {
            tasaVenta = parseNumber(data.compra);
            if (!isFinite(tasaVenta) || tasaVenta <= 0) {
                tasaVenta = 1;
                alert('⚠️ La cotización de ' + moneda + ' no es válida. Verifíquela en el sistema.');
            }
            tasasCache[moneda] = tasaVenta;
            $('#lbl_titulo_moneda').text(moneda);
            $('#lbl_tasa_moneda').text(moneda);
            $('#lbl_moneda_orig').text('(' + moneda + ')');
            $('#lbl_tasa_venta').text(tasaVenta.toLocaleString('es-PY'));
            reconvertirTodasLasFilas();
        }).fail(function () {
            tasaVenta    = 1;
            monedaActual = '';
            $('#panel_cotizacion').hide();
            alert('No se encontró cotización para ' + moneda + '. Verifique que esté cargada.');
        });
    }

    $('#tipo_moneda').on('change', function () {
        fetchCotizacion($(this).val());
    });

    // Inicializa conversión si el formulario carga con moneda ya seleccionada
    if ($('#tipo_moneda').val()) {
        fetchCotizacion($('#tipo_moneda').val());
    }

    // ─── Select2 clientes ────────────────────────────────────────────────────
    $('#id_cliente').select2({
        placeholder: 'Buscar cliente...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function () { return 'No se encontró el cliente'; },
            searching: function () { return 'Buscando...'; }
        }
    });

});
</script>
