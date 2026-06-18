@extends('layouts.app')

@section('content')
<br>
   <link rel="icon" type="image/png" src="/logof.png" />
<div class="container-fluid"style="font-size: 12px;">
<div class="row">
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-info elevation-1"> <i class="fa fa-users" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Clientes</span>
<span class="info-box-number">
<a href="{{ route('clientes.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a>
</span>
</div>

</div>
</div>
<div class="clearfix hidden-md-up"></div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box mb-3">
<span class="info-box-icon bg-primary elevation-1"><i class="fa fas-solid fa-bars"></i></span>
<div class="info-box-content">
<span class="info-box-text">Ventas</span>
<span class="info-box-number"><a href="{{ route('ventas.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>

</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-success elevation-1"><i class="fa fa-archive" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Productos</span>
<span class="info-box-number"><a href="{{ route('productos.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-warning elevation-1"><i class="fa fa-bars" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Precios</span>
<span class="info-box-number"><a href="{{ url('consulta-precio') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-danger elevation-1"> <i class="fa fa-truck" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Proveedores</span>
<span class="info-box-number"><a href="{{ route('proveedors.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-secondary elevation-1"><i class="fa fa-clone" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Rubros</span>
<span class="info-box-number"><a href="{{ route('rubros.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar-sign"></i></span>
<div class="info-box-content">
<span class="info-box-text">Cotizaciones</span>
<span class="info-box-number"><a href="{{ route('cotizacions.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-primary elevation-1"><i class="fa fa-file" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Presupuestos</span>
<span class="info-box-number"><a href="{{ route('presupuestoCabeceras.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-success elevation-1"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Cobros</span>
<span class="info-box-number"><a href="{{ route('cobros.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>
<div class="info-box-content">
<span class="info-box-text">Compras</span>
<span class="info-box-number"><a href="{{ route('compras.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-receipt"></i></span>
<div class="info-box-content">
<span class="info-box-text">Pedidos</span>
<span class="info-box-number"><a href="{{ route('pedidos.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cash-register"></i></span>
<div class="info-box-content">
<span class="info-box-text">Cajas</span>
<span class="info-box-number"><a href="{{ route('cajas.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-primary elevation-1"><i class="fa fa-history" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Historial de Cierres</span>
<span class="info-box-number"><a href="{{ route('ver_cierres') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
<div class="info-box-content">
<span class="info-box-text">Rendicion de Caja</span>
<span class="info-box-number"><a href="{{ route('ver_rendicion_caja') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-success elevation-1"><i class="fa fa-list" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Cobros del Dia</span>
<span class="info-box-number"><a href="{{ route('ver_cobros_pendientes') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-danger elevation-1"><i class="fa fa-building" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Empresas</span>
<span class="info-box-number"><a href="{{ route('empresas.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-3">
<div class="info-box">
<span class="info-box-icon bg-black elevation-1"><i class="fa fa-user" aria-hidden="true"></i></span>
<div class="info-box-content">
<span class="info-box-text">Usuarios</span>
<span class="info-box-number"><a href="{{ route('users.index') }}" class="small-box-footer">Ir a <i class="fas fa-arrow-circle-right"></i></a></span>
</div>
</div>
</div>
@endsection
