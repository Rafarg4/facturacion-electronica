<!-- Nombre Field -->
<div class="form-group col-sm-3">
    {!! Form::label('nombre', 'Nombres:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Apellido Field -->
<div class="form-group col-sm-3">
    {!! Form::label('apellido', 'Apellidos:') !!}
    {!! Form::text('apellido', null, ['class' => 'form-control']) !!}
</div>

<!-- Ci Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ci', 'Documento:') !!}
    {!! Form::text('ci', null, ['class' => 'form-control']) !!}
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('telefono', 'Teléfono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
</div>

<!-- Correo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('correo', 'Correo:') !!}
    {!! Form::text('correo', null, ['class' => 'form-control']) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('direccion', 'Dirección:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('residente', 'Residente:') !!}
    <div>
        {!! Form::checkbox('residente', 'S', true, ['id' => 'residente']) !!}
        <label for="residente">Sí</label>
    </div>

    <small class="text-muted">
        Desmarque esta opción cuando el cliente sea extranjero y no posea residencia en el país.
    </small>
</div>