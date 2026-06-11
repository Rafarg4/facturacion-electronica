<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido #{{ $pedido->id }}</title>
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
        }

        .encabezado h2 {
            margin: 0;
            font-size: 18px;
        }

        .datos-pedido,
        .datos-proveedor {
            margin-top: 10px;
        }

        .datos-pedido p,
        .datos-proveedor p {
            margin: 2px 0;
        }

        .info-pedido {
            text-align: right;
            margin-top: -100px;
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

        .totales {
            margin-top: 15px;
            text-align: right;
        }

        .totales p {
            margin: 3px 0;
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

    @if(strtolower($pedido->estado) === 'anulado')
        <div class="marca-agua">ANULADO</div>
    @endif

    <div class="encabezado">
        <h2>FICHA DE PEDIDO</h2>
        <div class="datos-pedido">
            <p><strong>ID del Pedido:</strong> {{ $pedido->id }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</p>
            <p><strong>Estado:</strong> {{ $pedido->estado }}</p>
        </div>
        <div class="info-pedido">
            <p><strong>Total Pedido:</strong> Gs. {{ number_format($pedido->total, 0) }}</p>
        </div>
    </div>
       <div class="datos-proveedor" style="border: 1px solid #000; padding: 10px; margin-top: 10px;">
            <div style="display: table; width: 100%;">
                <div style="display: table-row;">
                    <!-- Columna 1 -->
                    <div style="display: table-cell; width: 33%; vertical-align: top;">
                        <p><strong>Proveedor:</strong> {{ $pedido->proveedor->nombre }} {{ $pedido->proveedor->apellido }}</p>
                        <p><strong>CI/RUC:</strong> {{ $pedido->proveedor->ci }}</p>
                    </div>

                    <!-- Columna 2 -->
                    <div style="display: table-cell; width: 33%; vertical-align: top;">
                        <p><strong>Compañía:</strong> {{ $pedido->proveedor->compania }}</p>
                        <p><strong>Correo:</strong> {{ $pedido->proveedor->correo }}</p>
                    </div>

                    <!-- Columna 3 -->
                    <div style="display: table-cell; width: 34%; vertical-align: top;">
                        <p><strong>Teléfono:</strong> {{ $pedido->proveedor->telefono }}</p>
                        <p><strong>Dirección:</strong> {{ $pedido->proveedor->direccion }}</p>
                    </div>
                </div>
            </div>
        </div>
    <table class="tabla-detalles">
        <thead>
            <tr>
                <th>Cant.</th>
                <th>Descripción</th>
                <th>Precio Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $item)
                <tr>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->nombre_producto ?? 'Producto ' . $item->id_producto }}</td>
                    <td>{{ number_format($item->precio_unitario, 0) }}</td>
                    <td>{{ number_format($item->subtotal, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <p><strong>Total general:</strong> Gs. {{ number_format($pedido->total, 0) }}</p>
    </div>

    <div class="footer">
        <p>Esta es una ficha de pedido generada automáticamente por el sistema.</p>
    </div>

</body>
</html>
