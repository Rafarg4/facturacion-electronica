@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Movimiento de Productos</h1>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form method="GET" action="{{ route('movimiento_productos') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>Producto</label>
                        <select name="id_producto" id="select-producto" class="form-control" style="width:100%">
                            <option value="">Todos los productos</option>
                            @if($productoSeleccionado)
                                <option value="{{ $productoSeleccionado->id }}" selected>
                                    {{ $productoSeleccionado->codigo ? '[' . $productoSeleccionado->codigo . '] ' : '' }}{{ $productoSeleccionado->descripcion }}
                                </option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ $fecha_desde }}">
                    </div>
                    <div class="col-md-2">
                        <label>Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ $fecha_hasta }}">
                    </div>
                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="{{ route('movimiento_productos') }}" class="btn btn-secondary">
                                Limpiar
                            </a>
                            <a href="{{ route('movimiento_productos.pdf', request()->only(['id_producto','fecha_desde','fecha_hasta'])) }}"
                               class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <hr>

            @if($movimientos->count() > 0)
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="card bg-success text-white text-center">
                        <div class="card-body py-2">
                            <div style="font-size:12px;">Total Entradas</div>
                            <div style="font-size:22px; font-weight:bold;">{{ number_format($movimientos->where('tipo', 'Entrada')->sum('cantidad')) }}</div>
                            <div style="font-size:11px;">unidades</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white text-center">
                        <div class="card-body py-2">
                            <div style="font-size:12px;">Total Salidas</div>
                            <div style="font-size:22px; font-weight:bold;">{{ number_format($movimientos->where('tipo', 'Salida')->sum('cantidad')) }}</div>
                            <div style="font-size:11px;">unidades</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white text-center">
                        <div class="card-body py-2">
                            <div style="font-size:12px;">Neto (Entrada - Salida)</div>
                            <div style="font-size:22px; font-weight:bold;">
                                {{ number_format($movimientos->where('tipo', 'Entrada')->sum('cantidad') - $movimientos->where('tipo', 'Salida')->sum('cantidad')) }}
                            </div>
                            <div style="font-size:11px;">unidades</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark text-center">
                        <div class="card-body py-2">
                            <div style="font-size:12px;">Total Registros</div>
                            <div style="font-size:22px; font-weight:bold;">{{ $movimientos->count() }}</div>
                            <div style="font-size:11px;">movimientos</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="tabla-movimientos" style="font-size: 12px;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-right">Precio Unit.</th>
                            <th class="text-right">Subtotal</th>
                            <th>Comprobante</th>
                            <th>Cliente / Referencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimientos as $mov)
                            <tr>
                                <td>
                                    @if($mov->tipo === 'Entrada')
                                        <span style="background-color: #d4edda; color: #155724; padding: 3px 8px; border-radius: 5px; font-weight: bold; white-space: nowrap;">
                                            <i class="fas fa-arrow-circle-down"></i> Entrada
                                        </span>
                                    @else
                                        <span style="background-color: #f8d7da; color: #721c24; padding: 3px 8px; border-radius: 5px; font-weight: bold; white-space: nowrap;">
                                            <i class="fas fa-arrow-circle-up"></i> Salida
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $mov->fecha }}</td>
                                <td>{{ $mov->producto }}</td>
                                <td class="text-center">{{ number_format($mov->cantidad) }}</td>
                                <td class="text-right">{{ number_format($mov->precio_unitario) }}</td>
                                <td class="text-right">{{ number_format($mov->subtotal) }}</td>
                                <td>{{ $mov->comprobante }}</td>
                                <td>{{ $mov->referencia }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox" style="font-size: 24px;"></i><br>
                                    No se encontraron movimientos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection

@push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function(){

    $('#select-producto').select2({
        ajax: {
            url: '{{ route("productos.buscarParaFiltro") }}',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                return { q: params.term || '' };
            },
            processResults: function(data) {
                return { results: data.results };
            },
            cache: true
        },
        placeholder: 'Escribí nombre o código para buscar...',
        allowClear: true,
        minimumInputLength: 1,
        language: {
            inputTooShort: function() { return 'Escribí al menos 1 carácter para buscar'; },
            noResults: function() { return 'Sin resultados'; },
            searching: function() { return 'Buscando...'; }
        }
    });

});
</script>
@endpush
