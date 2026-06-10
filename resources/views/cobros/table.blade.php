<div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Cliente</th>
        <th>Venta</th>
        <th>Fecha Cobro</th>
         <th>Cajero</th>
         <th>Total</th>
         <th>Estado</th>
        <th>Observacion</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cobros as $cobro)
            <tr>
                <td>{{ $cobro->ci }} - {{ $cobro->nombre }} {{ $cobro->apellido }}</td>
            <td>Nro comprobante: {{ $cobro->numero_comprobante }} - Total: {{ number_format($cobro->total_venta) }}</td>
            <td>{{ $cobro->fecha_cobro }}</td>
            <td>{{ $cobro->name }}</td>
            <td>{{ number_format($cobro->total_cobro) }}</td>
           <td>
                @if($cobro->estado === 'Anulado')
                    <span style="background-color: #f8d7da; color: #721c24; padding: 3px 8px; border-radius: 5px;">
                        {{ $cobro->estado }}
                    </span>
                @elseif($cobro->estado === 'Activo')
                    <span style="background-color: #d4edda; color: #155724; padding: 3px 8px; border-radius: 5px;">
                        {{ $cobro->estado }}
                    </span>
                @else
                    {{ $cobro->estado }}
                @endif
            </td>
            <td>{{ $cobro->observacion }}</td>
                <td width="120">
                        <a href="{{ route('cobro_recibo', $cobro->id) }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                    @if($cobro->estado !='Anulado')
                     <form action="{{ route('anular_cobro', $cobro->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas anular esta cobro?');" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-ban"></i> 
                        </button>
                    </form>
                    @endif
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table> 
</div>
