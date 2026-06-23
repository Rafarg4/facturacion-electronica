<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Bloqueado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .bloqueo-card {
            max-width: 560px;
            width: 100%;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            overflow: hidden;
        }
        .bloqueo-header {
            background: #dc3545;
            color: #fff;
            padding: 32px 24px 20px;
            text-align: center;
        }
        .bloqueo-header i {
            font-size: 52px;
            margin-bottom: 12px;
            display: block;
        }
        .bloqueo-body {
            padding: 28px 32px;
        }
        .cuota-detalle {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            border-radius: 4px;
            padding: 14px 16px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .cuota-detalle strong {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="bloqueo-card">
        <div class="bloqueo-header">
            <i class="fas fa-lock"></i>
            <h4 class="mb-1">Acceso Bloqueado</h4>
            <p class="mb-0" style="font-size:14px;opacity:.9;">
                El sistema ha sido suspendido por falta de pago
            </p>
        </div>
        <div class="bloqueo-body">
            <p class="text-muted mb-3" style="font-size:14px;">
                Se encontró una o más cuotas vencidas sin pagar. Por favor, regularice
                el pago para poder continuar utilizando el sistema.
            </p>

            @if(isset($cuota))
            <div class="cuota-detalle">
                <strong><i class="fas fa-exclamation-triangle text-warning mr-1"></i> Cuota vencida</strong>
                <div class="row" style="font-size:12px;">
                    <div class="col-6">
                        <span class="text-muted">Plan:</span>
                        <strong>{{ $cuota->plan->empresa ?? '-' }}</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Cuota N°:</span>
                        <strong>{{ $cuota->nro_cuota }}</strong>
                    </div>
                    <div class="col-6 mt-1">
                        <span class="text-muted">Vencimiento:</span>
                        <strong class="text-danger">{{ $cuota->fecha_vencimiento ? $cuota->fecha_vencimiento->format('d/m/Y') : '-' }}</strong>
                    </div>
                    <div class="col-6 mt-1">
                        <span class="text-muted">Saldo:</span>
                        <strong>{{ number_format($cuota->saldo_cuota, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
            @endif

            <div class="text-center">
                <a href="{{ route('planes.index') }}" class="btn btn-success btn-lg px-4">
                    <i class="fas fa-credit-card mr-2"></i> Ir a realizar el pago
                </a>
            </div>

            <div class="text-center mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-muted" style="font-size:13px;">
                        <i class="fas fa-sign-out-alt mr-1"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
