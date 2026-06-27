@extends('layouts.app')

@section('content')
<link rel="icon" type="image/png" src="/logof.png" />
<div class="container-fluid py-3" style="font-size: 12px;">

    {{-- ACCESOS RÁPIDOS POR CATEGORÍA --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body p-2">
            <ul class="nav nav-tabs nav-tabs-accesos" id="tabAccesos" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-ventas" data-toggle="tab" href="#ventas" role="tab">
                        <i class="fas fa-shopping-cart mr-1"></i> Ventas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-compras" data-toggle="tab" href="#compras" role="tab">
                        <i class="fas fa-money-bill-wave mr-1"></i> Compras
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-caja" data-toggle="tab" href="#caja" role="tab">
                        <i class="fas fa-cash-register mr-1"></i> Caja
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-config" data-toggle="tab" href="#config" role="tab">
                        <i class="fas fa-cog mr-1"></i> Config.
                    </a>
                </li>
            </ul>

            <div class="tab-content pt-3 px-1" id="tabAccesosContent">

                {{-- VENTAS --}}
                <div class="tab-pane fade show active" id="ventas" role="tabpanel">
                    <div class="d-flex flex-wrap gap-accesos">
                        @php
                        $ventasItems = [
                            ['label' => 'Clientes',      'icon' => 'fa-users',              'color' => 'text-info',    'url' => route('clientes.index')],
                            ['label' => 'Ventas',        'icon' => 'fa-shopping-cart',      'color' => 'text-primary', 'url' => route('ventas.index')],
                            ['label' => 'Presupuestos',  'icon' => 'fa-file',               'color' => 'text-primary', 'url' => route('presupuestoCabeceras.index')],
                            ['label' => 'Cotizaciones',  'icon' => 'fa-dollar-sign',        'color' => 'text-info',    'url' => route('cotizacions.index')],
                            ['label' => 'Pedidos',       'icon' => 'fa-receipt',            'color' => 'text-danger',  'url' => route('pedidos.index')],
                            ['label' => 'Cobros',        'icon' => 'fa-credit-card',        'color' => 'text-success', 'url' => route('cobros.index')],
                            ['label' => 'Cobros del Día','icon' => 'fa-list',               'color' => 'text-success', 'url' => route('ver_cobros_pendientes')],
                        ];
                        @endphp
                        @foreach($ventasItems as $item)
                            @include('partials._acceso_card', $item)
                        @endforeach
                    </div>
                </div>

                {{-- COMPRAS --}}
                <div class="tab-pane fade" id="compras" role="tabpanel">
                    <div class="d-flex flex-wrap gap-accesos">
                        @php
                        $comprasItems = [
                            ['label' => 'Proveedores', 'icon' => 'fa-truck',           'color' => 'text-danger',   'url' => route('proveedors.index')],
                            ['label' => 'Compras',     'icon' => 'fa-money-bill-wave', 'color' => 'text-warning',  'url' => route('compras.index')],
                            ['label' => 'Rubros',      'icon' => 'fa-clone',           'color' => 'text-secondary','url' => route('rubros.index')],
                        ];
                        @endphp
                        @foreach($comprasItems as $item)
                            @include('partials._acceso_card', $item)
                        @endforeach
                    </div>
                </div>

                {{-- CAJA --}}
                <div class="tab-pane fade" id="caja" role="tabpanel">
                    <div class="d-flex flex-wrap gap-accesos">
                        @php
                        $cajaItems = [
                            ['label' => 'Cajas',          'icon' => 'fa-cash-register',       'color' => 'text-secondary','url' => route('cajas.index')],
                            ['label' => 'Hist. Cierres',  'icon' => 'fa-history',              'color' => 'text-primary',  'url' => route('ver_cierres')],
                            ['label' => 'Rendición Caja', 'icon' => 'fa-file-invoice-dollar',  'color' => 'text-warning',  'url' => route('ver_rendicion_caja')],
                        ];
                        @endphp
                        @foreach($cajaItems as $item)
                            @include('partials._acceso_card', $item)
                        @endforeach
                    </div>
                </div>

                {{-- CONFIG --}}
                <div class="tab-pane fade" id="config" role="tabpanel">
                    <div class="d-flex flex-wrap gap-accesos">
                        @php
                        $configItems = [
                            ['label' => 'Productos', 'icon' => 'fa-archive',  'color' => 'text-success', 'url' => route('productos.index')],
                            ['label' => 'Precios',   'icon' => 'fa-tags',     'color' => 'text-warning', 'url' => url('consulta-precio')],
                            ['label' => 'Empresas',  'icon' => 'fa-building', 'color' => 'text-danger',  'url' => route('empresas.index')],
                            ['label' => 'Usuarios',  'icon' => 'fa-user',     'color' => 'text-dark',    'url' => route('users.index')],
                        ];
                        @endphp
                        @foreach($configItems as $item)
                            @include('partials._acceso_card', $item)
                        @endforeach
                    </div>
                </div>

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
.nav-tabs-accesos .nav-link {
    font-size: 12px;
    padding: 6px 14px;
    color: #555;
}
.nav-tabs-accesos .nav-link.active {
    font-weight: 600;
}
.gap-accesos {
    gap: 10px;
}
.acceso-card {
    width: 90px;
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
