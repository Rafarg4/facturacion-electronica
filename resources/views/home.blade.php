@extends('layouts.app')

@section('content')
<link rel="icon" type="image/png" src="/logof.png" />
<div class="container-fluid py-3" style="font-size: 12px;">

    {{-- CARGA RÁPIDA --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header py-2"><h6 class="card-title mb-0"><i class="fas fa-bolt mr-1"></i> Acceso Rápido</h6></div>
        <div class="card-body p-2">
            <div class="d-flex flex-wrap gap-accesos">
                @php
                $cargaRapidaItems = [
                    ['label' => 'Nueva Venta',      'icon' => 'fa-shopping-cart',   'color' => 'text-primary',   'url' => route('ventas.create'),               'permission' => 'ventas'],
                    ['label' => 'Nueva Compra',     'icon' => 'fa-money-bill-wave', 'color' => 'text-warning',   'url' => route('compras.create'),              'permission' => 'inventario'],
                    ['label' => 'Nuevo Cliente',    'icon' => 'fa-users',           'color' => 'text-info',      'url' => route('clientes.create'),             'permission' => 'ventas'],
                    ['label' => 'Nuevo Producto',   'icon' => 'fa-archive',         'color' => 'text-success',   'url' => route('productos.create'),            'permission' => 'inventario'],
                    ['label' => 'Nuevo Presupuesto','icon' => 'fa-file',            'color' => 'text-primary',   'url' => route('presupuestoCabeceras.create'), 'permission' => 'ventas'],
                    ['label' => 'Nueva Caja',       'icon' => 'fa-cash-register',   'color' => 'text-secondary', 'url' => route('cajas.create'),                'permission' => 'caja'],
                    ['label' => 'Generar Cierre',   'icon' => 'fa-lock',            'color' => 'text-danger',    'url' => route('cierre_caja'),                 'permission' => 'caja'],
                    ['label' => 'Nuevo Cobro',      'icon' => 'fa-credit-card',     'color' => 'text-success',   'url' => route('cobros.create'),               'permission' => 'ventas'],
                    ['label' => 'Consulta FE', 'icon' => 'fa-file-invoice', 'color' => 'text-info', 'url' => route('facturas_electronicas.index'), 'permission' => 'ventas'],
                    ['label' => 'Mi Plan',          'icon' => 'fa-credit-card',     'color' => 'text-dark',      'url' => route('planes.index'),                'permission' => 'planes'],
                    ['label' => 'Nuevo Proveedor',  'icon' => 'fa-truck',           'color' => 'text-danger',    'url' => route('proveedors.create'),           'permission' => 'inventario'],
                ];
                @endphp
                @foreach($cargaRapidaItems as $item)
                    @can($item['permission'])
                        @include('partials._acceso_card', $item)
                    @endcan
                @endforeach
            </div>
        </div>
    </div>

    {{-- TABLAS --}}
    <div class="row">

        {{-- Cuotas por vencer --}}
        <div class="col-12 col-lg-6 mb-3">
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header py-2">
                    <h6 class="card-title mb-0"><i class="fas fa-exclamation-triangle text-warning mr-1"></i> Próximas Cuotas a Vencer</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Cliente</th>
                                <th>Venta #</th>
                                <th>Cuota</th>
                                <th>Monto</th>
                                <th>Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cuotasPorVencer as $cuota)
                            @php
                                $dias = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($cuota->fecha_vencimiento), false);
                            @endphp
                            <tr class="{{ $dias <= 3 ? 'table-danger' : ($dias <= 7 ? 'table-warning' : '') }}">
                                <td>{{ $cuota->cliente }}</td>
                                <td>#{{ $cuota->id_venta }}</td>
                                <td>{{ $cuota->numero_cuota }}</td>
                                <td>{{ number_format($cuota->monto, 0, ',', '.') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                                    <small class="text-muted">({{ $dias }}d)</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Sin cuotas próximas a vencer</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-1 text-right">
                    <a href="{{ route('cobros.index') }}" class="text-sm">Ver todos los cobros <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Productos con stock bajo --}}
        <div class="col-12 col-lg-6 mb-3">
            <div class="card card-outline card-danger shadow-sm">
                <div class="card-header py-2">
                    <h6 class="card-title mb-0"><i class="fas fa-exclamation-circle text-danger mr-1"></i> Productos con Stock Bajo</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Mínimo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productosStockBajo as $producto)
                            <tr class="{{ $producto->cantidad == 0 ? 'table-danger' : 'table-warning' }}">
                                <td>{{ $producto->codigo ?? '-' }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td class="text-center font-weight-bold">{{ $producto->cantidad }}</td>
                                <td class="text-center">{{ $producto->cantidad_minima }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Sin productos con stock bajo</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-1 text-right">
                    <a href="{{ route('productos.index') }}" class="text-sm">Ver todos los productos <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.gap-accesos {
    gap: 10px;
}
.acceso-card {
    width: 130px;
    border: 1px solid #dee2e6;
    transition: box-shadow 0.15s, border-color 0.15s, transform 0.1s;
    cursor: pointer;
    background: #fff;
}
.acceso-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,.12) !important;
    border-color: #adb5bd !important;
    transform: translateY(-2px);
}
</style>
@endsection
