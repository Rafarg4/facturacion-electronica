<?php

namespace App\Http\Middleware;

use App\Models\MiPlan;
use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VerificarPagoPlan
{
    // Prefijos de ruta que se permiten aunque haya deuda vencida
    protected $prefijosPermitidos = [
        'planes',
        'miPlans',
        'login',
        'logout',
        'password',
        'sistema.bloqueado',
    ];

    public function handle(Request $request, Closure $next)
    {
        // Solo verificar usuarios autenticados
        if (!auth()->check()) {
            return $next($request);
        }

        $rutaActual = $request->route()?->getName() ?? '';

        // Permitir rutas de pago, auth y la página de bloqueo
        foreach ($this->prefijosPermitidos as $prefijo) {
            if ($rutaActual === $prefijo || str_starts_with($rutaActual, $prefijo)) {
                return $next($request);
            }
        }

        // Verificar si existe alguna cuota vencida sin pagar de un plan vigente
        $cuotaVencida = MiPlan::whereNotNull('plan_id')
            ->whereHas('plan', function ($q) {
                $q->where('estado', 'Vigente');
            })
            ->where('fecha_vencimiento', '<', Carbon::today())
            ->where('estado', '!=', 'Pagado')
            ->with('plan')
            ->first();

        if ($cuotaVencida) {
            return redirect()->route('sistema.bloqueado');
        }

        return $next($request);
    }
}
