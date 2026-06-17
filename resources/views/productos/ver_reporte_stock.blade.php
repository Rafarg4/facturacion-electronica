@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Reporte de Stock</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('flash::message')
    @include('adminlte-templates::common.errors')

    <div class="card mx-auto" style="max-width:700px;">

        <div class="card-header text-center">
            <strong>Filtros del Reporte</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('generar_reporte_stock') }}"
                  method="POST"
                  target="_blank">

                @csrf

                <div class="form-group">

                    <label for="id_rubro">
                        Rubro
                    </label>

                    <select name="id_rubro"
                            id="id_rubro"
                            class="form-control select2">

                        <option value="">
                            TODOS LOS RUBROS
                        </option>

                        @foreach($rubros as $rubro)

                            <option value="{{ $rubro->descripcion }}">
                                {{ strtoupper($rubro->descripcion) }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label for="tipo_reporte">
                        Tipo de Reporte
                    </label>

                    <select name="tipo_reporte"
                            id="tipo_reporte"
                            class="form-control">

                        <option value="inventario">
                            Inventario Completo
                        </option>

                        <option value="stock_minimo">
                            Productos con Stock Mínimo
                        </option>

                        <option value="solo_stock">
                            Productos con Stock Disponible
                        </option>

                    </select>

                </div>

                <div class="alert alert-info">

                    <strong>Inventario Completo:</strong>
                    muestra todos los productos.

                    <br><br>

                    <strong>Stock Mínimo:</strong>
                    muestra únicamente productos cuya existencia sea menor o igual a la cantidad mínima definida.

                    <br><br>

                    <strong>Stock Disponible:</strong>
                    muestra únicamente productos cuya existencia sea mayor a cero.

                    <br><br>

                    <strong>Rubro:</strong>
                    si no selecciona ningún rubro se incluirán todos los productos.

                </div>

                <div class="text-center mt-4">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fa fa-print"></i>
                        Generar Reporte

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

$(document).ready(function () {

    $('#id_rubro').select2({
        placeholder: 'Buscar rubro...',
        allowClear: true,
        width: '100%'
    });

});

</script>

@endsection