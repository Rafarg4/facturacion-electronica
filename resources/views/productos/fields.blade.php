<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
.select2-container--default .select2-selection--single {
    height: 38px !important;
    border: 1px solid #ced4da;
    border-radius: 4px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 38px;
    padding-left: 8px;
    color: #495057;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
.select2-container { width: 100% !important; }
</style>

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

<!-- Descripcion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Rubro Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_rubro', 'Rubro:') !!}
    {!! Form::select(
        'id_rubro',
        $rubros->pluck('descripcion', 'id'),
        null,
        [
            'class'       => 'form-control',
            'id'          => 'id_rubro',
            'placeholder' => 'Seleccione un rubro'
        ]
    ) !!}
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

<script>
$(document).ready(function () {
    $('#id_rubro').select2({
        placeholder: 'Seleccione un rubro',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function () { return 'No se encontró el rubro'; }
        }
    });
});
</script>
