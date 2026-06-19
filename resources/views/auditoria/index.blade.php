@extends('layouts.app')

@section('content')

<div class="container-fluid">


<div class="card">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">
            <i class="fas fa-history"></i>
            Auditoría del Sistema
        </h4>

    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('auditoria') }}">

            @csrf

            <div class="row">

                <div class="col-md-3">

                    <label>Tabla</label>

                    <select name="tabla" class="form-control">

                        <option value="">
                            Todas
                        </option>

                        @foreach($tablas as $item)

                            <option value="{{ $item->tabla }}"
                                {{ request('tabla') == $item->tabla ? 'selected' : '' }}>

                                {{ strtoupper($item->tabla) }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-2">

                    <label>Acción</label>

                    <select name="accion" class="form-control">

                        <option value="">Todas</option>

                        <option value="INSERT">
                            INSERT
                        </option>

                        <option value="UPDATE">
                            UPDATE
                        </option>

                        <option value="DELETE">
                            DELETE
                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <label>Desde</label>

                    <input
                        type="date"
                        name="fecha_desde"
                        class="form-control">

                </div>

                <div class="col-md-2">

                    <label>Hasta</label>

                    <input
                        type="date"
                        name="fecha_hasta"
                        class="form-control">

                </div>

                <div class="col-md-3">

                    <label>&nbsp;</label>

                    <div>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="fas fa-search"></i>
                            Buscar

                        </button>

                        <a
                            href="{{ route('auditoria') }}"
                            class="btn btn-secondary">

                            Limpiar

                        </a>

                    </div>

                </div>

            </div>

        </form>

        <hr>

        <div class="table-responsive">

            <table
                id="tablaAuditoria"
                class="table table-bordered table-hover table-striped">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Tabla</th>
                        <th>Registro</th>
                        <th>Acción</th>
                        <th>Usuario</th>
                        <th>IP</th>
                        <th width="100">Detalle</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($auditorias as $a)

                        <tr>

                            <td>{{ $a->id }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($a->fecha_hora)->format('d/m/Y H:i:s') }}
                            </td>

                            <td>
                                {{ strtoupper($a->tabla) }}
                            </td>

                            <td>
                                {{ $a->registro_id }}
                            </td>

                            <td>

                                @if($a->accion=='INSERT')

                                    <span class="badge badge-success">
                                        INSERT
                                    </span>

                                @elseif($a->accion=='UPDATE')

                                    <span class="badge badge-warning">
                                        UPDATE
                                    </span>

                                @else

                                    <span class="badge badge-danger">
                                        DELETE
                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $a->usuario_sistema ?? $a->usuario_mysql }}

                            </td>

                            <td>

                                {{ $a->ip }}

                            </td>

                            <td>

                                <button
                                    class="btn btn-info btn-sm"
                                    data-toggle="modal"
                                    data-target="#modal{{ $a->id }}">

                                    Ver

                                </button>

                            </td>

                        </tr>

                        <div
                            class="modal fade"
                            id="modal{{ $a->id }}"
                            tabindex="-1">

                            <div class="modal-dialog modal-xl">

                                <div class="modal-content">

                                    <div class="modal-header bg-primary text-white">

                                        <h5 class="modal-title">

                                            Auditoría #{{ $a->id }}

                                        </h5>

                                        <button
                                            type="button"
                                            class="close text-white"
                                            data-dismiss="modal">

                                            <span>&times;</span>

                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-md-6">

                                                <div class="card">

                                                    <div class="card-header bg-danger text-white">

                                                        Datos Anteriores

                                                    </div>

                                                    <div class="card-body">


<pre>{{ json_encode(json_decode($a->datos_anteriores), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>


                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="card">

                                                    <div class="card-header bg-success text-white">

                                                        Datos Nuevos

                                                    </div>

                                                    <div class="card-body">


<pre>{{ json_encode(json_decode($a->datos_nuevos), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>


</div>

@endsection

@section('scripts')

<script>

$(document).ready(function(){

    $('#tablaAuditoria').DataTable({

        pageLength: 25,

        order: [[0,'desc']],

        language: {

            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'

        }

    });

});

</script>

@endsection
