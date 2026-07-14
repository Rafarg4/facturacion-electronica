 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Cliente</th>
        <th>Fecha Venta</th>
        <th>Cajero</th>
        <th>Tipo Comprobante</th>
        <th>Numero Comprobante</th>
        <th>Total</th>
        <th>Iva</th>
        <th>Forma Pago</th>
        <th>Estado</th>
        <th>Observacion</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ventas as $venta)
            <tr>
            <td>{{ $venta->nombre }} {{ $venta->apellido }}</td>
            <td>{{ $venta->fecha_venta }}</td>
            <td>{{ $venta->id_usuario }}</td>
            <td>{{ $venta->tipo_comprobante }}</td>
            <td>{{ $venta->numero_comprobante }}</td>
            <td>{{ number_format($venta->total) }}</td>
            <td>{{ $venta->iva }}%</td>
            <td>{{ $venta->forma_pago }}</td>
           <td>
                @if($venta->estado === 'Anulado')
                    <span style="background-color: #f8d7da; color: #721c24; padding: 3px 8px; border-radius: 5px;">
                        {{ $venta->estado }}
                    </span>
                @elseif($venta->estado === 'Activo')
                    <span style="background-color: #d4edda; color: #155724; padding: 3px 8px; border-radius: 5px;">
                        {{ $venta->estado }}
                    </span>
                @else
                    {{ $venta->estado }}
                @endif
            </td>
            <td>{{ $venta->observacion }}</td>
                <td width="160">
                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                    @if(in_array($venta->tipo_comprobante, ['Recibo', 'Factura']))
                    <a href="{{ route('comprobante.generar', $venta->id) }}" class="btn btn-primary btn-sm" target="_blank" title="Ver ticket">
                        <i class="fas fa-receipt"></i>
                    </a>
                    @endif
                    @if($venta->tipo_comprobante=='Factura')
                    <a href="{{ route('generar_factura', $venta->id) }}" class="btn btn-primary btn-sm" target="_blank" title="Ver factura A4">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                    @endif
                    @if(!empty($venta->cdc))
                    <a href="{{ route('facturas_electronicas.kude', $venta->id) }}" class="btn btn-secondary btn-sm" title="Ver KuDE oficial (SIFEN)" target="_blank">
                        <i class="fas fa-qrcode"></i>
                    </a>
                    @endif
                    @if($venta->estado=='Activo')
                   <form action="{{ route('ventas.anular', $venta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas anular esta venta?');" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-ban"></i>
                        </button>
                    </form>
                    @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
