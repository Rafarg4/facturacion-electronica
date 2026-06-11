<!-- Nombre Field -->

<div class="form-group col-sm-3">
    {!! Form::label('codigo', 'Codigo:') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('num_item', 'Numero de Item:') !!}
    {!! Form::text('num_item', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('imagen', 'Imagen:') !!}
    {!! Form::file('imagen', ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Rubro Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_rubro', 'Rubro:') !!}
    <select name="id_rubro" class="form-control">
        <option value="">Seleccione un rubro</option>
        @foreach($rubros as $rubro)
            <option value="{{ $rubro->id }}">{{ $rubro->descripcion }}</option>
        @endforeach
    </select>
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
    {!! Form::label('precio1', 'Precio 1:') !!}
    {!! Form::text('precio1', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('precio2', 'Precio 2:') !!}
    {!! Form::text('precio2', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('precio3', 'Precio 3:') !!}
    {!! Form::text('precio3', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('costo', 'Costo:') !!}
    {!! Form::text('costo', null, ['class' => 'form-control']) !!}
</div>




