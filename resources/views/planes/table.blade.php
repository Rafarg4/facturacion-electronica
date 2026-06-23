 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead class="thead-light">
            <tr>
                <th>Empresa</th>
                <th>Descripción</th>
                <th>Inicio</th>
                <th>Periodicidad</th>
                <th class="text-center">Cuotas</th>
                <th class="text-right">Monto/Cuota</th>
                <th class="text-right">Total Plan</th>
                <th class="text-center">Estado</th>
                <th class="text-center" width="130">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($planes as $plan)
            <tr>
                <td><strong>{{ $plan->empresa }}</strong></td>
                <td>{{ $plan->descripcion ?? '-' }}</td>
                <td>{{ $plan->fecha_inicio ? $plan->fecha_inicio->format('d/m/Y') : '-' }}</td>
                <td class="text-capitalize">{{ $plan->periodicidad }}</td>
                <td class="text-center">
                    <span class="badge badge-success">{{ $plan->cuotas_pagadas ?? 0 }}</span>
                    / {{ $plan->cuotas_count ?? 0 }}
                    <small class="text-muted d-block">pagadas</small>
                </td>
                <td class="text-right">{{ number_format($plan->monto_cuota, 0, ',', '.') }}</td>
                <td class="text-right"><strong>{{ number_format($plan->monto_total, 0, ',', '.') }}</strong></td>
                <td class="text-center">
                    @if($plan->estado === 'Vigente')
                        <span class="badge badge-success" style="font-size:11px;">{{ $plan->estado }}</span>
                    @elseif($plan->estado === 'Finalizado')
                        <span class="badge badge-secondary" style="font-size:11px;">{{ $plan->estado }}</span>
                    @else
                        <span class="badge badge-danger" style="font-size:11px;">{{ $plan->estado }}</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('planes.show', $plan->id) }}"
                       class="btn btn-info btn-sm" title="Ver cuotas">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('planes.edit', $plan->id) }}"
                       class="btn btn-warning btn-sm" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('planes.destroy', $plan->id) }}" method="POST"
                          style="display:inline;"
                          onsubmit="return confirm('¿Eliminar este plan y todas sus cuotas?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center text-muted py-3">
                    No hay planes registrados.
                    <a href="{{ route('planes.create') }}">Crear uno nuevo</a>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
