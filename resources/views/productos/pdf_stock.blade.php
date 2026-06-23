<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Stock</title>
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
            text-align: center;
        }
        .tabla-datos td {
            border: 1px solid #ccc;
            padding: 4px 5px;
            font-size: 10px;
        }
        .tabla-datos tr:nth-child(even) td { background-color: #f9f9f9; }

        .text-right  { text-align: right; }
        .text-center { text-align: center; }

        .footer { text-align: center; font-size: 9px; color: #888; margin-top: 15px; }

        .firmas { width: 100%; border-collapse: collapse; margin-top: 40px; }
        .firmas td { text-align: center; padding-top: 5px; }
        .firma-linea {
            width: 200px;
            border-top: 1px solid #000;
            margin: 0 auto;
            padding-top: 4px;
            font-size: 10px;
        }
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
            <p style="margin-top:4px; font-size:10px; color:#555;">Total productos:</p>
            <p><strong>{{ count($productos) }}</strong></p>
        </td>
    </tr>
</table>

{{-- TÍTULO --}}
<div class="reporte-titulo">
    REPORTE DE STOCK DE PRODUCTOS
</div>

{{-- TABLA --}}
<table class="tabla-datos">
    <thead>
        <tr>
            <th width="12%">Código</th>
            <th width="12%">N° Item</th>
            <th width="38%">Producto</th>
            <th width="18%">Rubro</th>
            <th width="10%">Stock</th>
            <th width="10%">Mínimo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
        <tr>
            <td class="text-center">{{ $producto->codigo }}</td>
            <td class="text-center">{{ $producto->num_item }}</td>
            <td>{{ strtoupper($producto->descripcion) }}</td>
            <td>{{ strtoupper($producto->id_rubro) }}</td>
            <td class="text-center">{{ number_format($producto->cantidad, 0, ',', '.') }}</td>
            <td class="text-center">{{ number_format($producto->cantidad_minima, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- FIRMAS --}}
<table class="firmas">
    <tr>
        <td width="50%">
            <div class="firma-linea">Responsable de Inventario</div>
        </td>
        <td width="50%">
            <div class="firma-linea">Verificado por</div>
        </td>
    </tr>
</table>

<div class="footer">
    Documento generado automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    — {{ $empresa->nombre ?? '' }}
</div>

</body>
</html>
