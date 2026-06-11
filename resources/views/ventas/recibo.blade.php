<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo - {{ $venta->numero_comprobante }}</title>
    <style>
    @page {
        size: 80mm auto; /* Ancho 80mm, largo dinámico */
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
    color: rgba(255, 0, 0, 0.2); /* Rojo con transparencia */
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
    @if($venta->estado === 'Anulado')
    <div class="watermark">ANULADO</div>
@endif
    <div class="container">
        <div class="header">
             <h1>RECIBO</h1>
            <h1>RUC:{{ $empresa->ruc }}</h1>
            <h1>{{ $empresa->nombre }}</h1>
            <p>Comprobante N°: {{ $venta->numero_comprobante }}</p>
            <p>Fecha: {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</p>
            <p>Forma de pago: {{ $venta->forma_pago }}</p>
            <p>Condicion: {{ $venta->condicion_venta }}</p>
        </div>

        <div class="section-title">Cliente</div>
        <div class="info">
            <p><strong>{{ $cliente->nombre }} {{ $cliente->apellido }}</strong></p>
            <p>CI/RUC: {{ $cliente->ci }}</p>
            <p>Telefono: {{ $cliente->telefono }}</p>
            <p>Correo: {{ $cliente->correo }}</p>
            <p>Dirección: {{ $cliente->direccion }}</p>
        </div>

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
                <tr>
                    <td>{{ $detalle->nombre_producto }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 0) }}</td>
                    <td>{{ number_format($detalle->subtotal, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <p>Total a pagar: {{ number_format($venta->total, 0) }} Gs</p>
        </div>
        <div class="observacion">

            <strong>Forma de pago:</strong>  {{ $venta->forma_pago }}<br>
           @php
                $iva = 0;

                if ($venta->iva == 10) {
                    $iva = round($venta->total / 11); // IVA 10% incluido
                } elseif ($venta->iva == 5) {
                    $iva = round($venta->total / 21); // IVA 5% incluido
                } elseif (strtolower($venta->iva) == 'exenta') {
                    $iva = 0; // Exento de IVA
                }
            @endphp
            <p><strong>IVA:</strong> {{ number_format($iva, 0) }}</p>
        </div>
         <div class="observacion">
            <strong>Cajero:</strong>  {{ $venta->id_usuario }}<br>
        </div>
        @if($venta->observacion)
                <div class="observacion">
                    <strong>Obs.:</strong> {{ $venta->observacion }} <br>
                    <em>Este recibo no es un comprobante legal.</em>
                </div>
        @endif
         <div class="observacion">
            <br>
                    <strong>Firma:____________________</strong>
            <br>
                </div>
        <div class="footer">
            ¡Gracias por su compra!<br>
            Este recibo es válido como comprobante de pago.
        </div>
    </div>
</body>
</html>
