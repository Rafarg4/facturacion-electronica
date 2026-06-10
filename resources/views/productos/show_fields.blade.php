<!-- Nombre Field -->
<div class="col-sm-12">
    {!! Form::label('nombre', 'Nombre:') !!}
    <p>{{ $producto->nombre }}</p>
</div>

<!-- Descripcion Field -->
<div class="col-sm-12">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    <p>{{ $producto->descripcion }}</p>
</div>

<!-- Id Categoria Field -->
<div class="col-sm-12">
    {!! Form::label('id_categoria', 'Id Categoria:') !!}
    <p>{{ $producto->id_categoria }}</p>
</div>

<!-- Cantidad Field -->
<div class="col-sm-12">
    {!! Form::label('cantidad', 'Cantidad:') !!}
    <p>{{ $producto->cantidad }}</p>
</div>

<!-- Cantidad Minima Field -->
<div class="col-sm-12">
    {!! Form::label('cantidad_minima', 'Cantidad Minima:') !!}
    <p>{{ $producto->cantidad_minima }}</p>
</div>

<!-- Precio Venta Field -->
<div class="col-sm-12">
    {!! Form::label('precio_venta', 'Precio Venta:') !!}
    <p>{{ $producto->precio_venta }}</p>
</div>

<!-- Precio Compra Field -->
<div class="col-sm-12">
    {!! Form::label('precio_compra', 'Precio Compra:') !!}
    <p>{{ $producto->precio_compra }}</p>
</div>

<!-- Estado Field -->
<div class="col-sm-12">
    {!! Form::label('estado', 'Estado:') !!}
    <p>{{ $producto->estado }}</p>
</div>

<!-- Id Proveedor Field -->
<div class="col-sm-12">
    {!! Form::label('id_proveedor', 'Id Proveedor:') !!}
    <p>{{ $producto->id_proveedor }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $producto->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $producto->updated_at }}</p>
</div>

