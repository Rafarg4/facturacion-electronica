@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1>Cobros</h1>
            </div>
            <div class="col-sm-6">
                <div class="d-flex justify-content-end">
                    @auth
                        @php
                            // Obtener el ID de la caja asociada al usuario (sin usar modelo)
                            $userId = Auth::id();
                            $cajaId = DB::table('users')->where('id', $userId)->value('caja');
                            $caja = DB::table('cajas')->where('id', $cajaId)->first();
                        @endphp

                        @if($caja)
                            @if($caja->estado=='Activo') <!-- Caja activa -->
                                <a href="{{ route('cobros.create') }}" class="btn btn-primary">
                                    Nuevo
                                </a>
                            @else <!-- Caja inactiva -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cajaInactivaModal">
                                    Nuevo
                                </button>
                            @endif
                        @else <!-- No tiene caja asignada -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#sinCajaModal">
                                Nuevo
                            </button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para caja inactiva -->
<div class="modal fade" id="cajaInactivaModal" tabindex="-1" aria-labelledby="cajaInactivaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="cajaInactivaModalLabel">Acceso restringido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p><strong>La caja asignada está inactiva.</strong></p>
                <p>Contactá al administrador del sistema para que habilite la caja.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cuando no tiene caja asignada -->
<div class="modal fade" id="sinCajaModal" tabindex="-1" aria-labelledby="sinCajaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="sinCajaModalLabel">Acceso restringido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p><strong>No tenés una caja asignada.</strong></p>
                <p>Por favor, contactá al administrador para asignarte una caja.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="content px-3">
    @include('flash::message')

    <div class="clearfix"></div>

    <div class="card">
        <div class="card-body p-0">
            @include('cobros.table')
        </div>
    </div>
</div>
@endsection
