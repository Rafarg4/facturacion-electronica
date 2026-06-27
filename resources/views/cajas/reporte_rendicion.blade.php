<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rendición de Caja</title>
    <style>
        @page { size: A4 landscape; margin: 15mm 10mm; }
        body  { font-family: Arial, sans-serif; font-size: 11px; color: #000; }
        p     { margin: 2px 0; }

        /* Encabezado */
        .header { width: 100%; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 12px; }
        .header td { vertical-align: middle; }
        .empresa-nombre { font-size: 15px; font-weight: bold; }
        .reporte-titulo { font-size: 14px; font-weight: bold; text-align: right; }
        .reporte-sub    { font-size: 11px; text-align: right; color: #555; }

        /* Sección */
        h2 { font-size: 12px; margin: 16px 0 4px; color: #2c3e50; border-bottom: 1px solid #ccc; padding-bottom: 3px; }

        /* Tabla */
        table.data { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.data th {
            background: #2c3e50; color: #fff;
            padding: 5px 6px; text-align: center; font-size: 10px;
        }
        table.data td { padding: 4px 6px; border-bottom: 1px solid #e0e0e0; font-size: 10px; text-align: center; }
        table.data tr:nth-child(even) td { background: #f8f9fa; }
        table.data .text-right { text-align: right; }

        /* Totales */
        .tfoot-row td {
            background: #ecf0f1; font-weight: bold;
            border-top: 2px solid #333; padding: 5px 6px;
        }

        /* Total general */
        .total-general { text-align: right; margin-top: 14px; font-size: 12px; font-weight: bold; }

        /* Pie */
        .footer { margin-top: 20px; font-size: 10px; color: #777; text-align: center; border-top: 1px solid #ccc; padding-top: 6px; }
    </style>
</head>
<body>

@php
    $logoBase64 = null;
    $logoExt    = 'png';
    if (!empty($empresa->logo)) {
        $logoPath = public_path('imagenes/' . $empresa->logo);
        if (file_exists($logoPath)) {
            $logoBase64 = base64_encode(file_get_contents($logoPath));
            $logoExt    = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
        }
    }
@endphp

{{-- Encabezado --}}
<table class="header" style="width:100%; border-collapse:collapse;">
    <tr>
        <td style="width:15%;">
            @if($logoBase64)
                <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}"
                     style="max-height:60px; max-width:110px;">
            @endif
        </td>
        <td style="width:45%; padding-left:10px;">
            <div class="empresa-nombre">{{ strtoupper($empresa->nombre ?? '') }}</div>
            @if(!empty($empresa->ruc))
                <p><strong>RUC:</strong> {{ $empresa->ruc }}</p>
            @endif
            @if(!empty($empresa->direccion))
                <p>{{ $empresa->direccion }}</p>
            @endif
        </td>
        <td style="width:40%; text-align:right; vertical-align:top;">
            <div class="reporte-titulo">RENDICIÓN DE CAJA</div>
            <div class="reporte-sub">
                Período: {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }}
                al {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}
            </div>
            <div class="reporte-sub">Generado por: {{ Auth::user()->name }}</div>
            <div class="reporte-sub" style="margin-top:4px;">
                Generado: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </div>
        </td>
    </tr>
</table>

{{-- Cobros --}}
<h2>Rendición de Caja de Cobros</h2>

<table class="data">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Comprobante N°</th>
            <th>Nro Cuota</th>
            <th class="text-right">Monto</th>
            <th class="text-right">Saldo</th>
            <th>Estado</th>
            <th>Fecha Cobro</th>
            <th>Cajero</th>
        </tr>
    </thead>
    <tbody>
        @php $totalGeneral = 0; @endphp
        @forelse($datos as $item)
            @php $totalGeneral += $item->monto; @endphp
            <tr>
                <td>{{ $item->ci }} - {{ $item->nombre }} {{ $item->apellido }}</td>
                <td>{{ $item->comprobante_cobro }}</td>
                <td>{{ $item->nro_cuota }}</td>
                <td class="text-right">{{ number_format($item->monto, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->saldo, 0, ',', '.') }}</td>
                <td>{{ $item->estado }}</td>
                <td>{{ $item->fecha_cobro }}</td>
                <td>{{ $item->name }}</td>
            </tr>
        @empty
            <tr><td colspan="8" style="text-align:center; padding:10px;">Sin datos disponibles</td></tr>
        @endforelse
    </tbody>
    @if(count($datos) > 0)
    <tfoot>
        <tr class="tfoot-row">
            <td colspan="3" class="text-right">TOTAL COBROS:</td>
            <td class="text-right">{{ number_format($totalGeneral, 0, ',', '.') }}</td>
            <td colspan="4"></td>
        </tr>
    </tfoot>
    @endif
</table>

{{-- Ventas --}}
<h2>Rendición de Caja de Ventas</h2>

<table class="data">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Comprobante N°</th>
            <th>Tipo Comprobante</th>
            <th class="text-right">Total</th>
            <th>Estado</th>
            <th>Productos</th>
            <th>Fecha Venta</th>
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
                <td class="text-right">{{ number_format($venta->total, 0, ',', '.') }}</td>
                <td>{{ $venta->estado }}</td>
                <td>{{ $venta->productos }}</td>
                <td>{{ $venta->fecha_venta }}</td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center; padding:10px;">Sin datos disponibles</td></tr>
        @endforelse
    </tbody>
    @if(count($ventas) > 0)
    <tfoot>
        <tr class="tfoot-row">
            <td colspan="3" class="text-right">TOTAL VENTAS:</td>
            <td class="text-right">{{ number_format($totalGeneral_venta, 0, ',', '.') }}</td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
    @endif
</table>

@php $sumatoriaGeneral = ($totalGeneral ?? 0) + ($totalGeneral_venta ?? 0); @endphp

<div class="total-general">
    Total General de Caja: {{ number_format($sumatoriaGeneral, 0, ',', '.') }} Gs.
</div>

<div class="footer">
    {{ $empresa->nombre ?? '' }} &mdash; Reporte generado por el sistema
</div>

</body>
</html>
