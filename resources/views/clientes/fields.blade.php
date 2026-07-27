<!-- Nombre Field -->
<div class="form-group col-sm-3">
    {!! Form::label('nombre', 'Nombres:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Apellido Field -->
<div class="form-group col-sm-3">
    {!! Form::label('apellido', 'Apellidos:') !!}
    {!! Form::text('apellido', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Tipo Documento Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tipo_documento', 'Tipo de Documento:') !!}
    {!! Form::select('tipo_documento', ['RUC' => 'RUC', 'CI' => 'Cédula', 'Extranjero' => 'Extranjero'], 'CI', ['class' => 'form-control', 'required']) !!}
</div>

<!-- Ci Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ci', 'N° de Documento:') !!}
    {!! Form::text('ci', null, ['class' => 'form-control', 'required']) !!}
    <small class="text-muted">RUC: con dígito verificador (ej. 80012345-6). Cédula o extranjero: solo el número.</small>
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('telefono', 'Teléfono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Correo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('correo', 'Correo:') !!}
    {!! Form::text('correo', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('direccion', 'Dirección:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control', 'required']) !!}
</div>