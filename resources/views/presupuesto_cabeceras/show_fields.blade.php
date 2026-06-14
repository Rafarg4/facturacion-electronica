<!-- Cliente Field -->
<div class="col-sm-12">
    {!! Form::label('cliente', 'Cliente:') !!}
    <p>{{ $presupuestoCabecera->cliente }}</p>
</div>

<!-- Estado Field -->
<div class="col-sm-12">
    {!! Form::label('estado', 'Estado:') !!}
    <p>{{ $presupuestoCabecera->estado }}</p>
</div>

<!-- Responsable Field -->
<div class="col-sm-12">
    {!! Form::label('responsable', 'Responsable:') !!}
    <p>{{ $presupuestoCabecera->responsable }}</p>
</div>

<!-- Descripcion Field -->
<div class="col-sm-12">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    <p>{{ $presupuestoCabecera->descripcion }}</p>
</div>

<!-- Sub Total Field -->
<div class="col-sm-12">
    {!! Form::label('sub_total', 'Sub Total:') !!}
    <p>{{ $presupuestoCabecera->sub_total }}</p>
</div>

<!-- Total Field -->
<div class="col-sm-12">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $presupuestoCabecera->total }}</p>
</div>

<!-- Tipo Presupuesto Field -->
<div class="col-sm-12">
    {!! Form::label('tipo_presupuesto', 'Tipo Presupuesto:') !!}
    <p>{{ $presupuestoCabecera->tipo_presupuesto }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $presupuestoCabecera->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $presupuestoCabecera->updated_at }}</p>
</div>

