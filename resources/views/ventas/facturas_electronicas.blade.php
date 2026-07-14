@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1>Facturas Electrónicas</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message')

    <div class="clearfix"></div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive" style="padding:15px;font-size: 12px;">
                <table class="table" id="table">
                    <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>N° Comprobante</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>CDC</th>
                        <th>Estado SIFEN</th>
                        <th>Mensaje</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($facturas as $factura)
                        <tr>
                            <td>{{ $factura->nombre }} {{ $factura->apellido }}</td>
                            <td>{{ $factura->numero_comprobante }}</td>
                            <td>{{ $factura->fecha_venta }}</td>
                            <td>{{ number_format($factura->total) }}</td>
                            <td style="word-break: break-all;">{{ $factura->cdc }}</td>
                            <td>
                                @php
                                    $colores = [
                                        'aprobado' => '#d4edda; color: #155724',
                                        'aprobado_con_observacion' => '#d4edda; color: #155724',
                                        'rechazado' => '#f8d7da; color: #721c24',
                                        'error' => '#f8d7da; color: #721c24',
                                        'pendiente' => '#fff3cd; color: #856404',
                                        'en_procesamiento' => '#fff3cd; color: #856404',
                                    ];
                                    $estilo = $colores[$factura->estado_sifen] ?? '#e2e3e5; color: #383d41';
                                @endphp
                                <span style="background-color: {{ $estilo }}; padding: 3px 8px; border-radius: 5px;">
                                    {{ $factura->estado_sifen ?? 'sin estado' }}
                                </span>
                            </td>
                            <td>{{ $factura->mensaje_sifen }}</td>
                            <td width="120">
                                <form action="{{ route('facturas_electronicas.consultar_estado', $factura->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" title="Consultar estado en SIFEN">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                                <a href="{{ route('facturas_electronicas.kude', $factura->id) }}" class="btn btn-secondary btn-sm" title="Ver KuDE oficial (SIFEN)" target="_blank">
                                    <i class="fas fa-qrcode"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Todavía no se emitió ninguna factura electrónica.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
