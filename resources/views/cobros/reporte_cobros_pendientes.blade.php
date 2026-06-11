<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cuotas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Reporte de Cuotas Pendientes</h2>

    <table>
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Nro Cuota</th>
                <th>Monto</th>
                <th>Saldo</th>
                <th>Estado</th>
                <th>Fecha Vencimiento</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMonto = 0;
                $totalSaldo = 0;
            @endphp

            @foreach ($datos as $item)
                @php
                    $totalMonto += $item->monto;
                    $totalSaldo += $item->saldo;
                @endphp
                <tr>
                    <td>{{ $item->ci }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->apellido }}</td>
                    <td>{{ $item->numero_cuota }}</td>
                    <td>{{ number_format($item->monto, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->saldo, 0, ',', '.') }}</td>
                    <td>{{ $item->estado }}</td>
                    <td>{{ $item->fecha_vencimiento }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><strong>Total General</strong></td>
                <td><strong>{{ number_format($totalMonto, 0, ',', '.') }}</strong></td>
                <td><strong>{{ number_format($totalSaldo, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
