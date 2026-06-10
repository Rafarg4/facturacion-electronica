@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Rendicion de caja</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message') 
    @include('adminlte-templates::common.errors')

    <div class="card mx-auto" style="max-width: 600px;">
        @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

        <div class="card-header text-center">
            <strong>Rendicion de cobros y ventas</strong>
        </div>
                 <div class="card-body">
            <form action="{{ route('generar_rendicion_caja') }}" method="POST" target="_blank">
                @csrf
                <div class="form-group">
                    <label for="cajeros">Cajero:</label>
                    <select name="cajeros" id="cajeros" class="form-control">
                        <option value="">Seleccione un cajero</option>
                        @foreach($cajeros as $cajero)
                            <option value=" {{ $cajero->id }}">
                                {{ $cajero->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_incio">Fecha de inicio:</label>
                    <input type="date" name="fecha_incio" id="fecha_incio" class="form-control"
                           value="" >
                </div>
                 <div class="form-group">
                    <label for="fecha_fin">Fecha de fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                           value="" >
                </div>
                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        Generar reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
