@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Generar cierre</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message') 
    @include('adminlte-templates::common.errors')

    <div class="card mx-auto" style="max-width: 600px;">
        @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

        <div class="card-header text-center">
            <strong>Se generara el cierre de {{ Auth::user()->name }} en la fecha de {{ \Carbon\Carbon::now()->format('Y-m-d') }}</strong>
        </div>
                 <div class="card-body">
                <form action="{{ route('generar_cierre') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_usuario">Cajero:</label>
                    <input type="text" name="usuarios" id="id_usuario" class="form-control" 
                           value="{{ Auth::user()->name }}" readonly>
                </div>
                {!! Form::hidden('id_usuario', Auth::user()->id) !!}
                <div class="form-group">
                    <label for="fecha_cierre">Fecha de cierre:</label>
                    <input type="date" name="fecha_cierre" id="fecha_cierre" class="form-control"
                           value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                </div>
                {!! Form::hidden('id_caja', Auth::user()->caja) !!}
                <div class="form-group">
                    <label for="observacion">Observación:</label>
                    <textarea name="observacion" id="observacion" class="form-control" rows="3" placeholder="Ingrese una observación..."></textarea>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        Generar cierre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
