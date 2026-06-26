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

        .info-compra {
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

        .tabla-detalles th {
            background-color: #f0f0f0;
        }

        .totales {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
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

        hr { border: none; border-top: 1px solid #ccc; margin: 8px 0; }
    </style>
</head>
<body>

    @if($compra->estado === 'Anulado')
        <div class="marca-agua">ANULADO</div>
    @endif

    <div class="encabezado">
        <h2>FICHA DE COMPRA</h2>

        {{-- Datos de la compra --}}
        <table class="datos-compra">
            <tr>
                <td><strong>ID Compra:</strong> #{{ $compra->id }}</td>
                <td><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
                <td><strong>Estado:</strong> {{ $compra->estado }}</td>
            </tr>
            <tr>
                <td><strong>Tipo Comprobante:</strong> {{ $compra->tipo_comprobante }}</td>
                <td><strong>N° Comprobante:</strong> {{ $compra->numero_comprobante }}</td>
                <td><strong>IVA:</strong> {{ $compra->iva }}%</td>
            </tr>
            <tr>
                <td><strong>Forma de Pago:</strong> {{ $compra->forma_pago }}</td>
                <td colspan="2"><strong>Observación:</strong> {{ $compra->observacion ?? '—' }}</td>
            </tr>
        </table>

        <hr>

        {{-- Datos del proveedor --}}
        <h4 style="margin: 6px 0;">Proveedor</h4>
        @if($proveedor)
        <table class="datos-compra">
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

        <div class="info-compra">
            <p>Total Compra: Gs. {{ number_format($compra->total, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Detalle de productos --}}
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
                    <td>Gs. {{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                    <td>Gs. {{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <p>Total general: Gs. {{ number_format($compra->total, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Esta ficha de compra fue generada automáticamente por el sistema.</p>
    </div>

</body>
</html>
