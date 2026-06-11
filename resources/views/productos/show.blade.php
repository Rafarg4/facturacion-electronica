@extends('layouts.app')

@section('content')
<br>
 <div class="card card-primary card-outline">
<div class="card-header">

    <div class="d-flex justify-content-between align-items-center">

        <h3 class="card-title mb-0">
            <i class="fas fa-box"></i>
            Información del Producto
        </h3>

        <a href="{{ route('productos.index') }}"
           class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>

    </div>
</div>
@include('productos.show_fields')
@endsection
