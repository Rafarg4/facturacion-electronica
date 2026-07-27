<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Facturas Emitidas</title>
    <style>
        @page { size: A4 landscape; margin: 12mm 10mm; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; }
        p { margin: 2px 0; }

        .header { width: 100%; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 12px; }
        .header td { vertical-align: middle; }
        .empresa-nombre { font-size: 15px; font-weight: bold; }
        .reporte-titulo { font-size: 14px; font-weight: bold; text-align: right; }
        .reporte-sub    { font-size: 11px; text-align: right; color: #555; }

        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th {
            background: #2c3e50; color: #fff;
            padding: 5px 6px; text-align: left; font-size: 10px;
        }
        table.data td { padding: 4px 6px; border-bottom: 1px solid #e0e0e0; font-size: 10px; }
        table.data tr:nth-child(even) td { background: #f8f9fa; }
        table.data .text-right { text-align: right; }
        table.data .text-center { text-align: center; }

        .tfoot-row td {
            background: #ecf0f1; font-weight: bold;
            border-top: 2px solid #333; padding: 5px 6px;
        }

        .badge-anulado { background-color: #f8d7da; color: #721c24; padding: 2px 6px; border-radius: 4px; }
        .badge-activo  { background-color: #d4edda; color: #155724; padding: 2px 6px; border-radius: 4px; }

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

    $totalGeneral = 0;
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
            <div class="reporte-titulo">REPORTE DE FACTURAS EMITIDAS</div>
            <div class="reporte-sub">
                Período: {{ \Carbon\Carbon::parse($fecha_desde)->format('d/m/Y') }}
                al {{ \Carbon\Carbon::parse($fecha_hasta)->format('d/m/Y') }}
            </div>
            @if($cliente_nombre)
                <div class="reporte-sub">Cliente: {{ $cliente_nombre }}</div>
            @endif
            <div class="reporte-sub" style="margin-top:4px;">
                Generado: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </div>
        </td>
    </tr>
</table>

{{-- Tabla de facturas --}}
<table class="data">
    <thead>
        <tr>
            <th>#</th>
            <th>Comprobante</th>
            <th>N° Comprobante</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Doc.</th>
            <th>Condición</th>
            <th>Forma de Pago</th>
            <th class="text-center">Moneda</th>
            <th class="text-center">IVA</th>
            <th class="text-right">Total (Gs)</th>
            <th class="text-center">Estado</th>
        </tr>
    </thead>
    <tbody>
    @forelse($ventas as $i => $venta)
        @php
            $totalGsVenta = (float) ($venta->total_gs ?? $venta->total);
            if ($venta->estado !== 'Anulado') {
                $totalGeneral += $totalGsVenta;
            }
        @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $venta->tipo_comprobante }}</td>
            <td>{{ $venta->numero_comprobante }}</td>
            <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</td>
            <td>{{ $venta->nombre }} {{ $venta->apellido }}</td>
            <td>{{ $venta->ci }}</td>
            <td>{{ $venta->condicion_venta }}</td>
            <td>{{ $venta->forma_pago }}</td>
            <td class="text-center">{{ $venta->moneda ?: 'PYG' }}</td>
            <td class="text-center">{{ $venta->iva }}%</td>
            <td class="text-right">{{ number_format($totalGsVenta, 0, ',', '.') }}</td>
            <td class="text-center">
                @if($venta->estado === 'Anulado')
                    <span class="badge-anulado">{{ $venta->estado }}</span>
                @else
                    <span class="badge-activo">{{ $venta->estado }}</span>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="12" style="text-align:center; padding:10px;">Sin resultados.</td></tr>
    @endforelse
    </tbody>
    @if(count($ventas) > 0)
    <tfoot>
        <tr class="tfoot-row">
            <td colspan="10" class="text-right">TOTAL GENERAL EN GS.:</td>
            <td class="text-right">{{ number_format($totalGeneral, 0, ',', '.') }}</td>
            <td></td>
        </tr>
    </tfoot>
    @endif
</table>

<div class="footer">
    {{ $empresa->nombre ?? '' }} &mdash; Reporte generado por el sistema
</div>

</body>
</html>
