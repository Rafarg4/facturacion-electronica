<!-- Nombre Field -->
<div class="form-group col-sm-3">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Categoria Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_categoria', 'Categoría:') !!}
    <select name="id_categoria" class="form-control">
        <option value="">Seleccione una categoría</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
        @endforeach
    </select>
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

<!-- Precio Venta Field -->
<div class="form-group col-sm-3">
    {!! Form::label('precio_venta', 'Precio Venta:') !!}
    {!! Form::text('precio_venta', null, ['class' => 'form-control']) !!}
</div>

<!-- Precio Compra Field -->
<div class="form-group col-sm-3">
    {!! Form::label('precio_compra', 'Precio Compra:') !!}
    {!! Form::text('precio_compra', null, ['class' => 'form-control']) !!}
</div>
