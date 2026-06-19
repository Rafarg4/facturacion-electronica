<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cierres</title>
    <style>
        @page { size: A4; margin: 15mm 10mm; }
        body  { font-family: Arial, sans-serif; font-size: 11px; color: #000; }
        p     { margin: 2px 0; }

        /* Encabezado */
        .header { width: 100%; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 12px; }
        .header td { vertical-align: middle; }
        .empresa-nombre { font-size: 15px; font-weight: bold; }
        .reporte-titulo { font-size: 14px; font-weight: bold; text-align: right; }
        .reporte-sub    { font-size: 11px; text-align: right; color: #555; }

        /* Tabla */
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th {
            background: #2c3e50; color: #fff;
            padding: 5px 6px; text-align: left; font-size: 10px;
        }
        table.data td { padding: 4px 6px; border-bottom: 1px solid #e0e0e0; font-size: 10px; }
        table.data tr:nth-child(even) td { background: #f8f9fa; }
        table.data .text-right { text-align: right; }

        /* Totales */
        .tfoot-row td {
            background: #ecf0f1; font-weight: bold;
            border-top: 2px solid #333; padding: 5px 6px;
        }

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
            <div class="reporte-titulo">REPORTE DE CIERRES</div>
            <div class="reporte-sub">
                Período: {{ \Carbon\Carbon::parse($fecha_desde)->format('d/m/Y') }}
                al {{ \Carbon\Carbon::parse($fecha_hasta)->format('d/m/Y') }}
            </div>
            @if($caja_nombre)
                <div class="reporte-sub">Caja: {{ $caja_nombre }}</div>
            @endif
            @if($cajero_nombre)
                <div class="reporte-sub">Cajero: {{ $cajero_nombre }}</div>
            @endif
            <div class="reporte-sub" style="margin-top:4px;">
                Generado: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </div>
        </td>
    </tr>
</table>

{{-- Tabla de cierres --}}
<table class="data">
    <thead>
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
            <td class="text-right"><strong>{{ number_format($c->monto_final) }}</strong></td>
            <td>{{ $c->observaciones }}</td>
        </tr>
    @empty
        <tr><td colspan="8" style="text-align:center; padding:10px;">Sin resultados.</td></tr>
    @endforelse
    </tbody>
    @if(count($cierres) > 0)
    <tfoot>
        <tr class="tfoot-row">
            <td colspan="5" class="text-right">TOTALES:</td>
            <td class="text-right">{{ number_format(collect($cierres)->sum('monto_inicial')) }}</td>
            <td class="text-right">{{ number_format(collect($cierres)->sum('monto_final')) }}</td>
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
