@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Cobros del dia</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message') 
    @include('adminlte-templates::common.errors')

    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-header text-center">
            <strong>Seleccione los filtros para generar el reporte</strong>
        </div>
        <div class="card-body">
           <form action="{{ route('generar_reporte_dia') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="zonas">Tipo prestamo:</label>
                    <select name="tipo_prestamo" id="zonas" class="form-control"style="width: 100%;">
                           <option value="" disabled selected>-- Selecciona una opcion --</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Electrodomestico">Electrodomestico</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="zonas">Estado:</label>
                    <select name="estado" id="estado" class="form-control"style="width: 100%;">
                           <option value="" disabled selected>-- Selecciona una opcion --</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                </div>
                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        Generar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Seleccione uno o varios cobradores",
            allowClear: true
        });
    });
</script>
@endsection
