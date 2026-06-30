<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra #{{ $compra->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }

        p { margin: 2px 0; }

        /* Encabezado empresa */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .header-table td { vertical-align: middle; }
        .empresa-nombre { font-size: 15px; font-weight: bold; margin: 0 0 3px 0; }

        /* Título del reporte */
        .reporte-titulo {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            border: 1px solid #000;
            padding: 5px;
            margin-bottom: 10px;
        }

        /* Sección de datos */
        .seccion {
            border: 1px solid #ccc;
            padding: 8px 10px;
            margin-bottom: 10px;
        }
        .seccion h4 {
            margin: 0 0 6px 0;
            font-size: 11px;
            text-transform: uppercase;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        .datos-tabla { width: 100%; border-collapse: collapse; }
        .datos-tabla td { padding: 3px 4px; }

        /* Total destacado */
        .total-box {
            text-align: right;
            font-weight: bold;
            font-size: 12px;
            margin-top: 6px;
        }

        /* Tabla de detalles */
        .tabla-detalles {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .tabla-detalles th {
            background-color: #343a40;
            color: #fff;
            padding: 5px;
            border: 1px solid #000;
            font-size: 10px;
        }
        .tabla-detalles td {
            border: 1px solid #ccc;
            padding: 4px 5px;
            font-size: 10px;
        }
        .tabla-detalles tr:nth-child(even) td { background-color: #f9f9f9; }
        .text-right  { text-align: right; }
        .text-center { text-align: center; }

        /* Totales finales */
        .totales-finales {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        .totales-finales td {
            padding: 4px 6px;
            font-size: 11px;
        }

        .footer {
            font-size: 9px;
            text-align: center;
            color: #888;
            margin-top: 20px;
        }

        .marca-agua {
            position: fixed;
            top: 40%;
            left: 10%;
            font-size: 80px;
            color: rgba(200, 0, 0, 0.15);
            transform: rotate(-30deg);
            z-index: 0;
            pointer-events: none;
        }

        .badge-anulado {
            background-color: #f8d7da;
            color: #721c24;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: bold;
        }
        .badge-activo {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: bold;
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

@if($compra->estado === 'Anulado')
    <div class="marca-agua">ANULADO</div>
@endif

{{-- ENCABEZADO EMPRESA --}}
<table class="header-table">
    <tr>
        <td style="width:15%; text-align:center;">
            @if($logoBase64)
                <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}"
                     style="max-height:70px; max-width:110px;">
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
    FICHA DE COMPRA
</div>

{{-- DATOS DE LA COMPRA --}}
<div class="seccion">
    <h4>Datos de la Compra</h4>
    <table class="datos-tabla">
        <tr>
            <td><strong>N° Compra:</strong> #{{ $compra->id }}</td>
            <td><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
            <td>
                <strong>Estado:</strong>
                @if($compra->estado === 'Anulado')
                    <span class="badge-anulado">{{ $compra->estado }}</span>
                @else
                    <span class="badge-activo">{{ $compra->estado }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Tipo Comprobante:</strong> {{ $compra->tipo_comprobante }}</td>
            <td><strong>N° Comprobante:</strong> {{ $compra->numero_comprobante }}</td>
            <td><strong>IVA:</strong> {{ $compra->iva }}%</td>
        </tr>
    </table>
</div>

{{-- DATOS DEL PROVEEDOR --}}
<div class="seccion">
    <h4>Proveedor</h4>
    @if($proveedor)
    <table class="datos-tabla">
        <tr>
            <td><strong>Empresa:</strong> {{ $proveedor->compania ?? '—' }}</td>
            <td><strong>Nombre:</strong> {{ $proveedor->nombre }} {{ $proveedor->apellido }}</td>
            <td><strong>RUC / CI:</strong> {{ $proveedor->ci ?? '—' }}</td>
        </tr>
        <tr>
            <td><strong>Teléfono:</strong> {{ $proveedor->telefono ?? '—' }}</td>
            <td><strong>Correo:</strong> {{ $proveedor->correo ?? '—' }}</td>
            <td><strong>Dirección:</strong> {{ $proveedor->direccion ?? '—' }}</td>
        </tr>
    </table>
    @else
        <p style="color:#999;">Sin proveedor registrado.</p>
    @endif
</div>

{{-- DETALLE DE PRODUCTOS --}}
<div class="seccion">
    <h4>Detalle de Productos</h4>
    <table class="tabla-detalles">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-right">Precio Unitario</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $index => $detalle)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $detalle->producto_nombre }}</td>
                    <td class="text-center">{{ number_format($detalle->cantidad) }}</td>
                    <td class="text-right">Gs. {{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                    <td class="text-right">Gs. {{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totales-finales">
        <tr>
            <td style="width:70%;"></td>
            <td style="text-align:right;"><strong>TOTAL GENERAL:</strong></td>
            <td style="text-align:right; font-weight:bold; font-size:13px; width:20%;">
                Gs. {{ number_format($compra->total, 0, ',', '.') }}
            </td>
        </tr>
    </table>
</div>

<div class="footer">
    Documento generado automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    — {{ $empresa->nombre ?? '' }}
</div>

</body>
</html>
