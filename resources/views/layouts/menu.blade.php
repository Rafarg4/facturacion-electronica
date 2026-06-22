<li class="nav-item">
    <a href="{{ route('home') }}"
       class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<!-- INVENTARIO -->

<li class="nav-item has-treeview">


<a href="#" class="nav-link">
    <i class="nav-icon fas fa-boxes"></i>
    <p>
        Inventario
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('productos.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Productos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('rubros.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Rubros</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('listaPrecios.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Lista de Precios</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('proveedors.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Proveedores</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('compras.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Compras</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('pedidos.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Pedidos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('movimiento_productos') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Movimiento de Productos</p>
        </a>
    </li>

</ul>


</li>

<!-- VENTAS -->

<li class="nav-item has-treeview">


<a href="#" class="nav-link">
    <i class="nav-icon fas fa-shopping-cart"></i>
    <p>
        Ventas
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('clientes.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Clientes</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('presupuestoCabeceras.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Presupuestos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('ventas.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Ventas</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('cobros.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Cobros</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('consulta_precio') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Consulta de Precios</p>
        </a>
    </li>

</ul>


</li>

<!-- CAJA -->

<li class="nav-item has-treeview">


<a href="#" class="nav-link">
    <i class="nav-icon fas fa-cash-register"></i>
    <p>
        Caja
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('cajas.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Cajas Disponibles</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('ver_cierres') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Historial de Cierres</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('cierre_caja') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Generar Cierre</p>
        </a>
    </li>

</ul>


</li>

<!-- REPORTES -->

<li class="nav-item has-treeview">


<a href="#" class="nav-link">
    <i class="nav-icon fas fa-chart-bar"></i>
    <p>
        Reportes
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('ver_rendicion_caja') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Rendición de Caja</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('ver_cobros_pendientes') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Cobros del Día</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('ver_reporte_stock') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Reporte de Productos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('auditoria') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Auditoría</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('reporte_cierres') }}" class="nav-link {{ Request::is('reporte-cierres*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Reporte de Cierres</p>
        </a>
    </li>

</ul>


</li>

<!-- CONFIGURACION -->

<li class="nav-item has-treeview">


<a href="#" class="nav-link">
    <i class="nav-icon fas fa-cogs"></i>
    <p>
        Configuración
        <i class="right fas fa-angle-left"></i>
    </p>
</a>

<ul class="nav nav-treeview">

    <li class="nav-item">
        <a href="{{ route('empresas.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Empresas</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Usuarios</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('cotizacions.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Cotizaciones</p>
        </a>
    </li>

</ul>
</li>
<li class="nav-item">
    <a href="{{ route('miPlans.index') }}"
       class="nav-link {{ Request::is('miPlans*') ? 'active' : '' }}">
       <i class="fa fa-credit-card" aria-hidden="true"></i> 
       <p> Mi Plan</p>
    </a>
</li>
<!-- SALIR -->
<li class="nav-item">

<a href=""
   class="nav-link"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

    <i class="fas fa-sign-out-alt"></i>

    <p>Salir</p>

</a>
</li>



