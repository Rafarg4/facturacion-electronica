<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Nro: {{ $venta->numero_comprobante }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .tabla-detalles {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tabla-detalles th, .tabla-detalles td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 40px;
        }

        p { margin: 2px 0; }
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
@endphp

{{-- ===== ENCABEZADO ===== --}}
<div style="border: 1px solid #000; padding: 10px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            {{-- Logo --}}
            <td style="width: 18%; vertical-align: middle; text-align: center;">
                @if($logoBase64)
                    <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}"
                         style="max-height: 80px; max-width: 130px;">
                @endif
            </td>

            {{-- Datos empresa --}}
            <td style="width: 52%; vertical-align: top; padding-left: 8px;">
                <p style="font-size: 15px; font-weight: bold; margin: 0 0 4px 0;">
                    {{ strtoupper($empresa->nombre ?? 'EMPRESA') }}
                </p>
                <p><strong>RUC:</strong> {{ $empresa->ruc ?? '' }}</p>
                <p><strong>Dirección:</strong> {{ $empresa->direccion ?? '' }}</p>
                <p><strong>Teléfono:</strong> {{ $empresa->telefono ?? '' }}</p>
                <p><strong>Correo:</strong> {{ $empresa->correo ?? '' }}</p>
                <p>
                    <strong>Timbrado:</strong> {{ $empresa->timbrado ?? '' }}
                    @if(!empty($empresa->fecha_habilitacion))
                        - Vigencia: {{ \Carbon\Carbon::parse($empresa->fecha_habilitacion)->format('d/m/Y') }}
                    @endif
                </p>
            </td>

            {{-- Datos factura --}}
            <td style="width: 30%; vertical-align: top; text-align: right;">
                <p style="font-size: 16px; font-weight: bold; margin: 0 0 6px 0;">FACTURA</p>
                <p><strong>N°:</strong> {{ $venta->numero_comprobante }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</p>
                <p><strong>Condición:</strong> {{ ucfirst($venta->condicion_venta) }}</p>
            </td>
        </tr>
    </table>
</div>

{{-- ===== DATOS CLIENTE ===== --}}
<div style="border: 1px solid #000; padding: 10px; margin-top: 10px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
                <p><strong>CI/RUC:</strong> {{ $cliente->ci }}</p>
                <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                <p><strong>Correo:</strong> {{ $cliente->correo }}</p>
            </td>
        </tr>
    </table>
</div>

{{-- ===== TABLA DE DETALLES ===== --}}
<table class="tabla-detalles">
    <thead>
        <tr>
            <th style="text-align: right;">Cant.</th>
            <th>Descripción</th>
            <th style="text-align: right;">Precio Unit.</th>
            <th style="text-align: right;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detalles as $detalle)
            <tr>
                <td style="text-align: right;">{{ $detalle->cantidad }}</td>
                <td>{{ $detalle->nombre_producto ?? 'Producto ' . $detalle->id_producto }}</td>
                <td style="text-align: right;">{{ number_format($detalle->precio_unitario, 0) }}</td>
                <td style="text-align: right;">{{ number_format($detalle->subtotal, 0) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- ===== TOTALES E IVA ===== --}}
@php
    $iva5   = 0;
    $iva10  = 0;
    $exenta = 0;

    if ($venta->iva == 10) {
        $iva10 = round($venta->total / 11);
    } elseif ($venta->iva == 5) {
        $iva5 = round($venta->total / 21);
    } elseif (strtolower($venta->iva) === 'exenta') {
        $exenta = $venta->total;
    }
@endphp

<table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
    <tr>
        <th style="border: 1px solid #000; padding: 5px;">IVA 5%: {{ number_format($iva5, 0) }}</th>
        <th style="border: 1px solid #000; padding: 5px;">IVA 10%: {{ number_format($iva10, 0) }}</th>
        <th style="border: 1px solid #000; padding: 5px;">Exenta: {{ number_format($exenta, 0) }}</th>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse; margin-top: 8px;">
    <tr>
          <td style="border: 1px solid #000; padding: 5px; text-align: right; width: 70%;">
            <strong>Son:</strong> {{ $montoLetras }}
        </td>
        <td style="border: 1px solid #000; padding: 5px; text-align: right; width: 20%;">
            <strong>Total:</strong> {{ number_format($venta->total, 0) }}
        </td>
        @if(!empty($venta->total_gs) && intval($venta->total_gs) !== intval($venta->total))
        <td style="border: 1px solid #000; padding: 5px; text-align: right; width: 20%;">
            <strong>Total Gs.:</strong> Gs. {{ number_format($venta->total_gs, 0) }}
        </td>
        @endif
    </tr>
</table>

{{-- ===== CARD QR / VALIDACIÓN ELECTRÓNICA ===== --}}
<div style="border: 1px solid #000; padding: 10px; margin-top: 20px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            {{-- QR real, generado por Koape a partir del documento aprobado por SIFEN --}}
            <td style="width: 22%; vertical-align: middle; text-align: center;">
                @if(!empty($venta->qr_base64))
                    <img src="data:image/png;base64,{{ $venta->qr_base64 }}"
                         style="width: 100px; height: 100px;">
                @else
                    <div style="width: 100px; height: 100px; border: 1px solid #000; text-align: center; line-height: 100px; font-size: 10px; margin: 0 auto;">
                        QR no generado
                    </div>
                @endif
            </td>

            {{-- Texto de validación --}}
            <td style="width: 78%; vertical-align: top; padding-left: 10px; font-size: 11px;">
                <p style="margin: 0 0 4px 0;">
                    Consulte la validez de esta Factura Electrónica con el número de CDC impreso abajo en
                </p>
                <p style="margin: 0 0 4px 0; color: #0000CC;">
                    https://ekuatia.set.gov.py/consultas
                </p>
                @if(!empty($venta->cdc))
                <p style="margin: 0 0 8px 0;">
                    <strong>CDC:</strong> {{ $venta->cdc }}
                </p>
                @endif
                <p style="margin: 0 0 4px 0; font-weight: bold;">
                    ESTE DOCUMENTO ES UNA REPRESENTACIÓN GRÁFICA DE UN DOCUMENTO ELECTRÓNICO (XML)
                </p>
                <p style="margin: 0 0 4px 0; font-weight: bold;">
                    Información de interés del facturador electrónico emisor
                </p>
                <p style="margin: 0;">
                    Si su documento electrónico presenta algún error, podrá solicitar la modificación
                    dentro de las 72 horas siguientes de la emisión de este comprobante.
                </p>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
