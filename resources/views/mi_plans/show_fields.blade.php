<!-- Empresa Field -->
<div class="col-sm-12">
    {!! Form::label('empresa', 'Empresa:') !!}
    <p>{{ $miPlan->empresa }}</p>
</div>

<!-- Nro Cuota Field -->
<div class="col-sm-12">
    {!! Form::label('nro_cuota', 'Nro Cuota:') !!}
    <p>{{ $miPlan->nro_cuota }}</p>
</div>

<!-- Fecha Vencimiento Field -->
<div class="col-sm-12">
    {!! Form::label('fecha_vencimiento', 'Fecha Vencimiento:') !!}
    <p>{{ $miPlan->fecha_vencimiento }}</p>
</div>

<!-- Fecha Pago Field -->
<div class="col-sm-12">
    {!! Form::label('fecha_pago', 'Fecha Pago:') !!}
    <p>{{ $miPlan->fecha_pago }}</p>
</div>

<!-- Monto Cuota Field -->
<div class="col-sm-12">
    {!! Form::label('monto_cuota', 'Monto Cuota:') !!}
    <p>{{ $miPlan->monto_cuota }}</p>
</div>

<!-- Saldo Cuota Field -->
<div class="col-sm-12">
    {!! Form::label('saldo_cuota', 'Saldo Cuota:') !!}
    <p>{{ $miPlan->saldo_cuota }}</p>
</div>

<!-- Estado Field -->
<div class="col-sm-12">
    {!! Form::label('estado', 'Estado:') !!}
    <p>{{ $miPlan->estado }}</p>
</div>

<!-- Observacion Field -->
<div class="col-sm-12">
    {!! Form::label('observacion', 'Observacion:') !!}
    <p>{{ $miPlan->observacion }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $miPlan->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $miPlan->updated_at }}</p>
</div>

