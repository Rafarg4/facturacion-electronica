<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $empresa->nombre }} | Facturación & Stock</title>

    <link rel="icon" href="{{ asset('logof.png') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;

background:
    linear-gradient(
        135deg,
        #1f2937 0%,
        #374151 50%,
        #4b5563 100%
    );

            font-family:'Segoe UI',sans-serif;
            overflow:hidden;
        }

        .background-shape{
            position:absolute;
            border-radius:50%;
            filter:blur(80px);
            opacity:.25;
        }

        .shape1{
            width:350px;
            height:350px;
            background:#ffffff;
            top:-100px;
            left:-100px;
        }

        .shape2{
            width:300px;
            height:300px;
            background:#ffffff;
            bottom:-100px;
            right:-100px;
        }

        .login-card{

            width:420px;
            max-width:95%;

            background:rgba(255,255,255,.15);

            backdrop-filter:blur(15px);
            -webkit-backdrop-filter:blur(15px);

            border:1px solid rgba(255,255,255,.25);

            border-radius:25px;

            padding:40px;

            box-shadow:
                0 15px 40px rgba(0,0,0,.15);
        }

        .logo{
            width:110px;
            height:110px;
            object-fit:cover;

            border-radius:50%;

            background:white;

            padding:8px;

            margin-bottom:20px;
        }

        .titulo{
            color:white;
            font-size:28px;
            font-weight:700;
        }

        .subtitulo{
            color:rgba(255,255,255,.8);
            font-size:14px;
            margin-bottom:30px;
        }

        .input-group{
            margin-bottom:18px;
        }

        .input-group-text{
            background:rgba(255,255,255,.20);
            border:none;
            color:white;
            border-radius:12px 0 0 12px;
        }

        .form-control{

            height:50px;

            border:none;

            background:rgba(255,255,255,.20);

            color:white;

            border-radius:0 12px 12px 0;
        }

        .form-control::placeholder{
            color:rgba(255,255,255,.75);
        }

        .form-control:focus{
            background:rgba(255,255,255,.25);
            color:white;
            box-shadow:none;
        }

        .btn-login{

            height:52px;

            border:none;

            border-radius:14px;

            font-weight:600;

            background:white;

            color:#5b5bd6;

            transition:.3s;
        }

        .btn-login:hover{
            transform:translateY(-2px);
            background:#f5f5f5;
        }

        .links{
            margin-top:20px;
        }

        .links a{
            color:white;
            font-size:14px;
        }

        .remember{
            color:white;
            font-size:14px;
        }

        .footer{
            margin-top:25px;
            text-align:center;
            color:rgba(255,255,255,.7);
            font-size:12px;
        }

        @media(max-width:480px){

            .login-card{
                padding:30px 25px;
            }

            .titulo{
                font-size:24px;
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
            src="{{ asset('imagenes/'.$empresa->logo) }}"
            class="logo"
            alt="Logo">

        <p class="subtitulo">
            Bienvenido al Sistema
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
                required>

            @error('email')
                <span class="invalid-feedback d-block">
                    {{ $message }}
                </span>
            @enderror

        </div>

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

            @error('password')
                <span class="invalid-feedback d-block">
                    {{ $message }}
                </span>
            @enderror

        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div class="remember">

                <input
                    type="checkbox"
                    id="remember"
                    name="remember">

                <label for="remember">
                    Recordarme
                </label>

            </div>

        </div>

        <button
            type="submit"
            class="btn btn-login btn-block">

            <i class="fas fa-sign-in-alt mr-2"></i>
            Ingresar

        </button>

    </form>

    <div class="footer">

        © {{ date('Y') }}
        {{ $empresa->nombre }}

    </div>

</div>

</body>
</html>
