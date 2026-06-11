 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Nombre</th>
        <th>Apellido</th>
        <th>Ci</th>
        <th>Correo</th>
        <th>Direccion</th>
        <th>Telefono</th>
        <th>Compania</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($proveedors as $proveedor)
            <tr>
                <td>{{ $proveedor->nombre }}</td>
            <td>{{ $proveedor->apellido }}</td>
            <td>{{ $proveedor->ci }}</td>
            <td>{{ $proveedor->correo }}</td>
            <td>{{ $proveedor->direccion }}</td>
            <td>{{ $proveedor->telefono }}</td>
            <td>{{ $proveedor->compania }}</td>
              <td width="140">
                <div class="d-flex">
                    <a href="{{ route('proveedors.show', $proveedor->id) }}"
                    class="btn btn-success btn-sm mr-1"
                    title="Ver Proveedor">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('proveedors.edit', $proveedor->id) }}"
                    class="btn btn-primary btn-sm mr-1"
                    title="Editar Proveedor">
                        <i class="fas fa-edit"></i>
                    </a>
                    {!! Form::open([
                        'route' => ['proveedors.destroy', $proveedor->id],
                        'method' => 'delete',
                        'style' => 'display:inline'
                    ]) !!}
                        {!! Form::button(
                            '<i class="fas fa-trash-alt"></i>',
                            [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Eliminar Proveedor',
                                'onclick' => "return confirm('¿Está seguro de eliminar este proveedor?')"
                            ]
                        ) !!}
                    {!! Form::close() !!}
                </div>
            </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<style>
    .btn-sm{
    width: 29px;
    height: 29px;
    border-radius: 3px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-success{
    background: #198754;
    border-color: #198754;
    color: #fff;
}

.btn-primary{
    background: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
}

.btn-danger{
    background: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

.btn-sm:hover{
    transform: scale(1.05);
    transition: .2s;
}
}