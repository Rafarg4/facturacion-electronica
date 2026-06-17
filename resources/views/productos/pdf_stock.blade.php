<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte de Stock {{ $date }}.pdf</title>
<style>

body{
    font-family: DejaVu Sans;
    font-size:11px;
    color:#333;
    margin:15px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:6px;
}

.card{
    border:1px solid #d9d9d9;
    border-radius:5px;
    padding:10px;
    margin-bottom:10px;
}

.logo{
    max-width:120px;
    max-height:80px;
}

.empresa{
    font-size:18px;
    font-weight:bold;
}

.titulo{
    font-size:22px;
    font-weight:bold;
}

.text-center{
    text-align:center;
}

.text-right{
    text-align:right;
}

.tabla-detalle th{
    background:#f2f2f2;
    border:1px solid #000;
    font-weight:bold;
    text-align:center;
}

.tabla-detalle td{
    border:1px solid #000;
}

.footer{
    margin-top:30px;
}

.firma{
    width:250px;
    margin-top:50px;
    border-top:1px solid #000;
    text-align:center;
    padding-top:5px;
}

</style>

</head>

<body>

<!-- ===================================================== -->
<!-- CABECERA -->
<!-- ===================================================== -->

<div class="card">

<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:9px;
    color:#333;
    margin:8px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:3px;
}

.card{
    border:1px solid #d9d9d9;
    border-radius:4px;
    padding:6px;
    margin-bottom:6px;
}

.logo{
    max-width:80px;
    max-height:50px;
}

.empresa{
    font-size:13px;
    font-weight:bold;
}

.titulo{
    font-size:16px;
    font-weight:bold;
}

.text-center{
    text-align:center;
}

.text-right{
    text-align:right;
}

.tabla-detalle{
    font-size:8px;
}

.tabla-detalle th{
    background:#f2f2f2;
    border:1px solid #000;
    font-weight:bold;
    text-align:center;
    padding:4px;
}

.tabla-detalle td{
    border:1px solid #000;
    padding:3px;
}

.footer{
    margin-top:15px;
}

.firma{
    width:180px;
    margin-top:30px;
    border-top:1px solid #000;
    text-align:center;
    padding-top:3px;
    font-size:9px;
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

        <td width="12%">

            @if(!empty($empresa->logo))
                <img
                    src="{{ public_path('imagenes/'.$empresa->logo) }}"
                    class="logo">
            @endif

        </td>

        <td width="58%">

            <div class="empresa">
                {{ strtoupper($empresa->nombre ?? 'EMPRESA') }}
            </div>

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

            <div class="titulo">
                REPORTE DE STOCK
            </div>

            <strong>Fecha:</strong>
            {{ date('d/m/Y H:i') }}

            <br>

            <strong>Total Productos:</strong>
            {{ count($productos) }}

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
            <th width="12%">Código</th>
            <th width="12%">N° Item</th>
            <th width="38%">Producto</th>
            <th width="18%">Rubro</th>
            <th width="10%">Stock</th>
            <th width="10%">Mínimo</th>
        </tr>

    </thead>

    <tbody>

    @foreach($productos as $producto)

        <tr>

            <td>
                {{ $producto->codigo }}
            </td>

            <td>
                {{ $producto->num_item }}
            </td>

            <td>
                {{ strtoupper($producto->descripcion) }}
            </td>

            <td>
                {{ strtoupper($producto->id_rubro) }}
            </td>

            <td class="text-center">
                {{ number_format($producto->cantidad,0,',','.') }}
            </td>

            <td class="text-center">
                {{ number_format($producto->cantidad_minima,0,',','.') }}
            </td>

        </tr>

    @endforeach

    </tbody>

</table>


</div>

<!-- ===================================================== -->

<!-- RESUMEN -->

<!-- ===================================================== -->

<div class="card">


<table>

    <tr>

        <td width="70%">

            <strong>Total de productos listados:</strong>
            {{ count($productos) }}

        </td>

        <td width="30%" class="text-right">

            <strong>Emitido:</strong>
            {{ date('d/m/Y H:i') }}

        </td>

    </tr>

</table>


</div>

<!-- ===================================================== -->

<!-- FIRMAS -->

<!-- ===================================================== -->

<div class="footer">


<table>

    <tr>

        <td width="50%" class="text-center">

            <div class="firma">
                Responsable de Inventario
            </div>

        </td>

        <td width="50%" class="text-center">

            <div class="firma">
                Verificado por
            </div>

        </td>

    </tr>

</table>


</div>

</body>
</html>
 

</div>

</body>
</html>