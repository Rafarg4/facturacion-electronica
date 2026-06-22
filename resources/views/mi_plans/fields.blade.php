<!-- Empresa Field -->
<div class="form-group col-sm-6">
    {!! Form::label('empresa', 'Empresa:') !!}
    {!! Form::text('empresa', null, ['class' => 'form-control']) !!}
</div>

<!-- Nro Cuota Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nro_cuota', 'Nro Cuota:') !!}
    {!! Form::text('nro_cuota', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Vencimiento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_vencimiento', 'Fecha Vencimiento:') !!}
    {!! Form::text('fecha_vencimiento', null, ['class' => 'form-control','id'=>'fecha_vencimiento']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#fecha_vencimiento').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Fecha Pago Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_pago', 'Fecha Pago:') !!}
    {!! Form::text('fecha_pago', null, ['class' => 'form-control','id'=>'fecha_pago']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#fecha_pago').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Monto Cuota Field -->
<div class="form-group col-sm-6">
    {!! Form::label('monto_cuota', 'Monto Cuota:') !!}
    {!! Form::text('monto_cuota', null, ['class' => 'form-control']) !!}
</div>

<!-- Saldo Cuota Field -->
<div class="form-group col-sm-6">
    {!! Form::label('saldo_cuota', 'Saldo Cuota:') !!}
    {!! Form::text('saldo_cuota', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::text('estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observacion', 'Observacion:') !!}
    {!! Form::text('observacion', null, ['class' => 'form-control']) !!}
</div>