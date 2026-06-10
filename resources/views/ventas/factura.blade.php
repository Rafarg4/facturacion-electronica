<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $venta->numero_comprobante }}</title>
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

        .datos-empresa,
        .datos-cliente {
            margin-top: 10px;
        }

        .datos-empresa p,
        .datos-cliente p {
            margin: 2px 0;
        }

        .info-factura {
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
    </style>
</head>
<body>

    <div class="encabezado">
        <h2>FACTURA</h2>
        <div class="datos-empresa">
            <p><strong>RUC:</strong> 80071194-7</p>
            <p><strong>Razón Social:</strong> PROGRESAR S.A.</p>
            <p><strong>Dirección:</strong> 14 de Mayo esq. Tte. Honorio González - Encarnación</p>
            <p><strong>Teléfono:</strong> (071) 204 870</p>
            <p><strong>Correo:</strong> progresar_corp@hotmail.com</p>
            <p><strong>Timbrado:</strong> 16925230 - Vigencia: 28/12/2023</p>
        </div>
        <div class="info-factura">
            <p><strong>Factura N°:</strong> {{ $venta->numero_comprobante }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</p>
            <p><strong>Condición:</strong> {{ ucfirst($venta->condicion_venta) }}</p>
        </div>
    </div>

   <div class="datos-cliente" style="border: 1px solid #000; padding: 10px; margin-top: 10px;">
    <div style="display: table; width: 100%;">
        <div style="display: table-row">
            <div style="display: table-cell; width: 50%; vertical-align: top;">
                <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
                <p><strong>CI/RUC:</strong> {{ $cliente->ci }}</p>
                <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
            </div>
            <div style="display: table-cell; width: 50%; vertical-align: top;">
                <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                <p><strong>Correo:</strong> {{ $cliente->correo }}</p>
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
            @foreach($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->nombre_producto ?? 'Producto ' . $detalle->id_producto }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 0) }}</td>
                    <td>{{ number_format($detalle->subtotal, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
  @php
    $iva5 = 0;
    $iva10 = 0;
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
    <thead>
        <tr>
            <th style="border: 1px solid #000; padding: 5px;">
                IVA 5%: Gs. {{ number_format($iva5, 0) }}
            </th>
            <th style="border: 1px solid #000; padding: 5px;">
                IVA 10%: Gs. {{ number_format($iva10, 0) }}
            </th>
            <th style="border: 1px solid #000; padding: 5px;">
                Exenta: Gs. {{ number_format($exenta, 0) }}
            </th>
        </tr>
    </thead>
</table>

<p style="text-align: right; margin-top: 10px;">
    <strong>Total:</strong> Gs. {{ number_format($venta->total, 0) }}
</p>

    </div>

    <div class="footer">
        <p>Este documento es una representación gráfica de una factura electrónica.</p>
    </div>

</body>
</html>
