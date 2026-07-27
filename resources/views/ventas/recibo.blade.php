<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo - {{ $venta->numero_comprobante }}</title>
    <style>
    @page {
        size: 80mm auto;
        margin: 5mm;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #000;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .watermark {
        position: absolute;
        top: 40%;
        left: 20%;
        font-size: 40px;
        color: rgba(255, 0, 0, 0.2);
        transform: rotate(-30deg);
        z-index: 0;
        pointer-events: none;
        width: 100%;
        text-align: center;
    }

    .container {
        width: 100%;
        padding: 5px;
    }

    .header {
        text-align: center;
        margin-bottom: 10px;
    }

    .header img {
        max-height: 60px;
        max-width: 120px;
        display: block;
        margin: 0 auto 4px auto;
    }

    .header h1 {
        margin: 0;
        font-size: 16px;
    }

    .header p {
        margin: 2px 0;
        font-size: 11px;
    }

    .section-title {
        font-weight: bold;
        border-top: 1px dashed #000;
        border-bottom: 1px dashed #000;
        padding: 4px 0;
        margin-top: 8px;
        text-align: center;
        font-size: 12px;
    }

    .info p {
        margin: 2px 0;
        font-size: 11px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        margin-top: 5px;
    }

    table th, table td {
        text-align: left;
        padding: 2px;
    }

    .totals {
        margin-top: 10px;
        text-align: right;
        font-size: 12px;
        font-weight: bold;
    }

    .observacion {
        font-size: 10px;
        margin-top: 10px;
        border-top: 1px dashed #000;
        padding-top: 5px;
    }

    .qr-section {
        margin-top: 10px;
        border-top: 1px dashed #000;
        padding-top: 8px;
        text-align: center;
    }

    .qr-section img {
        width: 80px;
        height: 80px;
    }

    .qr-section p {
        font-size: 9px;
        margin: 3px 0;
    }

    .footer {
        text-align: center;
        font-size: 10px;
        margin-top: 10px;
        border-top: 1px dashed #000;
        padding-top: 5px;
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
        if ($n >= 1000000000) { $b = intdiv($n, 1000000000); $texto .= ($b === 1 ? 'mil millones' : $numeroALetras($b) . ' mil millones'); $n %= 1000000000; if ($n > 0) $texto .= ' '; }
        if ($n >= 1000000)    { $m = intdiv($n, 1000000);    $texto .= ($m === 1 ? 'un millón'    : $numeroALetras($m) . ' millones');    $n %= 1000000;    if ($n > 0) $texto .= ' '; }
        if ($n >= 1000)       { $k = intdiv($n, 1000);       $texto .= ($k === 1 ? 'mil'           : $numeroALetras($k) . ' mil');         $n %= 1000;       if ($n > 0) $texto .= ' '; }
        if ($n >= 100)        { $texto .= $centenas[intdiv($n, 100)]; $n %= 100; if ($n > 0) $texto .= ' '; }
        if ($n > 0) {
            if ($n < 20)      { $texto .= $unidades[$n]; }
            elseif ($n < 30)  { $texto .= $veintes[$n - 20]; }
            else              { $u = $n % 10; $texto .= $decenas[intdiv($n, 10)]; if ($u > 0) $texto .= ' y ' . $unidades[$u]; }
        }
        return $texto;
    };

    $montoBase   = intval($venta->total_gs ?? $venta->total);
    $montoLetras = strtoupper($numeroALetras($montoBase)) . ' GUARANÍES';

    // Equivalencias en otras monedas según la tabla de cotizaciones
    $nombresMoneda = [
        'PYG' => 'Guaraníes',
        'USD' => 'Dólares',
        'BRL' => 'Real',
        'ARS' => 'Pesos',
    ];
    $parseTasa = function ($valor) {
        return floatval(str_replace(',', '.', str_replace('.', '', (string) $valor)));
    };

    $totalGs = floatval($venta->total_gs ?? $venta->total);
    $tasaPyg = isset($cotizaciones['PYG']) ? $parseTasa($cotizaciones['PYG']->compra) : 0;

    // Los productos se cargan en su propia moneda (normalmente USD); el detalle
    // se convierte a Guaraníes usando la cotización vigente, igual que el total.
    $convertirAGs = function ($monto, $monedaProducto) use ($cotizaciones, $parseTasa, $tasaPyg) {
        $moneda = $monedaProducto ?: 'PYG';
        if ($moneda === 'PYG' || $tasaPyg <= 0 || !isset($cotizaciones[$moneda])) {
            return (float) $monto;
        }
        $tasaMoneda = $parseTasa($cotizaciones[$moneda]->compra);
        return $tasaMoneda > 0 ? $monto * ($tasaPyg / $tasaMoneda) : (float) $monto;
    };

    $iva = 0;
    if ($venta->iva == 10)     { $iva = round($totalGs / 11); }
    elseif ($venta->iva == 5)  { $iva = round($totalGs / 21); }

    $equivalencias = [];
    if (!empty($cotizaciones) && $tasaPyg > 0) {
        foreach ($cotizaciones as $moneda => $cot) {
            if ($moneda === 'PYG') continue;
            $tasaMoneda = $parseTasa($cot->compra);
            if ($tasaMoneda <= 0) continue;
            $equivalencias[$moneda] = $totalGs * ($tasaMoneda / $tasaPyg);
        }
    }
