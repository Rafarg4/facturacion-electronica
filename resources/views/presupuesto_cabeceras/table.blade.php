 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
        <th>N°</th>
        <th>Cliente</th>
        <th>Estado</th>
        <th>Vendedor</th>
        <th>Descripción</th>
        <th>Tipo Moneda</th>
        <th>Sub Total</th>
        <th>Total</th>
        <th>Tipo</th>
        <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($presupuestoCabeceras as $presupuestoCabecera)
            <tr>
            <td>{{ $presupuestoCabecera->id }}</td>
            <td>{{ $presupuestoCabecera->ci }} - {{ $presupuestoCabecera->nombre }} {{ $presupuestoCabecera->apellido }}</td>
            <td>{{ $presupuestoCabecera->estado }}</td>
            <td>{{ $presupuestoCabecera->responsable }}</td>
            <td>{{ $presupuestoCabecera->descripcion }}</td>
            <td>{{ $presupuestoCabecera->tipo_moneda }}</td>
            <td class="text-right">{{ number_format($presupuestoCabecera->sub_total, 2, ',', '.') }}</td>
            <td class="text-right">{{ number_format($presupuestoCabecera->total, 2, ',', '.') }}</td>
            <td>{{ $presupuestoCabecera->tipo_presupuesto }}</td>
                <td width="160">
                    <div class="d-flex">
                        <a href="{{ route('presupuestoCabeceras.pdf', $presupuestoCabecera->id) }}"
                        class="btn btn-warning btn-sm mr-1"
                        title="Generar PDF"
                        target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                        {!! Form::open([
                            'route' => ['presupuestoCabeceras.destroy', $presupuestoCabecera->id],
                            'method' => 'delete',
                            'style' => 'display:inline'
                        ]) !!}

                            {!! Form::button(
                                '<i class="fas fa-trash-alt"></i>',
                                [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Eliminar Presupuesto',
                                    'onclick' => "return confirm('¿Está seguro de eliminar este presupuesto?')"
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

.btn-warning{
    background: #fd7e14;
    border-color: #fd7e14;
    color: #fff;
}

.btn-sm:hover{
    transform: scale(1.05);
    transition: .2s;
}
</style>