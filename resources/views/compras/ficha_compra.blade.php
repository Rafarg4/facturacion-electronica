<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra #{{ $compra->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .encabezado {
            border: 1px solid #000;
            padding: 10px;
            width: 100%;
            margin-bottom: 20px;
        }

        .encabezado h2 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .datos-compra {
            width: 100%;
        }

        .datos-compra td {
            padding: 4px;
        }

        .info-compra,
        .totales {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }

        .tabla-detalles {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        .marca-agua {
            position: fixed;
            top: 40%;
            left: 20%;
            font-size: 80px;
            color: rgba(200, 0, 0, 0.2);
            transform: rotate(-30deg);
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
 @if($compra->estado === 'Anulado')
        <div class="marca-agua">ANULADO</div>
    @endif
    <div class="encabezado">
        <h2>FICHA DE COMPRA</h2>
        <table class="datos-compra">
            <tr>
                <td><strong>ID de Compra:</strong> {{ $compra->id }}</td>
                <td><strong>Fecha de Compra:</strong> {{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
                <td><strong>Tipo Comprobante:</strong> {{ $compra->tipo_comprobante }}</td>
            </tr>
            <tr>
                <td><strong>N° Comprobante:</strong> {{ $compra->numero_comprobante }}</td>
                <td><strong>Forma de Pago:</strong> {{ $compra->forma_pago }}</td>
                <td><strong>Estado:</strong> {{ $compra->estado }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Observación:</strong> {{ $compra->observacion }}</td>
            </tr>
        </table>

        <hr>

        <h4>Detalle del Pedido</h4>
        <table class="datos-compra">
            <tr>
                <td><strong>ID Pedido:</strong> {{ $compra->pedido->id }}</td>
                <td><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($compra->pedido->fecha)->format('d/m/Y') }}</td>
                <td><strong>Estado:</strong> {{ $compra->pedido->estado }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Total Pedido:</strong> Gs. {{ number_format($compra->pedido->total, 0) }}</td>
            </tr>
        </table>

        <div class="info-compra">
            <p>Total Compra: Gs. {{ number_format($compra->total, 0) }}</p>
        </div>
    </div>

    <h4>Detalle de Productos</h4>
    <table class="tabla-detalles">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $index => $detalle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detalle->producto_nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Gs. {{ number_format($detalle->precio_unitario, 0) }}</td>
                    <td>Gs. {{ number_format($detalle->subtotal, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <p>Total general: Gs. {{ number_format($compra->total, 0) }}</p>
    </div>

    <div class="footer">
        <p>Esta ficha de compra fue generada automáticamente por el sistema.</p>
    </div>

</body>
</html>
