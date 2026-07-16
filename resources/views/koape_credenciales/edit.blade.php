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
                <p class="text-muted">
                    Estas credenciales son específicas de este servidor (local, hosting, u otro proyecto).
                    Si cambiás de hosting, cargalas de nuevo acá — no las copies desde otra base de datos,
                    ya que se guardan encriptadas con la clave de la aplicación de <strong>este</strong> entorno.
                </p>

                <div class="row">
                    <div class="form-group col-sm-6">
                        {!! Form::label('usuario', 'Usuario:') !!}
                        {!! Form::text('usuario', $credencial->usuario ?? null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group col-sm-6">
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

                    <div class="form-group col-sm-6">
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
                            Este código rota automáticamente después de cada emisión. Solo cargalo manualmente
                            si Koape te lo proporcionó de nuevo (ej. tras un error de "código inválido").
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
