<!-- Tipo Moneda Field -->
<div class="col-sm-12">
    {!! Form::label('tipo_moneda', 'Tipo Moneda:') !!}
    <p>{{ $cotizacion->tipo_moneda }}</p>
</div>

<!-- Compra Field -->
<div class="col-sm-12">
    {!! Form::label('compra', 'Compra:') !!}
    <p>{{ $cotizacion->compra }}</p>
</div>

<!-- Venta Field -->
<div class="col-sm-12">
    {!! Form::label('venta', 'Venta:') !!}
    <p>{{ $cotizacion->venta }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cotizacion->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cotizacion->updated_at }}</p>
</div>

