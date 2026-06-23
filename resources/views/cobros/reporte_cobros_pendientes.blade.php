<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cuotas Pendientes</title>
    <style>
        @page { size: A4 portrait; margin: 12mm 10mm; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; }
        p { margin: 2px 0; }

        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .header-table td { vertical-align: middle; }

        .empresa-nombre { font-size: 16px; font-weight: bold; margin: 0 0 3px 0; }
        .reporte-titulo {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #000;
            padding: 5px;
            margin-bottom: 8px;
        }

        .tabla-datos { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .tabla-datos th {
            background-color: #343a40;
            color: #fff;
            padding: 5px;
            border: 1px solid #000;
            font-size: 10px;
        }
        .tabla-datos td {
            border: 1px solid #ccc;
            padding: 4px 5px;
            font-size: 10px;
        }
        .tabla-datos tr:nth-child(even) td { background-color: #f9f9f9; }
        .tabla-datos tfoot td {
            background-color: #343a40;
            color: #fff;
            border: 1px solid #000;
            padding: 5px;
            font-size: 11px;
        }

        .text-right  { text-align: right; }
        .text-center { text-align: center; }
        .footer { text-align: center; font-size: 9px; color: #888; margin-top: 15px; }
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

{{-- ENCABEZADO --}}
<table class="header-table">
    <tr>
        <td style="width:15%; text-align:center;">
            @if($logoBase64)
                <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}"
                     style="max-height:70px; max-width:120px;">
            @endif
        </td>
        <td style="width:55%; padding-left:10px;">
            <p class="empresa-nombre">{{ strtoupper($empresa->nombre ?? 'EMPRESA') }}</p>
            <p><strong>RUC:</strong> {{ $empresa->ruc ?? '' }}</p>
            <p><strong>Dirección:</strong> {{ $empresa->direccion ?? '' }}</p>
            <p><strong>Teléfono:</strong> {{ $empresa->telefono ?? '' }}</p>
            <p><strong>Correo:</strong> {{ $empresa->correo ?? '' }}</p>
        </td>
        <td style="width:30%; text-align:right; vertical-align:top;">
            <p style="font-size:10px; color:#555;">Fecha de emisión:</p>
            <p><strong>{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</strong></p>
        </td>
    </tr>
</table>

{{-- TÍTULO --}}
<div class="reporte-titulo">
    REPORTE DE CUOTAS PENDIENTES
</div>

{{-- TABLA --}}
@php
    $totalMonto = 0;
    $totalSaldo = 0;
@endphp

<table class="tabla-datos">
    <thead>
        <tr>
            <th class="text-center">Documento</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th class="text-center">Nro Cuota</th>
            <th class="text-right">Monto</th>
            <th class="text-right">Saldo</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Fecha Vencimiento</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $item)
            @php
                $totalMonto += $item->monto;
                $totalSaldo += $item->saldo;
            @endphp
            <tr>
                <td class="text-center">{{ $item->ci }}</td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->apellido }}</td>
                <td class="text-center">{{ $item->numero_cuota }}</td>
                <td class="text-right">{{ number_format($item->monto, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->saldo, 0, ',', '.') }}</td>
                <td class="text-center">{{ $item->estado }}</td>
                <td class="text-center">{{ $item->fecha_vencimiento }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right"><strong>Total General</strong></td>
            <td class="text-right"><strong>{{ number_format($totalMonto, 0, ',', '.') }}</strong></td>
            <td class="text-right"><strong>{{ number_format($totalSaldo, 0, ',', '.') }}</strong></td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>

<div class="footer">
    Documento generado automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    — {{ $empresa->nombre ?? '' }}
</div>

</body>
</html>
