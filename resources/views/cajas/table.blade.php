<style>
.usuario-badge {
    display: inline-flex;
    align-items: center;
    background: #e9ecef;
    border-radius: 20px;
    padding: 2px 8px 2px 6px;
    font-size: 11px;
    margin: 2px;
    gap: 5px;
}
.usuario-badge .btn-remove {
    background: none;
    border: none;
    padding: 0;
    color: #aaa;
    cursor: pointer;
    line-height: 1;
    font-size: 11px;
}
.usuario-badge .btn-remove:hover { color: #dc3545; }
</style>

<div class="table-responsive" style="padding:15px; font-size: 12px;">
    <table class="table table-hover" id="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Apertura</th>
                <th>Cierre</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Usuarios Asignados</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cajas as $caja)
            @php
                $asignados   = $users->where('caja', $caja->id);
                $sinAsignar  = $users->filter(fn($u) => $u->caja != $caja->id);
            @endphp
            <tr>
                <td>{{ $caja->nombre }}</td>
                <td>{{ $caja->descripcion }}</td>
                <td>{{ number_format($caja->apertura) }}</td>
                <td>{{ number_format($caja->cierre) }}</td>
                <td>{{ $caja->fecha ?? 'Sin datos' }}</td>
                <td>
                    <span class="badge badge-{{ $caja->estado === 'Activo' ? 'success' : 'secondary' }}">
                        {{ $caja->estado }}
                    </span>
                </td>

                {{-- Usuarios asignados --}}
                <td style="min-width:150px;">
                    @forelse($asignados as $u)
                        <span class="usuario-badge">
                            <i class="fas fa-user text-primary" style="font-size:10px;"></i>
                            {{ $u->name }}
                            {!! Form::open([
                                'route'  => ['cajas.desasignarUsuario', $caja->id, $u->id],
                                'method' => 'DELETE',
                                'style'  => 'display:inline; margin:0;'
                            ]) !!}
                            <button type="submit" class="btn-remove"
                                    title="Quitar"
                                    onclick="return confirm('¿Quitar a {{ $u->name }} de esta caja?')">
                                ✕
                            </button>
                            {!! Form::close() !!}
                        </span>
                    @empty
                        <span class="text-muted">Sin asignar</span>
                    @endforelse
                </td>

                {{-- Acciones --}}
                <td width="150">
                    {!! Form::open(['route' => ['cajas.destroy', $caja->id], 'method' => 'delete']) !!}
                    <div style="display:flex; gap:4px; flex-wrap:wrap;">
                        @if($caja->estado == 'Inactivo')
                        <button type="button"
                                class="btn btn-primary btn-sm"
                                data-toggle="modal"
                                data-target="#modalApertura{{ $caja->id }}"
                                title="Abrir caja">
                            <i class="fas fa-cash-register"></i>
                        </button>
                        @endif
                        @if($sinAsignar->count())
                        <button type="button"
                                class="btn btn-info btn-sm"
                                data-toggle="modal"
                                data-target="#modalAsignar{{ $caja->id }}"
                                title="Asignar usuario">
                            <i class="fas fa-user-plus"></i>
                        </button>
                        @endif
                        <a href="{{ route('cajas.edit', $caja->id) }}" class="btn btn-warning btn-sm" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', [
                            'type'    => 'submit',
                            'class'   => 'btn btn-danger btn-sm',
                            'title'   => 'Eliminar',
                            'onclick' => "return confirm('¿Eliminar esta caja?')"
                        ]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- ===== MODALES (fuera de la tabla para evitar conflicto con DataTables) ===== --}}
@foreach($cajas as $caja)
    @php
        $asignados  = $users->where('caja', $caja->id);
        $sinAsignar = $users->filter(fn($u) => $u->caja != $caja->id);
    @endphp

    {{-- Modal: Apertura de caja --}}
    @if($caja->estado == 'Inactivo')
    <div class="modal fade" id="modalApertura{{ $caja->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => ['apertura_caja', $caja->id], 'method' => 'POST']) !!}
                <div class="modal-header">
                    <h5 class="modal-title">Abrir Caja — {{ $caja->nombre }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        {!! Form::label('monto_apertura', 'Monto de apertura') !!}
                        {!! Form::number('monto_apertura', null, ['class' => 'form-control', 'min' => 0, 'required' => true]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Abrir Caja</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @endif

    {{-- Modal: Asignar usuario --}}
    @if($sinAsignar->count())
    <div class="modal fade" id="modalAsignar{{ $caja->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => ['cajas.asignarUsuario', $caja->id], 'method' => 'POST']) !!}
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus mr-1"></i> Asignar a {{ $caja->nombre }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-1">
                        <label>Usuario</label>
                        <select name="id_usuario" class="form-control form-control-sm" required>
                            <option value="">-- Seleccione --</option>
                            @foreach($sinAsignar as $u)
                                <option value="{{ $u->id }}">
                                    {{ $u->name }}
                                    @if($u->caja) (tiene otra caja) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <small class="text-muted">Si ya tiene caja asignada, se reemplazará por esta.</small>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-check mr-1"></i> Asignar
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @endif

@endforeach