@endphp

@if($venta->estado === 'Anulado')
    <div class="watermark">ANULADO</div>
@endif

<div class="container">

    {{-- ENCABEZADO --}}
    <div class="header">
        @if($logoBase64)
            <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}">
        @endif
        <h1>RECIBO</h1>
        <h1>RUC: {{ $empresa->ruc }}</h1>
        <h1>{{ strtoupper($empresa->nombre) }}</h1>
        @if(!empty($empresa->direccion))
            <p>{{ $empresa->direccion }}</p>
        @endif
        @if(!empty($empresa->telefono))
            <p>Tel: {{ $empresa->telefono }}</p>
        @endif
        @if(!empty($empresa->correo))
            <p>{{ $empresa->correo }}</p>
        @endif
        @if(!empty($empresa->timbrado))
            <p>Timbrado: {{ $empresa->timbrado }}
            @if(!empty($empresa->fecha_habilitacion))
                — Vigencia: {{ \Carbon\Carbon::parse($empresa->fecha_habilitacion)->format('d/m/Y') }}
            @endif
            </p>
        @endif
        <p>Comprobante N°: {{ $venta->numero_comprobante }}</p>
        <p>Fecha: {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</p>
        <p>Forma de pago: {{ $venta->forma_pago }}</p>
        <p>Condición: {{ $venta->condicion_venta }}</p>
        <p>Moneda: {{ $venta->moneda ?: 'PYG' }}</p>
        @if(($venta->moneda ?: 'PYG') !== 'PYG' && !empty($venta->tipo_cambio))
        <p>Tipo de cambio: {{ number_format($venta->tipo_cambio, 0, ',', '.') }}</p>
        @endif
    </div>

    {{-- CLIENTE --}}
    <div class="section-title">Cliente</div>
    <div class="info">
        <p><strong>{{ $cliente->nombre }} {{ $cliente->apellido }}</strong></p>
        <p>CI/RUC: {{ $cliente->ci }}</p>
        <p>Teléfono: {{ $cliente->telefono }}</p>
        <p>Correo: {{ $cliente->correo }}</p>
        <p>Dirección: {{ $cliente->direccion }}</p>
    </div>

    {{-- DETALLES --}}
    <div class="section-title">Detalles</div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cant</th>
                <th>Precio</th>
                <th>Subt</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalles as $detalle)
            @php
                $precioGs   = $convertirAGs($detalle->precio_unitario, $detalle->tipo_moneda ?? null);
                $subtotalGs = $convertirAGs($detalle->subtotal, $detalle->tipo_moneda ?? null);
            @endphp
            <tr>
                <td>{{ $detalle->nombre_producto }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>{{ number_format($precioGs, 0) }}</td>
                <td>{{ number_format($subtotalGs, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="totals">
        <p>Total a pagar: {{ number_format($venta->total_gs, 0) }} Gs</p>
    </div>

    {{-- MONTO EN LETRAS --}}
    <div class="observacion">
        <strong>Son:</strong> {{ $montoLetras }}
    </div>

    {{-- IVA Y CAJERO --}}
    <div class="observacion">
        <strong>IVA ({{ $venta->iva }}%):</strong> {{ number_format($iva, 0) }} Gs<br>
        <strong>Cajero:</strong> {{ $venta->id_usuario }}
    </div>

    {{-- OBSERVACIÓN --}}
    @if($venta->observacion)
        <div class="observacion">
            <strong>Obs.:</strong> {{ $venta->observacion }}<br>
            <em>Este recibo no es un comprobante legal.</em>
        </div>
    @endif

    {{-- EQUIVALENCIAS EN OTRAS MONEDAS --}}
    @if(!empty($equivalencias))
        <div class="observacion">
            <strong>Equivalencias (referencial):</strong>
            <table>
                <tr>
                    <td>Guaraníes (PYG)</td>
                    <td style="text-align:right;">{{ number_format($totalGs, 0, ',', '.') }}</td>
                </tr>
                @foreach($equivalencias as $moneda => $monto)
                <tr>
                    <td>{{ $nombresMoneda[$moneda] ?? $moneda }} ({{ $moneda }})</td>
                    <td style="text-align:right;">{{ number_format($monto, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    @endif

    {{-- FIRMA --}}
    <div class="observacion">
        <br>
        <strong>Firma: ____________________</strong>
        <br>
    </div>

    {{-- QR / VALIDACIÓN ELECTRÓNICA: solo si es Factura y se emitió FE --}}
    @if($venta->tipo_comprobante == 'Factura' && $venta->enviar_factura == 1)
    <div class="qr-section">
        @if(!empty($venta->qr_base64))
            <img src="data:image/png;base64,{{ $venta->qr_base64 }}">
        @else
            <div style="width: 80px; height: 80px; border: 1px solid #000; margin: 0 auto; text-align: center; line-height: 80px; font-size: 8px;">
                QR no generado
            </div>
        @endif
        <p>Consulte la validez de este comprobante en:</p>
        <p style="color: #0000CC;">https://ekuatia.set.gov.py/consultas</p>
        @if(!empty($venta->cdc))
            <p><strong>CDC:</strong> {{ $venta->cdc }}</p>
        @endif
    </div>
    @endif

    <div class="footer">
        ¡Gracias por su compra!<br>
        Este recibo es válido como comprobante de pago.
    </div>

</div>
</body>
</html>
