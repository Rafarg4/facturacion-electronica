
<br><div class="card card-primary card-outline">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <h3 class="card-title mb-0">
                <i class="fas fa-truck text-primary"></i>
                Información del Proveedor
            </h3>

            <a href="{{ route('proveedors.index') }}"
               class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i>
                Volver
            </a>

        </div>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nombre</label>
                    <p class="form-control-static">{{ $proveedor->nombre }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Apellido</label>
                    <p class="form-control-static">{{ $proveedor->apellido }}</p>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> Cédula</label>
                    <p class="form-control-static">{{ $proveedor->ci }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Teléfono</label>
                    <p class="form-control-static">{{ $proveedor->telefono }}</p>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Correo Electrónico</label>
                    <p class="form-control-static">{{ $proveedor->correo }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><i class="fas fa-building"></i> Compañía</label>
                    <p class="form-control-static">{{ $proveedor->compania }}</p>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Dirección</label>
                    <p class="form-control-static">{{ $proveedor->direccion }}</p>
                </div>
            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label><i class="fas fa-calendar-plus"></i> Fecha de Registro</label>
                    <p class="form-control-static">
                        {{ $proveedor->created_at ? $proveedor->created_at->format('d/m/Y H:i') : '' }}
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><i class="fas fa-sync-alt"></i> Última Actualización</label>
                    <p class="form-control-static">
                        {{ $proveedor->updated_at ? $proveedor->updated_at->format('d/m/Y H:i') : '' }}
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

<style>
.form-control-static{
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    padding: 10px 12px;
    border-radius: 6px;
    min-height: 40px;
    font-weight: 500;
    color: #495057;
}

.card{
    box-shadow: 0 2px 10px rgba(0,0,0,.08);
}

.card-header{
    font-weight: 600;
}

label{
    color: #6c757d;
    font-size: 13px;
    margin-bottom: 5px;
}

.card-header .btn{
    border-radius: 5px;
}
</style>