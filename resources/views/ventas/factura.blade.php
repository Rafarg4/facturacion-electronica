<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Nro: {{ $venta->numero_comprobante }}</title>
    <style>
        @page {
            size: A4;
            margin: 12mm 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }

        p { margin: 1px 0; }

        .caja {
            border: 1px solid #000;
        }

        .titulo-kude {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin: 0 0 6px 0;
        }

        .tabla-detalles {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        .tabla-detalles th, .tabla-detalles td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        .tabla-totales {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
            font-size: 10.5px;
        }

        .tabla-totales td, .tabla-totales th {
            border: 1px solid #000;
            padding: 4px;
        }
    </style>
</head>
<body>

@php
    // Logo en base64 para compatibilidad con Dompdf
    $logoBase64 = null;
    $logoExt    = 'png';
    if (!empty($empresa->logo)) {
        $logoPath = public_path('imagenes/' . $empresa->logo);
        if (file_exists($logoPath)) {
            $logoBase64 = base64_encode(file_get_contents($logoPath));
            $logoExt    = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
        }
    }

    // Conversión de número a letras en español
    $numeroALetras = function(int $n) use (&$numeroALetras): string {
        if ($n === 0) return 'cero';

        $unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve',
                     'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete',
                     'dieciocho', 'diecinueve'];
        $decenas  = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta',
                     'sesenta', 'setenta', 'ochenta', 'noventa'];
        $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos',
                     'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
        $veintes  = ['veinte', 'veintiuno', 'veintidós', 'veintitrés', 'veinticuatro',
                     'veinticinco', 'veintiséis', 'veintisiete', 'veintiocho', 'veintinueve'];

        if ($n === 100) return 'cien';

        $texto = '';

        if ($n >= 1000000000) {
            $b = intdiv($n, 1000000000);
            $texto .= ($b === 1 ? 'mil millones' : $numeroALetras($b) . ' mil millones');
            $n %= 1000000000;
            if ($n > 0) $texto .= ' ';
        }
        if ($n >= 1000000) {
            $m = intdiv($n, 1000000);
            $texto .= ($m === 1 ? 'un millón' : $numeroALetras($m) . ' millones');
            $n %= 1000000;
            if ($n > 0) $texto .= ' ';
        }
        if ($n >= 1000) {
            $k = intdiv($n, 1000);
            $texto .= ($k === 1 ? 'mil' : $numeroALetras($k) . ' mil');
            $n %= 1000;
            if ($n > 0) $texto .= ' ';
        }
        if ($n >= 100) {
            $texto .= $centenas[intdiv($n, 100)];
            $n %= 100;
            if ($n > 0) $texto .= ' ';
        }
        if ($n > 0) {
            if ($n < 20) {
                $texto .= $unidades[$n];
            } elseif ($n < 30) {
                $texto .= $veintes[$n - 20];
            } else {
                $u = $n % 10;
                $texto .= $decenas[intdiv($n, 10)];
                if ($u > 0) $texto .= ' y ' . $unidades[$u];
            }
        }

        return $texto;
    };

    $montoBase   = intval($venta->total_gs ?? $venta->total);
    $montoLetras = strtoupper($numeroALetras($montoBase)) . ' GUARANÍES';

    $esUsd      = ($venta->moneda ?: 'PYG') === 'USD';
    $tipoCambio = $esUsd ? (float) $venta->tipo_cambio : 1;

    // Desglose por tasa de IVA: el sistema hoy define el IVA a nivel de toda la venta
    // (no por ítem), así que todo el subtotal cae en la columna de esa única tasa.
    $colExenta = 0;
    $col5      = 0;
    $col10     = 0;
    if ($venta->iva == 10) {
        $col10 = $venta->total;
    } elseif ($venta->iva == 5) {
        $col5 = $venta->total;
    } else {
        $colExenta = $venta->total;
    }

    $iva5   = $venta->iva == 5  ? round($venta->total / 21) : 0;
    $iva10  = $venta->iva == 10 ? round($venta->total / 11) : 0;
    $ivaTotal = $iva5 + $iva10;
