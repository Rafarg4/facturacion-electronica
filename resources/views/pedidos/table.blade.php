<div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Proveedor</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Estado</th>
            <th>Accion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->ci }} - {{ $pedido->nombre}} {{ $pedido->apellido }}</td>
            <td>{{ $pedido->fecha }}</td>
            <td>{{ number_format($pedido->total) }}</td>
           <td>
                @if($pedido->estado === 'Anulado')
                    <span style="background-color: #f8d7da; color: #721c24; padding: 3px 8px; border-radius: 5px;">
                        {{ $pedido->estado }}
                    </span>
               @elseif($pedido->estado === 'Pendiente')
                    <span style="background-color: #fff3cd; color: #856404; padding: 3px 8px; border-radius: 5px;">
                        {{ $pedido->estado }}
                    </span>
                @elseif($pedido->estado === 'Aplicado')
                    <span style="background-color: #d4edda; color: #155724; padding: 3px 8px; border-radius: 5px;">
                        {{ $pedido->estado }}
                    </span>
                @else
                    {{ $pedido->estado }}
                @endif
            </td>
                    <td width="120">
                        <a href="{{ route('ficha_pedido', $pedido->id) }}" class="btn btn-primary btn-sm me-1" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                        @if($pedido->estado=='Pendiente')
                        <form action="{{ route('anular_pedido', $pedido->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas anular este pedido?');" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-ban"></i> 
                            </button>
                        </form>
                        @endif
                    </td>

                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
