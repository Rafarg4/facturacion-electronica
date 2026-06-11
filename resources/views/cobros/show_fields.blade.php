<!-- Id Cliente Field -->
<div class="col-sm-12">
    {!! Form::label('id_cliente', 'Id Cliente:') !!}
    <p>{{ $cobro->id_cliente }}</p>
</div>

<!-- Id Venta Field -->
<div class="col-sm-12">
    {!! Form::label('id_venta', 'Id Venta:') !!}
    <p>{{ $cobro->id_venta }}</p>
</div>

<!-- Fecha Cobro Field -->
<div class="col-sm-12">
    {!! Form::label('fecha_cobro', 'Fecha Cobro:') !!}
    <p>{{ $cobro->fecha_cobro }}</p>
</div>

<!-- Cajero Field -->
<div class="col-sm-12">
    {!! Form::label('cajero', 'Cajero:') !!}
    <p>{{ $cobro->cajero }}</p>
</div>

<!-- Observacion Field -->
<div class="col-sm-12">
    {!! Form::label('observacion', 'Observacion:') !!}
    <p>{{ $cobro->observacion }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cobro->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cobro->updated_at }}</p>
</div>

