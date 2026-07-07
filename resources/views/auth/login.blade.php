<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $empresa->nombre }} | Facturación & Stock</title>

    <link rel="icon" href="{{ !empty($empresa->logo) ? asset('imagenes/'.$empresa->logo) : asset('logof.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            overflow: hidden;
        }

        .background-shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: .18;
            pointer-events: none;
        }

        .shape1 {
            width: 400px;
            height: 400px;
            background: #3b82f6;
            top: -150px;
            left: -150px;
        }

        .shape2 {
            width: 350px;
            height: 350px;
            background: #60a5fa;
            bottom: -120px;
            right: -120px;
        }

        .login-card {
            width: 420px;
            max-width: 95%;
            position: relative;
            z-index: 10;
            padding: 45px;
            border: none;
            border-radius: 24px;
            background: rgba(255, 255, 255, .10);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }

        .logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            padding: 10px;
            margin-bottom: 20px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .20);
        }

        .titulo {
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .subtitulo {
            color: rgba(255, 255, 255, .75);
            font-size: 14px;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group-text {
            height: 52px;
            border: none;
            color: #ffffff;
            background: rgba(255, 255, 255, .15);
            border-radius: 12px 0 0 12px;
        }

        .form-control {
            height: 52px;
            border: none;
            color: #ffffff;
            font-size: 14px;
            background: rgba(255, 255, 255, .15);
            border-radius: 0 12px 12px 0;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, .65);
        }

        .form-control:focus {
            color: #ffffff;
            background: rgba(255, 255, 255, .20);
            box-shadow: none;
        }

        .remember {
            color: #ffffff;
            font-size: 14px;
        }

        .remember input {
            margin-right: 6px;
        }

        .btn-login {
            height: 54px;
            border: none;
            color: #ffffff;
            font-weight: 600;
            letter-spacing: .5px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transition: .25s;
        }

        .btn-login:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(37, 99, 235, .35);
        }

        .invalid-feedback {
            color: #fecaca;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 12px;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            color: rgba(255, 255, 255, .55);
            font-size: 12px;
        }

        .version {
            margin-top: 5px;
            color: rgba(255, 255, 255, .40);
            font-size: 11px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
            }

            .titulo {
                font-size: 24px;
            }

            .logo {
                width: 85px;
                height: 85px;
            }
        }
    </style>
</head>

<body>

    <div class="background-shape shape1"></div>
    <div class="background-shape shape2"></div>

    <div class="login-card">

        <div class="text-center">
            <img
                src="{{ !empty($empresa->logo) ? asset('imagenes/'.$empresa->logo) : asset('logof.png') }}"
                class="logo"
                alt="Logo">

            <h3 class="titulo">
                {{ $empresa->nombre }}
            </h3>

            <p class="subtitulo">
                Facturación • Stock • Caja
            </p>
        </div>

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="Correo electrónico"
                    required
                    autofocus>
            </div>

            @error('email')
                <span class="invalid-feedback d-block">
                    {{ $message }}
                </span>
            @enderror

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>

                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Contraseña"
                    required>
            </div>

            @error('password')
                <span class="invalid-feedback d-block">
                    {{ $message }}
                </span>
            @enderror

            <div class="remember mb-4">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" class="mb-0">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-login btn-block">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Ingresar
            </button>
        </form>

        <div class="footer">
            © {{ date('Y') }} {{ $empresa->nombre }}

            <div class="version">
                Sistema de Gestión Comercial
            </div>
        </div>

    </div>

</body>
</html>