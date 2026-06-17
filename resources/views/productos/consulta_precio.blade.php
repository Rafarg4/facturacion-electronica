@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fa fa-barcode"></i>
                Consulta de Precios
            </h4>
        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-10">
                    <input type="text"
                           id="codigo"
                           class="form-control form-control-lg"
                           autofocus
                           autocomplete="off"
                           placeholder="Escanee o ingrese el código de barras">
                </div>

                <div class="col-md-2">
                    <button type="button"
                            id="btnBuscar"
                            class="btn btn-primary btn-lg btn-block">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </div>

            </div>

            <div id="resultado" style="display:none;">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="text-center mb-4">

                            <h2 id="descripcion"
                                class="font-weight-bold text-dark">
                            </h2>

                            <div class="mt-3">

                                <span class="badge badge-success p-3"
                                      style="font-size:35px; min-width:280px;">

                                    USD <span id="precio1"></span>

                                </span>

                            </div>

                        </div>

                        <div class="row text-center">

                            <div class="col-md-4 mb-3">

                                <div class="card border-info">

                                    <div class="card-header bg-info text-white">
                                        Precio 2
                                    </div>

                                    <div class="card-body">

                                        <h5 id="precio2"></h5>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4 mb-3">

                                <div class="card border-warning">

                                    <div class="card-header bg-warning">
                                        Precio 3
                                    </div>

                                    <div class="card-body">

                                        <h5 id="precio3"></h5>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4 mb-3">

                                <div class="card border-success">

                                    <div class="card-header bg-success text-white">
                                        Stock
                                    </div>

                                    <div class="card-body">

                                        <h5 id="cantidad"></h5>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <table class="table table-bordered table-sm mt-3">

                            <tr>
                                <th width="15%">Código</th>
                                <td id="codigo_resultado"></td>

                                <th width="15%">Item</th>
                                <td id="num_item"></td>
                            </tr>

                            <tr>
                                <th>Rubro</th>
                                <td id="id_rubro"></td>

                                <th>Stock</th>
                                <td id="cantidad_detalle"></td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function buscarProducto()
{
    let codigo = document.getElementById('codigo').value.trim();

    if(codigo == ''){
        alert('Ingrese un código');
        return;
    }

    fetch('{{ route("buscar_precio") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            codigo: codigo
        })
    })
    .then(response => response.json())
    .then(data => {

        if(!data.encontrado){

            document.getElementById('descripcion').innerHTML =
                'PRODUCTO NO ENCONTRADO';

            document.getElementById('resultado').style.display = 'block';

            return;
        }

        document.getElementById('descripcion').innerHTML =
            data.descripcion;

        document.getElementById('codigo_resultado').innerHTML =
            data.codigo;

        document.getElementById('num_item').innerHTML =
            data.num_item;

        document.getElementById('id_rubro').innerHTML =
            data.id_rubro;

        document.getElementById('cantidad').innerHTML =
            Number(data.cantidad).toLocaleString('es-PY');

        document.getElementById('cantidad_detalle').innerHTML =
            Number(data.cantidad).toLocaleString('es-PY');

        if(parseFloat(data.cantidad) <= 0){
            document.getElementById('cantidad').style.color = 'red';
        }else{
            document.getElementById('cantidad').style.color = 'green';
        }

        document.getElementById('precio1').innerHTML =
            Number(data.precio1).toLocaleString('es-PY');

        document.getElementById('precio2').innerHTML =
            'USD ' + Number(data.precio2).toLocaleString('es-PY');

        document.getElementById('precio3').innerHTML =
            'USD ' + Number(data.precio3).toLocaleString('es-PY');

        document.getElementById('resultado').style.display = 'block';

        setTimeout(function(){

            document.getElementById('resultado').style.display = 'none';
            document.getElementById('codigo').value = '';
            document.getElementById('codigo').focus();

        }, 30000);

    })
    .catch(error => {

        console.log(error);
        alert('Error al consultar');

    });
}

document.addEventListener('DOMContentLoaded', function(){

    document.getElementById('codigo').focus();

    document.getElementById('btnBuscar')
        .addEventListener('click', buscarProducto);

    document.getElementById('codigo')
        .addEventListener('keypress', function(e){

            if(e.key === 'Enter'){
                buscarProducto();
            }

        });

});

</script>

@endsection