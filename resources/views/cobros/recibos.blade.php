<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo - {{ $cobros->comprobante_cobro }}</title>
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
    @if($cobros->estado === 'Anulado')
        <div class="watermark">ANULADO</div>
    @endif
    <div class="container">
        <div class="header">
              <h1>RECIBO</h1>
            <h1>RUC:{{ $empresa->ruc }}</h1>
            <h1>{{ $empresa->nombre }}</h1>
            <p>Comprobante N°: {{ $cobros->comprobante_cobro }}</p>
            <p>Fecha: {{ \Carbon\Carbon::parse($cobros->fecha_cobro)->format('d/m/Y') }}</p>
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
                    <th>Nro cuota</th>
                    <th>Monto</th>
                    <th>Saldo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->nro_cuota }}</td>
                    <td>{{ number_format($detalle->monto,0) }}</td>
                    <td>{{ number_format($detalle->saldo, 0) }}</td>
                    <td>{{ $detalle->estado}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <p>Total pagado: {{ number_format($cobros->total_cobro, 0) }} Gs</p>
        </div>
         <div class="observacion">
            <strong>Pago por venta:</strong> Comprobante N°: {{ $cobros->comprobante_venta }} - Total: {{ number_format($cobros->total_venta) }}<br>
             <strong>Cajero:</strong>  {{ $cobros->name }}<br>
        </div>
        @if($cobros->observacion)
                <div class="observacion">
                    <strong>Obs.:</strong> {{ $cobros->observacion }} <br>
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
