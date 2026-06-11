<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rendición de Caja</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<h1 style="text-align: center;">Rendición de caja</h1>
<div class="info" style="text-align: center;">
    <p><strong>Generado por:</strong> {{ Auth::user()->name }}</p>
    <p><strong>Fecha de Inicio:</strong> {{ $fecha_inicio }} | <strong>Fecha de Fin:</strong> {{ $fecha_fin }}</p>
</div>

    <h2>Rendición de Caja de Cobros</h2>

    <table>
        <thead>
            <tr>
                 <th>Cliente</th>
                <th>Comprobante N°</th>
                <th>Nro Cuota</th>
                <th>Monto</th>
                <th>Saldo</th>
                <th>Estado</th>
                <th>Fecha Cobro</th>
                <th>Cajero</th>
            </tr>
        </thead>
        <tbody>
           @php
    $totalGeneral = 0;
@endphp

<tbody>
    @php $totalGeneral = 0; @endphp

      @forelse($datos as $item)
            @php $totalGeneral += $item->monto; @endphp
            <tr>
                <td>{{ $item->ci }} - {{ $item->nombre }} {{ $item->apellido }}</td>
                <td>{{ $item->comprobante_cobro }}</td>
                <td>{{ $item->nro_cuota }}</td>
                <td>{{ number_format($item->monto, 0, ',', '.') }}</td>
                <td>{{ number_format($item->saldo, 0, ',', '.') }}</td>
                <td>{{ $item->estado }}</td>
                <td>{{ $item->fecha_cobro }}</td>
                <td>{{ $item->name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align: center;">Sin datos disponibles</td>
            </tr>
        @endforelse
    </tbody>

    @if(count($datos) > 0)
    <tfoot>
        <tr>
            <td colspan="3"><strong>Total General</strong></td>
            <td><strong>{{ number_format($totalGeneral, 0, ',', '.') }}</strong></td>
            <td colspan="4"></td>
        </tr>
    </tfoot>
    @endif
</table>
<h2>Rendición de Caja de Ventas</h2>

<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Comprobante N°</th>
            <th>Tipo comprobante</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Productos</th>
            <th>Fecha venta</th>
        </tr>
    </thead>
    <tbody>
        @php $totalGeneral_venta = 0; @endphp

        @forelse($ventas as $venta)
            @php $totalGeneral_venta += $venta->total; @endphp
            <tr>
                <td>{{ $venta->ci }} - {{ $venta->nombre }} {{ $venta->apellido }}</td>
                <td>{{ $venta->numero_comprobante }}</td>
                <td>{{ $venta->tipo_comprobante }}</td>
                <td>{{ number_format($venta->total, 0, ',', '.') }}</td>
                <td>{{ $venta->estado }}</td>
                <td>{{ $venta->productos }}</td>
                <td>{{ $venta->fecha_venta }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center;">Sin datos disponibles</td>
            </tr>
        @endforelse
    </tbody>

    @if(count($ventas) > 0)
    <tfoot>
        <tr>
            <td colspan="3"><strong>Total General</strong></td>
            <td><strong>{{ number_format($totalGeneral_venta, 0, ',', '.') }}</strong></td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
    @endif
</table>
@php
    $sumatoriaGeneral = $totalGeneral_venta + $totalGeneral;
@endphp

<h3 style="text-align: right; margin-top: 20px;">
    Total General de Caja: <strong>{{ number_format($sumatoriaGeneral, 0, ',', '.') }} Gs.</strong>
</h3>
</html>
