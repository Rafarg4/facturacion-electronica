@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Presupuesto</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('adminlte-templates::common.errors')

    <div class="card">

        {!! Form::open(['route' => 'presupuestoCabeceras.store']) !!}

        <div class="card-body">

            @include('presupuesto_cabeceras.fields')

        </div>

        <div class="card-footer">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('presupuestoCabeceras.index') }}" class="btn btn-default">
                Cancelar
            </a>
        </div>

        {!! Form::close() !!}

    </div>

</div>
@endsection