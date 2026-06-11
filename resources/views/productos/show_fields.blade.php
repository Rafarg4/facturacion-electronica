    <div class="card-body">

        <div class="row">

            <!-- Imagen -->
            <div class="col-md-3 text-center mb-4">

                @if(!empty($producto->imagen))
                    <img src="{{ asset('imagenes_productos/'.$producto->imagen) }}"
                         class="img-fluid img-thumbnail"
                         style="max-height:250px;">
                @else
                    <img src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIbJeL1xpe51NpmHG4drvq7XL_aoKzh04KKA&s') }}"
                         class="img-fluid img-thumbnail"
                         style="max-height:250px;">
                @endif

            </div>

            <!-- Datos -->
            <div class="col-md-9">

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-barcode"></i> Código</label>
                            <p class="form-control-static">
                                {{ $producto->codigo }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-hashtag"></i> N° Item</label>
                            <p class="form-control-static">
                                {{ $producto->num_item }}
                            </p>
                        </div>
                    </div>



                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-tags"></i> Rubro</label>
                            <p class="form-control-static">
                                {{ $producto->id_rubro }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-check-circle"></i> Estado</label>

                            <p>
                                @if($producto->estado == 'Activo')
                                    <span class="badge badge-success">
                                        Activo
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        Inactivo
                                    </span>
                                @endif
                            </p>

                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-cubes"></i> Stock</label>
                            <p class="form-control-static">
                                {{ number_format($producto->cantidad,0,',','.') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-exclamation-triangle"></i> Stock Mínimo</label>
                            <p class="form-control-static">
                                {{ number_format($producto->cantidad_minima,0,',','.') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-boxes"></i> Cantidad por Caja</label>
                            <p class="form-control-static">
                                {{ number_format($producto->cantidad_caja,0,',','.') }}
                            </p>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fas fa-shopping-cart"></i> Costo</label>
                            <p class="form-control-static">
                                Gs. {{ number_format($producto->costo,0,',','.') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Precio 1</label>
                            <p class="form-control-static">
                                Gs. {{ number_format($producto->precio1,0,',','.') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Precio 2</label>
                            <p class="form-control-static">
                                Gs. {{ number_format($producto->precio2,0,',','.') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Precio 3</label>
                            <p class="form-control-static">
                                Gs. {{ number_format($producto->precio3,0,',','.') }}
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <hr>

        <!-- Descripción -->
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label><i class="fas fa-align-left"></i> Descripción</label>
                    <p class="form-control-static">
                        {{ $producto->descripcion }}
                    </p>
                </div>
            </div>

        </div>

        <hr>

        <!-- Fechas -->
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <i class="fas fa-calendar-plus"></i>
                        Fecha de Registro
                    </label>

                    <p class="form-control-static">
                        {{ $producto->created_at ? \Carbon\Carbon::parse($producto->created_at)->format('d/m/Y H:i') : '' }}
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <i class="fas fa-sync-alt"></i>
                        Última Actualización
                    </label>

                    <p class="form-control-static">
                        {{ $producto->updated_at ? \Carbon\Carbon::parse($producto->updated_at)->format('d/m/Y H:i') : '' }}
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

<style>
.form-control-static{
    background:#f8f9fa;
    border:1px solid #dee2e6;
    padding:10px 12px;
    border-radius:6px;
    min-height:40px;
    font-weight:500;
    color:#495057;
}

.card{
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.card-header{
    font-weight:600;
}

label{
    color:#6c757d;
    font-size:13px;
    margin-bottom:5px;
}

.img-thumbnail{
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,.15);
}
</style>