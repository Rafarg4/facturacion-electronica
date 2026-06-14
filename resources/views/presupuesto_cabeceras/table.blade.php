 <div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table" id="table">
        <thead>
        <tr>
            <th>Cliente</th>
        <th>Estado</th>
        <th>Responsable</th>
        <th>Descripcion</th>
        <th>Sub Total</th>
        <th>Total</th>
        <th>Tipo Presupuesto</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($presupuestoCabeceras as $presupuestoCabecera)
            <tr>
                <td>{{ $presupuestoCabecera->cliente }}</td>
            <td>{{ $presupuestoCabecera->estado }}</td>
            <td>{{ $presupuestoCabecera->responsable }}</td>
            <td>{{ $presupuestoCabecera->descripcion }}</td>
            <td>{{ $presupuestoCabecera->sub_total }}</td>
            <td>{{ $presupuestoCabecera->total }}</td>
            <td>{{ $presupuestoCabecera->tipo_presupuesto }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['presupuestoCabeceras.destroy', $presupuestoCabecera->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('presupuestoCabeceras.show', [$presupuestoCabecera->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('presupuestoCabeceras.edit', [$presupuestoCabecera->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
