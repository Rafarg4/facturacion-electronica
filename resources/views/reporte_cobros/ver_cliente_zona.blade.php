@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Clientes por zonas</h1>
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
           <form action="{{ route('generar_cliente_zona') }}" method="POST">
                @csrf
                 <div class="form-group">
                    <label for="zonas">Zonas:</label>
                    <select name="zona" id="zonas" class="form-control"style="width: 100%;">
                           <option value="" disabled selected>-- Selecciona una opcion --</option>
                            <option value="Zona 1">Zona 1</option>
                            <option value="Zona 2">Zona 2</option>
                    </select>
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
