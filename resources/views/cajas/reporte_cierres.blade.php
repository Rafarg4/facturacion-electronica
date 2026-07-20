@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Reporte de Cierres</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message')
    @include('adminlte-templates::common.errors')

    {{-- Filtros --}}
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-header text-center">
            <strong><i class="fas fa-filter mr-1"></i> Filtros</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('reporte_cierres_pdf') }}" method="POST" target="_blank">
                @csrf
                <div class="form-group">
                    <label for="fecha_desde">Desde:</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                           value="{{ date('Y-m-01') }}" required>
                </div>
                <div class="form-group">
                    <label for="fecha_hasta">Hasta:</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                           value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="id_caja">Caja:</label>
                    <select name="id_caja" id="id_caja" class="form-control">
                        <option value="">— Todas —</option>
                        @foreach($cajas as $caja)
                            <option value="{{ $caja->id }}">
                                {{ $caja->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_usuario">Cajero:</label>
                    <select name="id_usuario" id="id_usuario" class="form-control">
                        <option value="">— Todos —</option>
                        @foreach($cajeros as $cajero)
                            <option value="{{ $cajero->id }}">
                                {{ $cajero->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-pdf mr-1"></i> Generar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
