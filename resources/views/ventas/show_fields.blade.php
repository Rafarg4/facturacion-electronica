<!-- Id Cliente Field -->
<div class="col-sm-12">
    {!! Form::label('id_cliente', 'Id Cliente:') !!}
    <p>{{ $venta->id_cliente }}</p>
</div>

<!-- Fecha Venta Field -->
<div class="col-sm-12">
    {!! Form::label('fecha_venta', 'Fecha Venta:') !!}
    <p>{{ $venta->fecha_venta }}</p>
</div>

<!-- Id Usuario Field -->
<div class="col-sm-12">
    {!! Form::label('id_usuario', 'Id Usuario:') !!}
    <p>{{ $venta->id_usuario }}</p>
</div>

<!-- Tipo Comprobante Field -->
<div class="col-sm-12">
    {!! Form::label('tipo_comprobante', 'Tipo Comprobante:') !!}
    <p>{{ $venta->tipo_comprobante }}</p>
</div>

<!-- Numero Comprobante Field -->
<div class="col-sm-12">
    {!! Form::label('numero_comprobante', 'Numero Comprobante:') !!}
    <p>{{ $venta->numero_comprobante }}</p>
</div>

<!-- Total Field -->
<div class="col-sm-12">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $venta->total }}</p>
</div>

<!-- Iva Field -->
<div class="col-sm-12">
    {!! Form::label('iva', 'Iva:') !!}
    <p>{{ $venta->iva }}</p>
</div>

<!-- Forma Pago Field -->
<div class="col-sm-12">
    {!! Form::label('forma_pago', 'Forma Pago:') !!}
    <p>{{ $venta->forma_pago }}</p>
</div>

<!-- Estado Field -->
<div class="col-sm-12">
    {!! Form::label('estado', 'Estado:') !!}
    <p>{{ $venta->estado }}</p>
</div>

<!-- Observacion Field -->
<div class="col-sm-12">
    {!! Form::label('observacion', 'Observacion:') !!}
    <p>{{ $venta->observacion }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $venta->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $venta->updated_at }}</p>
</div>

