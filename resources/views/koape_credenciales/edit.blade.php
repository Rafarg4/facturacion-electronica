@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Facturación Electrónica</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            <div class="card-header">
                @if($credencial && $credencial->usuario)
                    <span class="badge badge-success">Configurado</span>
                    <span class="text-muted ml-2">Última actualización: {{ optional($credencial->updated_at)->format('d/m/Y H:i') }}</span>
                @else
                    <span class="badge badge-danger">Sin configurar</span>
                @endif
            </div>

            {!! Form::open(['route' => 'koapeCredenciales.update', 'method' => 'put']) !!}

            <div class="card-body">
                <h5>Conexión</h5>
                <div class="row">
                    <div class="form-group col-sm-6">
                        {!! Form::label('base_url', 'URL base de la API:') !!}
                        {!! Form::text('base_url', $credencial->base_url ?? $defaults['base_url'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'https://api.facturacionkoape.com']) !!}
                    </div>

                    <div class="form-group col-sm-3">
                        {!! Form::label('establecimiento', 'Establecimiento:') !!}
                        {!! Form::text('establecimiento', $credencial->establecimiento ?? $defaults['establecimiento'], ['class' => 'form-control', 'required' => 'required', 'maxlength' => 10]) !!}
                    </div>

                    <div class="form-group col-sm-3">
                        {!! Form::label('punto_expedicion', 'Punto de expedición:') !!}
                        {!! Form::text('punto_expedicion', $credencial->punto_expedicion ?? $defaults['punto_expedicion'], ['class' => 'form-control', 'required' => 'required', 'maxlength' => 10]) !!}
                    </div>
                </div>

                <hr>

                <h5>Credenciales</h5>
                <div class="row">
                    <div class="form-group col-sm-4">
                        {!! Form::label('usuario', 'Usuario:') !!}
                        {!! Form::text('usuario', $credencial->usuario ?? null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group col-sm-4">
                        {!! Form::label('password', 'Password:') !!}
                        <div class="input-group">
                            {!! Form::input('password', 'password', $credencial->password ?? null, ['class' => 'form-control', 'id' => 'password-field']) !!}
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password-field">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-4">
                        {!! Form::label('codigo_acceso', 'Código de acceso:') !!}
                        <div class="input-group">
                            {!! Form::input('password', 'codigo_acceso', $credencial->codigo_acceso ?? null, ['class' => 'form-control', 'id' => 'codigo-acceso-field']) !!}
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="codigo-acceso-field">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            Rota automáticamente después de cada emisión.
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.dataset.target);
                var icon = btn.querySelector('i');
                var isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            });
        });
    </script>
@endsection
