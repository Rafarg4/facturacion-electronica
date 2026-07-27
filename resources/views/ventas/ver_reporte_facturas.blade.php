@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Reporte de Facturas Emitidas</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message')
    @include('adminlte-templates::common.errors')

    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-header text-center">
            <strong><i class="fas fa-filter mr-1"></i> Filtros</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('reporte_facturas_pdf') }}" method="POST" target="_blank">
                @csrf
                <div class="form-group">
                    <label for="fecha_desde">Fecha desde:</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                           value="{{ date('Y-m-01') }}" required>
                </div>
                <div class="form-group">
                    <label for="fecha_hasta">Fecha hasta:</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                           value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="id_cliente">Cliente:</label>
                    <select name="id_cliente" id="id_cliente" class="form-control select2">
                        <option value="">— Todos —</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">
                                {{ $cliente->nombre }} {{ $cliente->apellido }} ({{ $cliente->ci }})
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

<script>
    $(document).ready(function () {
        $('.select2').select2({
            width: '100%',
            placeholder: '— Todos —',
            allowClear: true
        });
    });
</script>
@endsection
