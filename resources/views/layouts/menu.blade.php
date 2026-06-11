<div class="input-group" data-widget="sidebar-search">
<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
<div class="input-group-append">
<button class="btn btn-sidebar">
<i class="fas fa-search fa-fw"></i>
</button>
</div>
</div>
<br>
<li class="nav-item">
    <a href="{{ route('home') }}"
       class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
       <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('categorias.index') }}"
       class="nav-link {{ Request::is('categorias*') ? 'active' : '' }}">
       <i class="fa fa-bars" aria-hidden="true"></i>
        <p>Categorias</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('rubros.index') }}"
       class="nav-link {{ Request::is('rubros*') ? 'active' : '' }}">
      <i class="fa fa-clone" aria-hidden="true"></i>
        <p>Rubros</p>
    </a>
</li>
</li><li class="nav-item">
    <a href="{{ route('cotizacions.index') }}"
       class="nav-link {{ Request::is('cotizacions*') ? 'active' : '' }}">
       <i class="fas fa-dollar-sign"></i>
        <p>Cotizaciones</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('clientes.index') }}"
       class="nav-link {{ Request::is('clientes*') ? 'active' : '' }}">
       <i class="fa fa-users" aria-hidden="true"></i>
        <p>Clientes</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('cobros.index') }}"
       class="nav-link {{ Request::is('cobros*') ? 'active' : '' }}">
       <i class="fa fa-credit-card" aria-hidden="true"></i>
        <p>Cobros</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('ventas.index') }}"
       class="nav-link {{ Request::is('ventas*') ? 'active' : '' }}">
       <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <p>Ventas</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('productos.index') }}"
       class="nav-link {{ Request::is('productos*') ? 'active' : '' }}">
       <i class="fa fa-archive" aria-hidden="true"></i>
        <p>Productos</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('proveedors.index') }}"
       class="nav-link {{ Request::is('proveedors*') ? 'active' : '' }}">
       <i class="fa fa-truck" aria-hidden="true"></i>
        <p>Proveedors</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('compras.index') }}"
       class="nav-link {{ Request::is('compras*') ? 'active' : '' }}">
       <i class="fas fa-money-bill-wave"></i> <!-- carrito de compras -->
        <p>Compras</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('pedidos.index') }}"
       class="nav-link {{ Request::is('pedidos*') ? 'active' : '' }}">
        <i class="fas fa-receipt"></i>
        <p>Pedidos</p>
    </a>
</li>

<li class="nav-item">
    <a href=""
       class="nav-link ">
      <i class="fas fa-file-invoice-dollar"></i>
        <p>Reportes</p>
        <i class="right fas fa-angle-left"></i>
    </a>
<ul class="nav nav-treeview">
<li class="nav-item">
<a href="{{ route('ver_rendicion_caja') }}" class="nav-link"
  class="nav-link">
<i class="fa fas-solid fa-list"></i>
<p>Rendicion de caja</p>
</a>
</li>
<li class="nav-item">
<a href="{{ route('ver_cobros_pendientes') }}" class="nav-link"
  class="nav-link">
<i class="fa fas-solid fa-list"></i>
<p>Cobros del dia</p>
</a>
</li> 
</ul>
</li>
<li class="nav-item">
    <a href=""
       class="nav-link ">
       <i class="fas fa-cash-register"></i>
        <p>Caja</p>
        <i class="right fas fa-angle-left"></i>
    </a>
<ul class="nav nav-treeview">
<li class="nav-item">
    <a href="{{ route('cajas.index') }}"
       class="nav-link {{ Request::is('cajas*') ? 'active' : '' }}">
       <i class="fa fa-address-card" aria-hidden="true"></i>
        <p>Cajas disponibles</p>
    </a>
</li>
</li>
<li class="nav-item">
    <a href="{{ route('ver_cierres') }}"
       class="nav-link {{ Request::is('ver_cierres*') ? 'active' : '' }}">
      <i class="fa fa-history" aria-hidden="true"></i>
        <p>Historial de Cierres </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('cierre_caja') }}"
       class="nav-link {{ Request::is('cierre_caja*') ? 'active' : '' }}">
       <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        <p>Generar Cierre </p>
    </a>
</li>
</ul>
</li>
<li class="nav-item">
    <a href="{{ route('empresas.index') }}"
       class="nav-link {{ Request::is('empresas*') ? 'active' : '' }}">
       <i class="fa fa-building" aria-hidden="true"></i>
        <p>Empresas</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
       <i class="fa fa-light fa-user"></i>
        <p>Usuarios</p>
    </a>
</li>
<li class="nav-item">
    <a href="" 
       class="nav-link " onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="fas fa-sign-out-alt"></i>
        <p>Salir</p>
    </a>





