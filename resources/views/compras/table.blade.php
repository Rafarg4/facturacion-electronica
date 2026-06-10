 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Nro de pedido</th>
        <th>Fecha Compra</th>
        <th>Tipo Comprobante</th>
        <th>Numero Comprobante</th>
        <th>Total</th>
        <th>Forma Pago</th>
        <th>Estado</th>
        <th>Observacion</th>
            <th>Accion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($compras as $compra)
            <tr>
                <td>{{ $compra->id_pedido }}</td>
            <td>{{ $compra->fecha_compra }}</td>
            <td>{{ $compra->tipo_comprobante }}</td>
            <td>{{ $compra->numero_comprobante }}</td>
            <td>{{ number_format($compra->total) }}</td>
            <td>{{ $compra->forma_pago }}</td>
            <td>
                @if($compra->estado === 'Anulado')
                    <span style="background-color: #f8d7da; color: #721c24; padding: 3px 8px; border-radius: 5px;">
                        {{ $compra->estado }}
                    </span>
                @elseif($compra->estado === 'Activo')
                    <span style="background-color: #d4edda; color: #155724; padding: 3px 8px; border-radius: 5px;">
                        {{ $compra->estado }}
                    </span>
                @else
                    {{ $compra->estado }}
                @endif
            </td>
            <td>{{ $compra->observacion }}</td>
               <td width="120">
                    <div class="d-flex" style="gap: 3px;">
                        <a href="{{ route('ficha_compra', $compra->id) }}" class="btn btn-primary btn-sm" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>

                        @if($compra->estado == 'Activo')
                            <form action="{{ route('anular_compra', $compra->id) }}" method="POST" onsubmit="return confirm('¿Deseas anular esta compra?');" style="display: inline;">
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
