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
                            <td>{{ number_format($factura->total_gs ?? $factura->total) }}</td>
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
                            <td>
                                @if($factura->estado_sifen == 'rechazado')
                                <form action="{{ route('ventas.reenviar_sifen', $factura->id) }}" method="POST" onsubmit="return confirm('¿Reenviar esta factura a SIFEN con los datos actuales del cliente?');" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm" title="Reenviar a SIFEN">
                                        <i class="fas fa-paper-plane"></i> Reenviar
                                    </button>
                                </form>
                                @endif
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
