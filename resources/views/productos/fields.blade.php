<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
.select2-container { width: 100% !important; }
</style>

<!-- Nombre Field -->
<div class="form-group col-sm-3">
    {!! Form::label('codigo', 'Código:') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('num_item', 'Número de Item:') !!}
    {!! Form::text('num_item', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('imagen', 'Imágen:') !!}
    {!! Form::file('imagen', ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('descripcion', 'Descripción:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Rubro Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_rubro', 'Rubro:') !!}
    {!! Form::select(
        'id_rubro',
        $rubros->pluck('descripcion', 'id'),
        null,
        [
            'class'       => 'form-control',
            'id'          => 'id_rubro',
            'placeholder' => 'Seleccione un rubro'
        ]
    ) !!}
</div>
<!-- Cantidad Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cantidad', 'Cantidad:') !!}
    {!! Form::text('cantidad', null, ['class' => 'form-control']) !!}
</div>
<!-- Cantidad Minima Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cantidad_minima', 'Cantidad Minima:') !!}
    {!! Form::text('cantidad_minima', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('cantidad_caja', 'Cantidad en Caja:') !!}
    {!! Form::text('cantidad_caja', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('tipo_iva', 'Tipo IVA:') !!}
    {!! Form::select('tipo_iva', ['IVA_5' => 'IVA 5%', 'IVA_10' => 'IVA 10%', 'EXENTA' => 'Exenta'], null, ['class' => 'form-control']) !!}
</div>
 <div class="form-group col-md-3">
                {!! Form::label('tipo_moneda', 'Moneda') !!}
                {!! Form::select('tipo_moneda', [
                    ''    => 'Seleccione una opción',
                    'PYG' => 'Guaraníes (Gs.)',
                    'USD' => 'Dólares ($)',
                    'BRL' => 'Real (R$)',
                    'ARS' => 'Peso ($)',
                ], null, ['class' => 'form-control', 'id' => 'tipo_moneda', 'required']) !!}
            </div>
<div class="form-group col-sm-3">
    {!! Form::label('costo', 'Costo:') !!}
    {!! Form::text('costo', null, ['class' => 'form-control', 'id' => 'costo']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('precio1', 'Precio 1:') !!}
    {!! Form::text('precio1', null, ['class' => 'form-control', 'id' => 'precio1']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('precio2', 'Precio 2:') !!}
    {!! Form::text('precio2', null, ['class' => 'form-control', 'id' => 'precio2']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('precio3', 'Precio 3:') !!}
    {!! Form::text('precio3', null, ['class' => 'form-control', 'id' => 'precio3']) !!}
</div>

<script>
const porcentajesPorCodigo = @json($lista_precios->keyBy('codigo_lista_precio')->map(fn($l) => $l->porcentaje));

function calcularPrecios() {
    const costo = parseFloat($('#costo').val()) || 0;
    if (costo <= 0) return;

    if (porcentajesPorCodigo[1] !== undefined) {
        const precio1 = Math.round(costo + (costo * parseFloat(porcentajesPorCodigo[1]) / 100));
        $('#precio1').val(precio1);

        if (porcentajesPorCodigo[2] !== undefined) {
            const precio2 = Math.round(precio1 - (precio1 * parseFloat(porcentajesPorCodigo[2]) / 100));
            $('#precio2').val(precio2);
        }

        if (porcentajesPorCodigo[3] !== undefined) {
            const precio3 = Math.round(precio1 - (precio1 * parseFloat(porcentajesPorCodigo[3]) / 100));
            $('#precio3').val(precio3);
        }
    }
}

$(document).ready(function () {
    $('#id_rubro').select2({
        placeholder: 'Seleccione un rubro',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function () { return 'No se encontró el rubro'; }
        }
    });

    $('#costo').on('input', calcularPrecios);
});
</script>
