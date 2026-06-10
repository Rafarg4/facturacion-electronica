 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Descripcion</th>
        <th>Estado</th>
            <th>Accion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rubros as $rubro)
            <tr>
                <td>{{ $rubro->descripcion }}</td>
            <td>@if($rubro->estado=='S') Activo @else Inactivo @endif</td>
                <td width="140">

                    <div class="d-flex">
                        <a href="{{ route('rubros.edit', $rubro->id) }}"
                        class="btn btn-primary btn-sm mr-1"
                        title="Editar Rubro">
                            <i class="fas fa-edit"></i>
                        </a>

                        {!! Form::open([
                            'route' => ['rubros.destroy', $rubro->id],
                            'method' => 'delete',
                            'style' => 'display:inline'
                        ]) !!}

                            {!! Form::button(
                                '<i class="fas fa-trash-alt"></i>',
                                [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Eliminar Rubro',
                                    'onclick' => "return confirm('¿Está seguro de eliminar este registro?')"
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
</style>