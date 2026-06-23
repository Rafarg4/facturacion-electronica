@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1>Nuevo Plan</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('planes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => 'planes.store', 'method' => 'POST']) !!}
                    <div class="row">
                        @include('planes.fields')
                    </div>
                    <div class="text-right mt-2">
                        <a href="{{ route('planes.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
