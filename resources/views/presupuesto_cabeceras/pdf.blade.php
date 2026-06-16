<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:12px;
    color:#333;
    margin:15px;
}

.card{
    border:1px solid #d9d9d9;
    border-radius:8px;
    padding:12px;
    margin-bottom:12px;
}

.logo{
    max-height:70px;
    max-width:120px;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    padding:5px;
    vertical-align:top;
}

.label{
    font-weight:bold;
}

.text-right{
    text-align:right;
}

.text-center{
    text-align:center;
}

.empresa{
    font-size:18px;
    font-weight:bold;
}

.presupuesto-titulo{
    font-size:22px;
    font-weight:bold;
}

.subtitulo{
    font-size:14px;
    font-weight:bold;
    margin-bottom:8px;
}

.tabla-detalle{
    width:100%;
}

.tabla-detalle th{
    border-bottom:2px solid #ddd;
    padding:8px;
    text-align:left;
    font-weight:bold;
    background:#f7f7f7;
}

.tabla-detalle td{
    border-bottom:1px solid #eee;
    padding:8px;
}

.total{
    font-weight:bold;
}

.total-general{
    font-size:16px;
    font-weight:bold;
}

</style>

</head>

<body>

<!-- ===================================================== -->
<!-- CABECERA -->
<!-- ===================================================== -->

<div class="card">

    <table>

        <tr>

            <td width="15%">

                @if(!empty($empresa->logo))
                    <img
                        src="{{ public_path('imagenes/'.$empresa->logo) }}"
                        class="logo">
                @endif

            </td>

            <td width="55%">

                <div class="empresa">
                    {{ strtoupper($empresa->nombre ?? 'MI EMPRESA') }}
                </div>

                <br>

                <strong>RUC:</strong>
                {{ $empresa->ruc ?? '' }}

                <br>

                <strong>Dirección:</strong>
                {{ $empresa->direccion ?? '' }}

                <br>

                <strong>Teléfono:</strong>
                {{ $empresa->telefono ?? '' }}

                <br>

                <strong>Correo:</strong>
                {{ $empresa->correo ?? '' }}

            </td>

            <td width="30%" class="text-right">

                <div class="presupuesto-titulo">
                    PRESUPUESTO
                </div>

                <strong>N°:</strong>
                {{ $cabecera->id }}

                <br>

                <strong>Fecha:</strong>
                {{ \Carbon\Carbon::parse($cabecera->created_at)->format('d/m/Y') }}

                <br>

                <strong>Estado:</strong>
                {{ $cabecera->estado }}

                <br>

                <strong>Tipo:</strong>
                {{ $cabecera->tipo_presupuesto }}

            </td>

        </tr>

    </table>

</div>

<!-- ===================================================== -->
<!-- DATOS CLIENTE -->
<!-- ===================================================== -->

<div class="card">

    <table>

        <tr>

            <td width="15%" class="label">
                Cliente
            </td>

            <td width="35%">
                {{ $cabecera->nombre }}
                {{ $cabecera->apellido }}
            </td>

            <td width="15%" class="label">
                Documento
            </td>

            <td width="35%">
                {{ $cabecera->ci }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Responsable
            </td>

            <td>
                {{ $cabecera->responsable }}
            </td>

            <td class="label">
                Estado
            </td>

            <td>
                {{ $cabecera->estado }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Tipo
            </td>

            <td>
                {{ $cabecera->tipo_presupuesto }}
            </td>

            <td class="label">
                Fecha
            </td>

            <td>
                {{ \Carbon\Carbon::parse($cabecera->created_at)->format('d/m/Y') }}
            </td>

        </tr>

    </table>

</div>

<!-- ===================================================== -->
<!-- DATOS DEL PRESUPUESTO -->
<!-- ===================================================== -->

<div class="card">

    <table>

        <tr>

            <td width="30%">

                <div class="subtitulo">
                    Tipo de Gestión
                </div>

                {{ $cabecera->tipo_presupuesto }}

            </td>

            <td width="45%">

                <div class="subtitulo">
                    Descripción
                </div>

                {{ $cabecera->descripcion }}

            </td>

            <td width="25%" class="text-right">

                <div class="subtitulo">
                    Monto
                </div>

                <strong>
                    {{ number_format($cabecera->total,0,',','.') }}
                </strong>

            </td>

        </tr>

    </table>

</div>

<!-- ===================================================== -->
<!-- DETALLE -->
<!-- ===================================================== -->

<div class="card">

    <table class="tabla-detalle">

        <thead>

            <tr>
                <th width="10%">Cant.</th>
                <th width="70%">Conceptos</th>
                <th width="20%" class="text-right">Total</th>
            </tr>

        </thead>

        <tbody>

        @foreach($detalles as $detalle)

            <tr>

                <td class="text-center">
                    {{ $detalle->cantidad }}
                </td>

                <td>
                    {{ strtoupper($detalle->concepto) }}
                </td>

                <td class="text-right">
                    {{ number_format($detalle->total,0,',','.') }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<!-- ===================================================== -->
<!-- TOTALES -->
<!-- ===================================================== -->

<div class="card">

    <table>

        <tr>

            <td width="80%" class="text-right total">
                Subtotal
            </td>

            <td width="20%" class="text-right">
                {{ number_format($cabecera->sub_total,0,',','.') }}
            </td>

        </tr>

        <tr>

            <td class="text-right total-general">
                Total Presupuesto
            </td>

            <td class="text-right total-general">
                {{ number_format($cabecera->total,0,',','.') }}
            </td>

        </tr>
        <tr>
         <td colspan="2" style="padding-top:10px;">
            <strong>En letras:</strong>

            {{ $monto_letras }}

            @if($cabecera->tipo_moneda == 'PYG')
                GUARANÍES
            @elseif($cabecera->tipo_moneda == 'USD')
                DÓLARES AMERICANOS
            @elseif($cabecera->tipo_moneda == 'BRL')
                REALES
            @elseif($cabecera->tipo_moneda == 'ARS')
                PESOS ARGENTINOS
            @endif
        </td>
        </tr>

    </table>

</div>

</body>
</html>