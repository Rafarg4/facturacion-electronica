<!-- Empresa -->
<div class="form-group col-sm-6">
    {!! Form::label('empresa', 'Empresa:') !!}
    {!! Form::text('empresa', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nombre de la empresa']) !!}
</div>

<!-- Descripcion -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripción:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ej: Cuota mensual software, Licencia anual...']) !!}
</div>

<!-- Fecha Inicio -->
<div class="form-group col-sm-4">
    {!! Form::label('fecha_inicio', 'Fecha de Inicio:') !!}
    {!! Form::date('fecha_inicio', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Periodicidad -->
<div class="form-group col-sm-4">
    {!! Form::label('periodicidad', 'Periodicidad:') !!}
    {!! Form::select('periodicidad', [
        'mensual'   => 'Mensual',
        'quincenal' => 'Quincenal',
        'semanal'   => 'Semanal',
    ], null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Estado -->
<div class="form-group col-sm-4">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado', [
        'Vigente'    => 'Vigente',
        'Finalizado' => 'Finalizado',
        'Cancelado'  => 'Cancelado',
    ], 'Vigente', ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Cantidad Cuotas -->
<div class="form-group col-sm-6">
    {!! Form::label('cantidad_cuotas', 'Cantidad de Cuotas:') !!}
    {!! Form::number('cantidad_cuotas', null, ['class' => 'form-control', 'min' => 1, 'max' => 360, 'required' => true, 'placeholder' => 'Ej: 12']) !!}
</div>

<!-- Monto Cuota -->
<div class="form-group col-sm-6">
    {!! Form::label('monto_cuota', 'Monto por Cuota:') !!}
    {!! Form::number('monto_cuota', null, ['class' => 'form-control', 'min' => '0.01', 'step' => '0.01', 'required' => true, 'placeholder' => 'Ej: 50000']) !!}
</div>

<!-- Preview monto total -->
<div class="col-sm-12" id="div-monto-total" style="display:none;">
    <div class="alert alert-info py-2 mb-3">
        Monto total del plan: <strong id="preview-total-plan">0</strong>
    </div>
</div>

<!-- Observacion -->
<div class="form-group col-sm-12">
    {!! Form::label('observacion', 'Observación:') !!}
    {!! Form::text('observacion', null, ['class' => 'form-control', 'placeholder' => 'Opcional']) !!}
</div>

@push('page_scripts')
<script>
    function actualizarTotalPlan() {
        var cant  = parseFloat($('[name=cantidad_cuotas]').val());
        var monto = parseFloat($('[name=monto_cuota]').val());
        if (cant > 0 && monto > 0) {
            $('#preview-total-plan').text(new Intl.NumberFormat('es-PY').format(cant * monto));
            $('#div-monto-total').show();
        } else {
            $('#div-monto-total').hide();
        }
    }
    $('[name=cantidad_cuotas], [name=monto_cuota]').on('input', actualizarTotalPlan);
    actualizarTotalPlan();
</script>
@endpush