@endphp

<p class="titulo-kude">KUDE DE FACTURA ELECTRÓNICA</p>

{{-- ===== ENCABEZADO: LOGO + DATOS EMPRESA | RUC/TIMBRADO + Nº FACTURA ===== --}}
<table class="caja" style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 60%; vertical-align: middle; padding: 6px; border-right: 1px solid #000;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 28%; vertical-align: middle; text-align: center;">
                        @if($logoBase64)
                            <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}"
                                 style="max-height: 70px; max-width: 110px;">
                        @endif
                    </td>
                    <td style="width: 72%; vertical-align: top; padding-left: 6px;">
                        <p style="font-size: 14px; font-weight: bold;">{{ strtoupper($empresa->nombre ?? 'EMPRESA') }}</p>
                        <p>{{ $empresa->direccion ?? '' }}</p>
                        <p>Tel: {{ $empresa->telefono ?? '' }}</p>
                        <p>Email: {{ $empresa->correo ?? '' }}</p>
                        @if(!empty($empresa->descripcion))
                        <p>{{ $empresa->descripcion }}</p>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 40%; vertical-align: top; padding: 6px;">
            <p style="font-size: 13px;"><strong>RUC:</strong> {{ $empresa->ruc ?? '' }}</p>
            @if(!empty($empresa->fecha_inicio))
            <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($empresa->fecha_inicio)->format('d-m-Y') }}</p>
            @endif
            <p><strong>Timbrado:</strong> {{ $empresa->timbrado ?? '' }}</p>
            <p style="font-size: 13px; font-weight: bold; margin-top: 6px;">FACTURA</p>
            <p>{{ config('services.koape.establecimiento') }}-{{ config('services.koape.punto_expedicion') }}-{{ str_pad((string) $venta->numero_comprobante, 7, '0', STR_PAD_LEFT) }}</p>
        </td>
    </tr>
</table>

{{-- ===== DATOS DE LA VENTA | DATOS DEL CLIENTE ===== --}}
<table class="caja" style="width: 100%; border-collapse: collapse; margin-top: 6px;">
    <tr>
        <td style="width: 50%; vertical-align: top; padding: 6px; border-right: 1px solid #000;">
            <p><strong>Fecha de emisión:</strong> {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d-m-Y H:i:s') }}</p>
            <p><strong>Condición de venta:</strong> {{ strtoupper($venta->condicion_venta) }}</p>
            <p><strong>Moneda:</strong> {{ $venta->moneda ?: 'PYG' }}</p>
            @if($esUsd)
            <p><strong>Tipo de Cambio:</strong> {{ number_format($venta->tipo_cambio, 0, ',', '.') }}</p>
            @endif
            <p><strong>Tipo Transacción:</strong> Venta de Mercadería</p>
        </td>
        <td style="width: 50%; vertical-align: top; padding: 6px;">
            <p><strong>RUC:</strong> {{ $cliente->ci }}</p>
            <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
            <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
            <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
            <p><strong>E-Mail:</strong> {{ $cliente->correo }}</p>
        </td>
    </tr>
</table>

{{-- ===== TABLA DE DETALLES ===== --}}
<table class="tabla-detalles">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Descripción</th>
            <th>Unidad de Medida</th>
            <th style="text-align: right;">Cantidad</th>
            <th style="text-align: right;">Precio Unitario</th>
            <th style="text-align: right;">Desc.</th>
            <th colspan="3" style="text-align: center;">VALOR DE VENTA{{ $esUsd ? ' (USD)' : '' }}</th>
        </tr>
        <tr>
            <th colspan="6"></th>
            <th style="text-align: right;">Exentas</th>
            <th style="text-align: right;">5%</th>
            <th style="text-align: right;">10%</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detalles as $detalle)
            @php
                $filaExenta = 0; $fila5 = 0; $fila10 = 0;
                if ($venta->iva == 10) { $fila10 = $detalle->subtotal; }
                elseif ($venta->iva == 5) { $fila5 = $detalle->subtotal; }
                else { $filaExenta = $detalle->subtotal; }
            @endphp
            <tr>
                <td>{{ $detalle->codigo }}</td>
                <td>{{ $detalle->nombre_producto ?? 'Producto ' . $detalle->id_producto }}</td>
                <td>Un</td>
                <td style="text-align: right;">{{ $detalle->cantidad }}</td>
                <td style="text-align: right;">{{ number_format($detalle->precio_unitario, 0) }}</td>
                <td style="text-align: right;">0</td>
                <td style="text-align: right;">{{ $filaExenta ? number_format($filaExenta, 0) : '0' }}</td>
                <td style="text-align: right;">{{ $fila5 ? number_format($fila5, 0) : '0' }}</td>
                <td style="text-align: right;">{{ $fila10 ? number_format($fila10, 0) : '0' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- ===== SUB TOTALES / TOTALES ===== --}}
