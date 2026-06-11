<!-- Ruc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ruc', 'Ruc:') !!}
    {!! Form::text('ruc', null, ['class' => 'form-control']) !!}
</div>

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

<div class="form-group col-sm-3">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('telefono', 'Telefono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('correo', 'Correo:') !!}
    {!! Form::text('correo', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('timbrado', 'Timbrado:') !!}
    {!! Form::text('timbrado', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('logo', 'Logo:') !!}
    @if(!empty($empresa->logo))
        <div class="mb-2">
            <img src="{{ asset('imagenes/'.$empresa->logo) }}"
                width="150"
                class="img-thumbnail">
        </div>
    @endif
    {!! Form::file('logo', ['class' => 'form-control']) !!}
</div>
