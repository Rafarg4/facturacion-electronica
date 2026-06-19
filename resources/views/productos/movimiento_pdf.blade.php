<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimiento de Productos</title>
    <style>
        @page { size: A4 landscape; margin: 12mm 10mm; }
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
        .filtros { font-size: 10px; margin-bottom: 8px; }

        .resumen-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .resumen-table td {
            border: 1px solid #000;
            padding: 5px 10px;
            text-align: center;
            font-size: 12px;
        }
        .resumen-table .label { font-size: 10px; color: #555; }
        .resumen-table .valor { font-size: 15px; font-weight: bold; }
        .bg-entrada { background-color: #d4edda; }
        .bg-salida  { background-color: #f8d7da; }
        .bg-neto    { background-color: #d1ecf1; }
        .bg-total   { background-color: #fff3cd; }

        .tabla-mov { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .tabla-mov th {
            background-color: #343a40;
            color: #fff;
            padding: 5px;
            border: 1px solid #000;
            font-size: 10px;
        }
        .tabla-mov td {
            border: 1px solid #ccc;
            padding: 4px 5px;
            font-size: 10px;
        }
        .tabla-mov tr:nth-child(even) td { background-color: #f9f9f9; }

        .badge-entrada {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        .badge-salida {
            background-color: #f8d7da;
            color: #721c24;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
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
    $totalEntradas = $movimientos->where('tipo','Entrada')->sum('cantidad');
    $totalSalidas  = $movimientos->where('tipo','Salida')->sum('cantidad');
    $neto          = $totalEntradas - $totalSalidas;
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
    REPORTE DE MOVIMIENTO DE PRODUCTOS (ENTRADAS / SALIDAS)
</div>

{{-- FILTROS APLICADOS --}}
<div class="filtros">
    <strong>Filtros:</strong>
    Producto: <strong>{{ $productoSeleccionado ? (($productoSeleccionado->codigo ? '[' . $productoSeleccionado->codigo . '] ' : '') . $productoSeleccionado->descripcion) : 'Todos' }}</strong>
    &nbsp;|&nbsp;
    Desde: <strong>{{ $fecha_desde ? \Carbon\Carbon::parse($fecha_desde)->format('d/m/Y') : '—' }}</strong>
    &nbsp;|&nbsp;
    Hasta: <strong>{{ $fecha_hasta ? \Carbon\Carbon::parse($fecha_hasta)->format('d/m/Y') : '—' }}</strong>
    &nbsp;|&nbsp;
    Total registros: <strong>{{ $movimientos->count() }}</strong>
</div>

{{-- RESUMEN --}}
<table class="resumen-table">
    <tr>
        <td class="bg-entrada">
            <div class="label">Total Entradas</div>
            <div class="valor">{{ number_format($totalEntradas) }}</div>
            <div class="label">unidades</div>
        </td>
        <td class="bg-salida">
            <div class="label">Total Salidas</div>
            <div class="valor">{{ number_format($totalSalidas) }}</div>
            <div class="label">unidades</div>
        </td>
        <td class="bg-neto">
            <div class="label">Neto (Entrada - Salida)</div>
            <div class="valor">{{ number_format($neto) }}</div>
            <div class="label">unidades</div>
        </td>
        <td class="bg-total">
            <div class="label">Registros</div>
            <div class="valor">{{ $movimientos->count() }}</div>
            <div class="label">movimientos</div>
        </td>
    </tr>
</table>

{{-- TABLA DE MOVIMIENTOS --}}
<table class="tabla-mov">
    <thead>
        <tr>
            <th class="text-center">Tipo</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th class="text-center">Cantidad</th>
            <th class="text-right">Precio Unit.</th>
            <th class="text-right">Subtotal</th>
            <th>Comprobante</th>
            <th>Cliente / Referencia</th>
        </tr>
    </thead>
    <tbody>
        @forelse($movimientos as $mov)
        <tr>
            <td class="text-center">
                @if($mov->tipo === 'Entrada')
                    <span class="badge-entrada">&#x2193; Entrada</span>
                @else
                    <span class="badge-salida">&#x2191; Salida</span>
                @endif
            </td>
            <td>{{ $mov->fecha }}</td>
            <td>{{ $mov->producto }}</td>
            <td class="text-center">{{ number_format($mov->cantidad) }}</td>
            <td class="text-right">{{ number_format($mov->precio_unitario) }}</td>
            <td class="text-right">{{ number_format($mov->subtotal) }}</td>
            <td>{{ $mov->comprobante }}</td>
            <td>{{ $mov->referencia }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center" style="padding:10px;">Sin movimientos registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Documento generado automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    — {{ $empresa->nombre ?? '' }}
</div>

</body>
</html>
