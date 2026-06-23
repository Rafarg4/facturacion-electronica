<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\MiPlan;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Flash;
use Response;

class PlanController extends AppBaseController
{
    public function index(Request $request)
    {
        $planes = Plan::withCount('cuotas')
            ->withCount(['cuotas as cuotas_pagadas' => function ($q) {
                $q->where('estado', 'Pagado');
            }])
            ->get();

        return view('planes.index')->with('planes', $planes);
    }

    public function create()
    {
        return view('planes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa'         => 'required|string',
            'descripcion'     => 'nullable|string',
            'fecha_inicio'    => 'required|date',
            'cantidad_cuotas' => 'required|integer|min:1|max:360',
            'monto_cuota'     => 'required|numeric|min:0.01',
            'periodicidad'    => 'required|in:mensual,quincenal,semanal',
            'estado'          => 'required|string',
            'observacion'     => 'nullable|string',
        ]);

        $input = $request->all();
        $input['monto_total'] = (float) $input['monto_cuota'] * (int) $input['cantidad_cuotas'];

        $plan = Plan::create($input);

        $this->generarCuotasParaPlan($plan, $plan->fecha_inicio, $plan->cantidad_cuotas, $plan->monto_cuota, $plan->periodicidad);

        Flash::success('Plan creado con ' . $plan->cantidad_cuotas . ' cuotas generadas correctamente.');

        return redirect(route('planes.show', $plan->id));
    }

    public function show($id)
    {
        $plan = Plan::with(['cuotas' => function ($q) {
            $q->orderBy('nro_cuota');
        }])->find($id);

        if (empty($plan)) {
            Flash::error('Plan no encontrado.');
            return redirect(route('planes.index'));
        }

        $totalPagado    = $plan->cuotas->where('estado', 'Pagado')->sum('monto_cuota');
        $saldoPendiente = $plan->cuotas->whereIn('estado', ['Pendiente', 'Parcial'])->sum('saldo_cuota');

        return view('planes.show', compact('plan', 'totalPagado', 'saldoPendiente'));
    }

    public function edit($id)
    {
        $plan = Plan::find($id);

        if (empty($plan)) {
            Flash::error('Plan no encontrado.');
            return redirect(route('planes.index'));
        }

        return view('planes.edit')->with('plan', $plan);
    }

    public function update($id, Request $request)
    {
        $plan = Plan::find($id);

        if (empty($plan)) {
            Flash::error('Plan no encontrado.');
            return redirect(route('planes.index'));
        }

        $request->validate([
            'empresa'         => 'required|string',
            'descripcion'     => 'nullable|string',
            'fecha_inicio'    => 'required|date',
            'cantidad_cuotas' => 'required|integer|min:1|max:360',
            'monto_cuota'     => 'required|numeric|min:0.01',
            'periodicidad'    => 'required|in:mensual,quincenal,semanal',
            'estado'          => 'required|string',
            'observacion'     => 'nullable|string',
        ]);

        $input = $request->all();
        $input['monto_total'] = (float) $input['monto_cuota'] * (int) $input['cantidad_cuotas'];

        $plan->update($input);

        Flash::success('Plan actualizado correctamente.');

        return redirect(route('planes.show', $plan->id));
    }

    public function destroy($id)
    {
        $plan = Plan::find($id);

        if (empty($plan)) {
            Flash::error('Plan no encontrado.');
            return redirect(route('planes.index'));
        }

        $plan->delete();

        Flash::success('Plan eliminado correctamente.');

        return redirect(route('planes.index'));
    }

    private function generarCuotasParaPlan(Plan $plan, $fechaInicio, int $cantidadCuotas, float $montoCuota, string $periodicidad): void
    {
        $fecha       = Carbon::parse($fechaInicio);
        $ultimaCuota = $plan->cuotas()->max('nro_cuota') ?? 0;

        for ($i = 0; $i < $cantidadCuotas; $i++) {
            if ($periodicidad === 'mensual') {
                $fechaVencimiento = (clone $fecha)->addMonths($i);
            } elseif ($periodicidad === 'quincenal') {
                $fechaVencimiento = (clone $fecha)->addDays($i * 15);
            } else {
                $fechaVencimiento = (clone $fecha)->addWeeks($i);
            }

            MiPlan::create([
                'plan_id'           => $plan->id,
                'nro_cuota'         => $ultimaCuota + $i + 1,
                'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
                'fecha_pago'        => null,
                'monto_cuota'       => $montoCuota,
                'saldo_cuota'       => $montoCuota,
                'estado'            => 'Pendiente',
                'observacion'       => '',
            ]);
        }
    }
}
