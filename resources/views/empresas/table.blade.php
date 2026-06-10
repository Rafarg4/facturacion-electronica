 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Nombre</th>
        <th>Ruc</th>
        <th>Descripcion</th>
        <th>Direccion</th>
        <th>Telefono</th>
        <th>Correo</th>
        <th>Timbrado</th>
            <th>Accion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($empresas as $empresa)
            <tr>
            <td>{{ $empresa->nombre }}</td>
            <td>{{ $empresa->ruc }}</td>
            <td>{{ $empresa->descripcion }}</td>
            <td>{{ $empresa->direccion }}</td>
            <td>{{ $empresa->telefono }}</td>
            <td>{{ $empresa->correo }}</td>
            <td>{{ $empresa->timbrado }}</td>
          <td width="120">
                <div class="d-flex">
                    <a href="{{ route('empresas.edit', $empresa->id) }}"
                    class="btn btn-primary btn-sm mr-1"
                    title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    {!! Form::open([
                        'route' => ['empresas.destroy', $empresa->id],
                        'method' => 'delete',
                        'style' => 'display:inline'
                    ]) !!}
                        {!! Form::button(
                            '<i class="fas fa-trash-alt"></i>',
                            [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Eliminar',
                                'onclick' => "return confirm('¿Está seguro de eliminar esta empresa?')"
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

.btn-primary{
    background: #0d6efd;
    border-color: #0d6efd;
}

.btn-danger{
    background: #dc3545;
    border-color: #dc3545;
}

.btn-sm:hover{
    transform: scale(1.05);
    transition: .2s;
}
</style>