<table class="tabla-totales">
    <tr>
        <td style="text-align: left;"><strong>SUB TOTALES</strong></td>
        <td style="width: 15%; text-align: right;">{{ number_format($colExenta, 0) }}</td>
        <td style="width: 15%; text-align: right;">{{ number_format($col5, 0) }}</td>
        <td style="width: 15%; text-align: right;">{{ number_format($col10, 0) }}</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: left;"><strong>TOTAL DE LA OPERACIÓN{{ $esUsd ? ' (USD)' : '' }}:</strong></td>
        <td style="text-align: right;"><strong>{{ number_format($venta->total, 0) }}</strong></td>
    </tr>
    @if($esUsd || (!empty($venta->total_gs) && intval($venta->total_gs) !== intval($venta->total)))
    <tr>
        <td colspan="3" style="text-align: left;"><strong>TOTAL EN GUARANÍES:</strong></td>
        <td style="text-align: right;"><strong>{{ number_format($venta->total_gs, 0) }}</strong></td>
    </tr>
    @endif
    <tr>
        <td style="text-align: left;"><strong>LIQUIDACIÓN DEL IVA</strong></td>
        <td style="text-align: right;">(5%) {{ number_format($iva5, 0) }}</td>
        <td style="text-align: right;">(10%) {{ number_format($iva10, 0) }}</td>
        <td style="text-align: right;"><strong>TOTAL IVA: {{ number_format($ivaTotal, 0) }}</strong></td>
    </tr>
</table>

<p style="margin-top: 6px;"><strong>Son:</strong> {{ $montoLetras }}</p>

{{-- ===== FOOTER: USUARIO | QR / VALIDACIÓN ELECTRÓNICA ===== --}}
<p style="margin-top: 10px;"><strong>Usuario:</strong> {{ $venta->id_usuario }}</p>

<table class="caja" style="width: 100%; border-collapse: collapse; margin-top: 4px;">
    <tr>
        {{-- QR real, generado por Koape a partir del documento aprobado por SIFEN --}}
        <td style="width: 22%; vertical-align: middle; text-align: center; padding: 8px;">
            @if(!empty($venta->qr_base64))
                <img src="data:image/png;base64,{{ $venta->qr_base64 }}"
                     style="width: 90px; height: 90px;">
            @else
                <div style="width: 90px; height: 90px; border: 1px solid #000; text-align: center; line-height: 90px; font-size: 9px; margin: 0 auto;">
                    QR no generado
                </div>
            @endif
        </td>

        {{-- Texto de validación --}}
        <td style="width: 78%; vertical-align: top; padding: 8px; font-size: 10.5px;">
            <p>Consulte la validez de esta Factura Electrónica con el número de CDC impreso abajo en</p>
            <p style="color: #0000CC;">https://ekuatia.set.gov.py/consultas/</p>
            @if(!empty($venta->cdc))
            <p style="margin: 6px 0;"><strong>CDC:</strong> {{ $venta->cdc }}</p>
            @endif
            <p style="font-weight: bold;">ESTE DOCUMENTO ES UNA REPRESENTACIÓN GRÁFICA DE UN DOCUMENTO ELECTRÓNICO (XML)</p>
        </td>
    </tr>
</table>

</body>
</html>
