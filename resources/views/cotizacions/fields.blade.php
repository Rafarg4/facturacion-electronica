<!-- Tipo Moneda Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tipo_moneda', 'Tipo Moneda:') !!}
    {!! Form::select(
        'tipo_moneda',
        [
            'GS' => 'Guaraníes',
            'USD' => 'Dólares',
            'ARS' => 'Pesos',
            'BRL' => 'Reales'
        ],
        null,
        [
            'class' => 'form-control',
            'placeholder' => 'Seleccione una moneda'
        ]
    ) !!}
</div>
<!-- Compra Field -->
<div class="form-group col-sm-6">
    {!! Form::label('compra', 'Compra:') !!}
    {!! Form::text('compra', null, ['class' => 'form-control']) !!}
</div>

<!-- Venta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('venta', 'Venta:') !!}
    {!! Form::text('venta', null, ['class' => 'form-control']) !!}
</div>