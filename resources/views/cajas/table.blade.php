 <style>
/* Solo el estilo necesario para el switch */
.form-check-input[type=checkbox] {
  width: 2.5em;
  height: 1.5em;
  background-color: #dee2e6;
  border-radius: 3em;
  position: relative;
  appearance: none;
  transition: background-color .15s ease-in-out;
}

.form-check-input[type=checkbox]::before {
  content: "";
  position: absolute;
  width: 1em;
  height: 1em;
  background-color: white;
  border-radius: 50%;
  top: 0.25em;
  left: 0.25em;
  transition: transform 0.15s ease-in-out;
}

.form-check-input[type=checkbox]:checked {
  background-color: #0d6efd;
}

.form-check-input[type=checkbox]:checked::before {
  transform: translateX(1em);
}
</style>
  <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Nombre</th>
        <th>Descripcion</th>
        <th>Apertura</th>
        <th>Cierre</th>
        <th>Fecha</th>
        <th>Estado</th>
            <th>Accion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cajas as $caja)
            <tr>
            <td>{{ $caja->nombre }}</td>
            <td>{{ $caja->descripcion }}</td>
            <td>{{ number_format($caja->apertura) }}</td>
            <td>{{ number_format($caja->cierre) }}</td>
            <td>{{ $caja->fecha ?? 'Sin datos'}}</td>
             <td>{{ $caja->estado }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['cajas.destroy', $caja->id], 'method' => 'delete']) !!}
                    <div class="btn-group" role="group" aria-label="Acciones Caja">
                    <!-- Botón para abrir la caja -->
                    @if($caja->estado=='Inactivo')
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAperturaCaja">
                        <i class="fas fa-cash-register"></i>
                    </button>
                    @endif
                    <!-- Botón para editar -->
                    <a href="{{ route('cajas.edit', [$caja->id]) }}" class="btn btn-warning btn-sm">
                        <i class="far fa-edit"></i>
                    </a>

                    <!-- Botón para eliminar -->
                    {!! Form::button('<i class="far fa-trash-alt"></i>', [
                        'type' => 'submit',
                        'class' => 'btn btn-danger btn-sm',
                        'onclick' => "return confirm('¿Estás seguro de eliminar esta caja?')"
                    ]) !!}
                </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            <!-- Bootstrap CSS -->
            <!-- Bootstrap JS (necesita Popper también) -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

            <!-- Modal Apertura Caja -->
            <!-- Modal Apertura de Caja -->
            <div class="modal fade" id="modalAperturaCaja" tabindex="-1" aria-labelledby="modalLabelAperturaCaja" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  {!! Form::open(['route' => ['apertura_caja', $caja->id], 'method' => 'POST']) !!}
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelAperturaCaja">Abrir Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      {!! Form::label('monto_apertura', 'Monto de apertura') !!}
                      {!! Form::number('monto_apertura', null, ['class' => 'form-control', 'required', 'min' => 0]) !!}
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Abrir Caja</button>
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
        @endforeach
        </tbody>
    </table>
</div>
