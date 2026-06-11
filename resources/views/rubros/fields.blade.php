<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select(
        'estado',
        [
             ''  => 'Seleccione una opcion',
            'S' => 'Activo',
            'N' => 'Inactivo'
        ],
        null,
        [
            'class' => 'form-control'
        ]
    ) !!}
</div>