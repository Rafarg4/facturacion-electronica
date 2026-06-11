<!-- Id Cliente Field -->
 <div class="form-group col-sm-3">
                  {!! Form::label('id_cliente', 'Clientes:') !!}
                  <select name="id_cliente" class="form-control" required>
                      <option value="">Seleccione un cliente</option>
                      @foreach($clientes as $cliente)
                          <option value="{{ $cliente->id }}">{{ $cliente->ci }} - {{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                      @endforeach
                  </select>
              </div>
<!-- Id Venta Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_venta', 'Venta:') !!}
    {!! Form::text('id_venta', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Cobro Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fecha_cobro', 'Fecha Cobro:') !!}
    {!! Form::text('fecha_cobro', null, ['class' => 'form-control']) !!}
</div>

<!-- Cajero Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cajero', 'Cajero:') !!}
    {!! Form::text('cajero', null, ['class' => 'form-control']) !!}
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('observacion', 'Observacion:') !!}
    {!! Form::text('observacion', null, ['class' => 'form-control']) !!}
</div>