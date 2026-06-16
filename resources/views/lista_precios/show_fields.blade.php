<!-- Descripcion Field -->
<div class="col-sm-12">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    <p>{{ $listaPrecio->descripcion }}</p>
</div>

<!-- Porcentaje Field -->
<div class="col-sm-12">
    {!! Form::label('porcentaje', 'Porcentaje:') !!}
    <p>{{ $listaPrecio->porcentaje }}</p>
</div>

<!-- Estado Field -->
<div class="col-sm-12">
    {!! Form::label('estado', 'Estado:') !!}
    <p>{{ $listaPrecio->estado }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $listaPrecio->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $listaPrecio->updated_at }}</p>
</div>

