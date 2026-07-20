@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Lista de precios</h1>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid consulta-precio-page">

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="row mb-4">

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

            <div id="resultado" class="resultado-card" style="display:none;">

                <div class="row align-items-center">

                    <!-- Imagen -->
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <img id="imagen"
                             src=""
                             class="producto-imagen img-fluid"
                             style="display:none;"
                             alt="">
                        <div id="imagen_placeholder" class="producto-imagen-placeholder">
                            <i class="fa fa-image"></i>
                        </div>
                    </div>

                    <!-- Datos principales -->
                    <div class="col-md-9">

                        <h2 id="descripcion" class="producto-titulo"></h2>

                        <div class="d-flex flex-wrap align-items-center gs-precio-wrap">

                            <div class="precio-principal">
                                <span class="precio-principal-moneda">USD</span>
                                <span id="precio1" class="precio-principal-valor"></span>
                            </div>

                            <div id="cantidad" class="stock-pill"></div>

                        </div>

                        <div class="row mt-3">

                            <div class="col-6 col-md-3 mb-2">
                                <div class="precio-secundario">
                                    <span class="precio-secundario-label">Precio 2</span>
                                    <span id="precio2" class="precio-secundario-valor"></span>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 mb-2">
                                <div class="precio-secundario">
                                    <span class="precio-secundario-label">Precio 3</span>
                                    <span id="precio3" class="precio-secundario-valor"></span>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 mb-2">
                                <div class="precio-secundario">
                                    <span class="precio-secundario-label">Código</span>
                                    <span id="codigo_resultado" class="precio-secundario-valor"></span>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 mb-2">
                                <div class="precio-secundario">
                                    <span class="precio-secundario-label">N° Item</span>
                                    <span id="num_item" class="precio-secundario-valor"></span>
                                </div>
                            </div>

                        </div>

                        <div class="mt-2">
                            <span class="rubro-pill">
                                <i class="fa fa-tag"></i>
                                <span id="id_rubro"></span>
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
.consulta-precio-page .resultado-card{
    border:1px solid #e9ecef;
    border-radius:12px;
    padding:20px;
    background:#fafbfc;
}

.producto-imagen{
    max-height:180px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}

.producto-imagen-placeholder{
    display:flex;
    align-items:center;
    justify-content:center;
    height:150px;
    border-radius:10px;
    background:#eef0f2;
    color:#adb5bd;
    font-size:48px;
}

.producto-titulo{
    font-weight:700;
    color:#212529;
    margin-bottom:12px;
}

.gs-precio-wrap{
    gap:16px;
}

.precio-principal{
    background:#e6f6ec;
    border:1px solid #b7e4c7;
    border-radius:10px;
    padding:10px 20px;
    display:inline-flex;
    align-items:baseline;
    gap:8px;
}

.precio-principal-moneda{
    font-size:16px;
    font-weight:600;
    color:#2f9e56;
}

.precio-principal-valor{
    font-size:34px;
    font-weight:700;
    color:#1e7a3e;
}

.stock-pill{
    font-size:16px;
    font-weight:700;
    padding:8px 16px;
    border-radius:20px;
    background:#f1f3f5;
    color:#495057;
}

.precio-secundario{
    background:#fff;
    border:1px solid #e9ecef;
    border-radius:8px;
    padding:8px 12px;
    display:flex;
    flex-direction:column;
    height:100%;
}

.precio-secundario-label{
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.03em;
    color:#868e96;
    font-weight:600;
    margin-bottom:2px;
}

.precio-secundario-valor{
    font-size:16px;
    font-weight:600;
    color:#343a40;
}

.rubro-pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#eef2ff;
    color:#4338ca;
    border-radius:20px;
    padding:5px 14px;
    font-size:13px;
    font-weight:600;
}
</style>

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

            document.getElementById('imagen').style.display = 'none';
            document.getElementById('imagen_placeholder').style.display = 'flex';

            document.getElementById('precio1').innerHTML = '';
            document.getElementById('precio2').innerHTML = '';
            document.getElementById('precio3').innerHTML = '';
            document.getElementById('cantidad').innerHTML = '';
            document.getElementById('codigo_resultado').innerHTML = '';
            document.getElementById('num_item').innerHTML = '';
            document.getElementById('id_rubro').innerHTML = '';

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

        if(data.imagen){
            document.getElementById('imagen').src = data.imagen;
            document.getElementById('imagen').style.display = 'inline-block';
            document.getElementById('imagen_placeholder').style.display = 'none';
        }else{
            document.getElementById('imagen').style.display = 'none';
            document.getElementById('imagen_placeholder').style.display = 'flex';
        }

        document.getElementById('cantidad').innerHTML =
            'Stock: ' + Number(data.cantidad).toLocaleString('es-PY');

        if(parseFloat(data.cantidad) <= 0){
            document.getElementById('cantidad').style.color = '#c92a2a';
            document.getElementById('cantidad').style.background = '#ffe3e3';
        }else{
            document.getElementById('cantidad').style.color = '#2b8a3e';
            document.getElementById('cantidad').style.background = '#ebfbee';
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
