 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Tipo Moneda</th>
        <th>Compra</th>
        <th>Venta</th>
            <th>Accion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cotizacions as $cotizacion)
            <tr>
                <td>{{ $cotizacion->tipo_moneda }}</td>
            <td>{{ $cotizacion->compra }}</td>
            <td>{{ $cotizacion->venta }}</td>
              <td width="120">
                    <div class="d-flex">

                        <a href="{{ route('cotizacions.edit', $cotizacion->id) }}"
                        class="btn btn-primary btn-sm mr-1"
                        title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>

                        {!! Form::open([
                            'route' => ['cotizacions.destroy', $cotizacion->id],
                            'method' => 'delete',
                            'style' => 'display:inline'
                        ]) !!}

                            {!! Form::button(
                                '<i class="fas fa-trash-alt"></i>',
                                [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Eliminar',
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