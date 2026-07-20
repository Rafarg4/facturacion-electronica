@php
    $inventarioActivo = request()->routeIs('productos.*', 'rubros.*', 'listaPrecios.*', 'proveedors.*', 'compras.*', 'movimiento_productos*', 'ficha_compra', 'anular_compra');
    $ventasActivo = request()->routeIs('clientes.*', 'presupuestoCabeceras.*', 'ventas.*', 'facturas_electronicas.*', 'cobros.*', 'consulta_precio', 'buscar_precio', 'comprobante.generar', 'generar_factura', 'cobro_recibo', 'ventasCreditoPorCliente', 'anular_cobro', 'cotizacions.*', 'cotizacion.porMoneda');
    $cajaActivo = request()->routeIs('cajas.*', 'ver_cierres', 'cierre_caja', 'generar_cierre', 'apertura_caja', 'cambiarEstadoCaja');
    $reportesActivo = request()->routeIs('ver_rendicion_caja', 'generar_rendicion_caja', 'ver_cobros_pendientes', 'reporte_cobros_pendientes', 'ver_reporte_stock', 'generar_reporte_stock', 'auditoria', 'buscar_auditoria', 'reporte_cierres', 'reporte_cierres_pdf');
    $configuracionActivo = request()->routeIs('empresas.*', 'users.*', 'koapeCredenciales.*');
@endphp

<li class="nav-item">
    <a href="{{ route('home') }}"
       class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

@can('inventario')
<!-- INVENTARIO -->

<li class="nav-item has-treeview {{ $inventarioActivo ? 'menu-open' : '' }}">


<a href="#" class="nav-link {{ $inventarioActivo ? 'active' : '' }}">
    <i class="nav-icon fas fa-boxes"></i>
    <p>
        Inventario
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('productos.index') }}" class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Productos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('rubros.index') }}" class="nav-link {{ request()->routeIs('rubros.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Rubros</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('listaPrecios.index') }}" class="nav-link {{ request()->routeIs('listaPrecios.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Lista de Precios</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('proveedors.index') }}" class="nav-link {{ request()->routeIs('proveedors.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Proveedores</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('compras.index') }}" class="nav-link {{ request()->routeIs('compras.*', 'ficha_compra', 'anular_compra') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Compras</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('movimiento_productos') }}" class="nav-link {{ request()->routeIs('movimiento_productos*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Movimiento de Productos</p>
        </a>
    </li>

</ul>


</li>
@endcan

@can('ventas')
<!-- VENTAS -->

<li class="nav-item has-treeview {{ $ventasActivo ? 'menu-open' : '' }}">


<a href="#" class="nav-link {{ $ventasActivo ? 'active' : '' }}">
    <i class="nav-icon fas fa-shopping-cart"></i>
    <p>
        Ventas
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('clientes.index') }}" class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Clientes</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('presupuestoCabeceras.index') }}" class="nav-link {{ request()->routeIs('presupuestoCabeceras.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Presupuestos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('ventas.index') }}" class="nav-link {{ request()->routeIs('ventas.*', 'comprobante.generar', 'generar_factura') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Ventas</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('facturas_electronicas.index') }}" class="nav-link {{ request()->routeIs('facturas_electronicas.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Consulta Facturas Electrónicas</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('cobros.index') }}" class="nav-link {{ request()->routeIs('cobros.*', 'cobro_recibo', 'ventasCreditoPorCliente', 'anular_cobro') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Cobros</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('consulta_precio') }}" class="nav-link {{ request()->routeIs('consulta_precio') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Consulta de Precios</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('cotizacions.index') }}" class="nav-link {{ request()->routeIs('cotizacions.*', 'cotizacion.porMoneda') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Cotizaciones</p>
        </a>
    </li>

</ul>


</li>
@endcan

@can('caja')
<!-- CAJA -->

<li class="nav-item has-treeview {{ $cajaActivo ? 'menu-open' : '' }}">


<a href="#" class="nav-link {{ $cajaActivo ? 'active' : '' }}">
    <i class="nav-icon fas fa-cash-register"></i>
    <p>
        Caja
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('cajas.index') }}" class="nav-link {{ request()->routeIs('cajas.*', 'apertura_caja', 'cambiarEstadoCaja') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Cajas Disponibles</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('ver_cierres') }}" class="nav-link {{ request()->routeIs('ver_cierres') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Historial de Cierres</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('cierre_caja') }}" class="nav-link {{ request()->routeIs('cierre_caja', 'generar_cierre') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Generar Cierre</p>
        </a>
    </li>

</ul>


</li>
@endcan

@can('reportes')
<!-- REPORTES -->

<li class="nav-item has-treeview {{ $reportesActivo ? 'menu-open' : '' }}">


<a href="#" class="nav-link {{ $reportesActivo ? 'active' : '' }}">
    <i class="nav-icon fas fa-chart-bar"></i>
    <p>
        Reportes
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('ver_rendicion_caja') }}" class="nav-link {{ request()->routeIs('ver_rendicion_caja', 'generar_rendicion_caja') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Rendición de Caja</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('ver_cobros_pendientes') }}" class="nav-link {{ request()->routeIs('ver_cobros_pendientes', 'reporte_cobros_pendientes') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Cobros del Día</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('ver_reporte_stock') }}" class="nav-link {{ request()->routeIs('ver_reporte_stock', 'generar_reporte_stock') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Reporte de Productos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('auditoria') }}" class="nav-link {{ request()->routeIs('auditoria', 'buscar_auditoria') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Auditoría</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('reporte_cierres') }}" class="nav-link {{ request()->routeIs('reporte_cierres', 'reporte_cierres_pdf') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Reporte de Cierres</p>
        </a>
    </li>

</ul>


</li>
@endcan

@can('planes')
<li class="nav-item">
    <a href="{{ route('planes.index') }}"
       class="nav-link {{ Request::is('planes*') ? 'active' : '' }}">
       <i class="fa fa-credit-card" aria-hidden="true"></i>
       <p>Mi Plan</p>
    </a>
</li>
@endcan

@can('configuracion')
<!-- CONFIGURACION -->

<li class="nav-item has-treeview {{ $configuracionActivo ? 'menu-open' : '' }}">


<a href="#" class="nav-link {{ $configuracionActivo ? 'active' : '' }}">
    <i class="nav-icon fas fa-cogs"></i>
    <p>
        Configuración
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('empresas.index') }}" class="nav-link {{ request()->routeIs('empresas.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Empresas</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Usuarios</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('koapeCredenciales.edit') }}" class="nav-link {{ request()->routeIs('koapeCredenciales.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Facturación Electrónica</p>
        </a>
    </li>

</ul>
</li>
@endcan
<!-- SALIR -->
<li class="nav-item">

<a href=""
   class="nav-link"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

    <i class="fas fa-sign-out-alt"></i>

    <p>Salir</p>

</a>
</li>



