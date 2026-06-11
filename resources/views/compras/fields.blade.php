<div class="form-group col-sm-6">
                  {!! Form::label('id_proveedor', 'Proveedor:') !!}
                  <select name="id_proveedor" class="form-control" required>
                      <option value="">Seleccione un Proveedor</option>
                      @foreach($proveedores as $proveedor)
                          <option value="{{ $proveedor->id }}">{{ $proveedor->ci }} - {{ $proveedor->nombre }} {{ $proveedor->apellido }}</option>
                      @endforeach
                  </select>
              </div>

<!-- Fecha Compra Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fecha_compra', 'Fecha Compra:') !!}
    {!! Form::text('fecha_compra', null, ['class' => 'form-control']) !!}
</div>

<!-- Tipo Comprobante Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tipo_comprobante', 'Tipo Comprobante:') !!}
    {!! Form::text('tipo_comprobante', null, ['class' => 'form-control']) !!}
</div>

<!-- Numero Comprobante Field -->
<div class="form-group col-sm-3">
    {!! Form::label('numero_comprobante', 'Numero Comprobante:') !!}
    {!! Form::text('numero_comprobante', null, ['class' => 'form-control']) !!}
</div>

<!-- Total Field -->
<div class="form-group col-sm-3">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::text('total', null, ['class' => 'form-control']) !!}
</div>

<!-- Iva Field -->
<div class="form-group col-sm-3">
    {!! Form::label('iva', 'Iva:') !!}
    {!! Form::text('iva', null, ['class' => 'form-control']) !!}
</div>

<!-- Forma Pago Field -->
<div class="form-group col-sm-3">
    {!! Form::label('forma_pago', 'Forma Pago:') !!}
    {!! Form::text('forma_pago', null, ['class' => 'form-control']) !!}
</div>

<!-- Condicion Compra Field -->
<div class="form-group col-sm-3">
    {!! Form::label('condicion_compra', 'Condicion Compra:') !!}
    {!! Form::text('condicion_compra', null, ['class' => 'form-control']) !!}
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observacion', 'Observacion:') !!}
    {!! Form::text('observacion', null, ['class' => 'form-control']) !!}
</div>