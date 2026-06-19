@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-history mr-2"></i>Reporte de Cierres</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message')

    {{-- Filtros --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filtros</h3>
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'reporte_cierres', 'method' => 'POST', 'id' => 'formFiltros']) !!}
            <div class="row align-items-end">
                <div class="col-6 col-md-2">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Desde</label>
                        <input type="date" name="fecha_desde" class="form-control form-control-sm"
                               value="{{ $filtros['fecha_desde'] ?? date('Y-m-01') }}" required>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                               value="{{ $filtros['fecha_hasta'] ?? date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Caja</label>
                        <select name="id_caja" class="form-control form-control-sm">
                            <option value="">— Todas —</option>
                            @foreach($cajas as $caja)
                                <option value="{{ $caja->id }}"
                                    {{ ($filtros['id_caja'] ?? '') == $caja->id ? 'selected' : '' }}>
                                    {{ $caja->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Cajero</label>
                        <select name="id_usuario" class="form-control form-control-sm">
                            <option value="">— Todos —</option>
                            @foreach($cajeros as $cajero)
                                <option value="{{ $cajero->id }}"
                                    {{ ($filtros['id_usuario'] ?? '') == $cajero->id ? 'selected' : '' }}>
                                    {{ $cajero->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="d-flex gap-1 mt-2 mt-md-0" style="gap:6px;">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-search mr-1"></i> Filtrar
                        </button>
                        <a href="{{ route('reporte_cierres') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    {{-- Resultados --}}
    @if(isset($cierres))
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-list mr-1"></i>
                {{ $cierres->count() }} cierre(s) encontrado(s)
            </h3>
            @if($cierres->count())
            <form method="POST" action="{{ route('reporte_cierres_pdf') }}">
                @csrf
                <input type="hidden" name="fecha_desde"  value="{{ $filtros['fecha_desde'] ?? '' }}">
                <input type="hidden" name="fecha_hasta"  value="{{ $filtros['fecha_hasta'] ?? '' }}">
                <input type="hidden" name="id_caja"      value="{{ $filtros['id_caja'] ?? '' }}">
                <input type="hidden" name="id_usuario"   value="{{ $filtros['id_usuario'] ?? '' }}">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf mr-1"></i> Exportar PDF
                </button>
            </form>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="font-size:12px;">
                <table class="table table-hover table-sm mb-0" id="tablaCierres">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Cajero</th>
                            <th>Caja</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th class="text-right">Monto Apertura</th>
                            <th class="text-right">Monto Cierre</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($cierres as $i => $c)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $c->cajero }}</td>
                            <td>{{ $c->caja }}</td>
                            <td>{{ $c->fecha_apertura }}</td>
                            <td>{{ $c->fecha_cierre }}</td>
                            <td class="text-right">{{ number_format($c->monto_inicial) }}</td>
                            <td class="text-right font-weight-bold">{{ number_format($c->monto_final) }}</td>
                            <td>{{ $c->observaciones }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
                                No hay cierres para los filtros seleccionados.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    @if($cierres->count())
                    <tfoot>
                        <tr class="table-secondary font-weight-bold">
                            <td colspan="5" class="text-right">Totales:</td>
                            <td class="text-right">{{ number_format($cierres->sum('monto_inicial')) }}</td>
                            <td class="text-right">{{ number_format($cierres->sum('monto_final')) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
