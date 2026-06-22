<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMiPlanRequest;
use App\Http\Requests\UpdateMiPlanRequest;
use App\Repositories\MiPlanRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\MiPlan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Flash;
use Response;

class MiPlanController extends AppBaseController
{
    /** @var MiPlanRepository $miPlanRepository*/
    private $miPlanRepository;

    public function __construct(MiPlanRepository $miPlanRepo)
    {
        $this->miPlanRepository = $miPlanRepo;
    }

    /**
     * Display a listing of the MiPlan.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $miPlans = $this->miPlanRepository->all();

        return view('mi_plans.index')
            ->with('miPlans', $miPlans);
    }

    /**
     * Show the form for creating a new MiPlan.
     *
     * @return Response
     */
    public function create()
    {
        return view('mi_plans.create');
    }

    /**
     * Store a newly created MiPlan in storage.
     *
     * @param CreateMiPlanRequest $request
     *
     * @return Response
     */
    public function store(CreateMiPlanRequest $request)
    {
        $input = $request->all();

        $miPlan = $this->miPlanRepository->create($input);

        Flash::success('Mi Plan saved successfully.');

        return redirect(route('miPlans.index'));
    }

    /**
     * Display the specified MiPlan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $miPlan = $this->miPlanRepository->find($id);

        if (empty($miPlan)) {
            Flash::error('Mi Plan not found');

            return redirect(route('miPlans.index'));
        }

        return view('mi_plans.show')->with('miPlan', $miPlan);
    }

    /**
     * Show the form for editing the specified MiPlan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $miPlan = $this->miPlanRepository->find($id);

        if (empty($miPlan)) {
            Flash::error('Mi Plan not found');

            return redirect(route('miPlans.index'));
        }

        return view('mi_plans.edit')->with('miPlan', $miPlan);
    }

    /**
     * Update the specified MiPlan in storage.
     *
     * @param int $id
     * @param UpdateMiPlanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMiPlanRequest $request)
    {
        $miPlan = $this->miPlanRepository->find($id);

        if (empty($miPlan)) {
            Flash::error('Mi Plan not found');

            return redirect(route('miPlans.index'));
        }

        $miPlan = $this->miPlanRepository->update($request->all(), $id);

        Flash::success('Mi Plan updated successfully.');

        return redirect(route('miPlans.index'));
    }

    /**
     * Registrar un pago sobre una cuota.
     */
    public function registrarPago(Request $request, $id)
    {
        $request->validate([
            'fecha_pago'    => 'required|date',
            'monto_pagado'  => 'required|numeric|min:0.01',
        ]);

        $miPlan = $this->miPlanRepository->find($id);

        if (empty($miPlan)) {
            Flash::error('Cuota no encontrada.');
            return redirect(route('miPlans.index'));
        }

        $nuevoSaldo = max(0, (float) $miPlan->saldo_cuota - (float) $request->monto_pagado);
        $estado     = $nuevoSaldo <= 0 ? 'Pagado' : 'Parcial';

        $this->miPlanRepository->update([
            'fecha_pago'  => $request->fecha_pago,
            'saldo_cuota' => $nuevoSaldo,
            'estado'      => $estado,
        ], $id);

        Flash::success('Pago registrado correctamente.');

        return redirect(route('miPlans.index'));
    }

    /**
     * Generar cuotas automáticamente según cantidad, monto y fecha inicio.
     */
    public function generarCuotas(Request $request)
    {
        $request->validate([
            'empresa'          => 'required|string',
            'fecha_inicio'     => 'required|date',
            'cantidad_cuotas'  => 'required|integer|min:1|max:360',
            'monto_total'      => 'required|numeric|min:0.01',
            'periodicidad'     => 'required|in:mensual,quincenal,semanal',
            'observacion'      => 'nullable|string',
        ]);

        $fechaInicio    = Carbon::parse($request->fecha_inicio);
        $cantidadCuotas = (int) $request->cantidad_cuotas;
        $montoCuota     = (float) $request->monto_total;
        $periodicidad   = $request->periodicidad;

        for ($i = 0; $i < $cantidadCuotas; $i++) {
            if ($periodicidad === 'mensual') {
                $fechaVencimiento = (clone $fechaInicio)->addMonths($i);
            } elseif ($periodicidad === 'quincenal') {
                $fechaVencimiento = (clone $fechaInicio)->addDays($i * 15);
            } else {
                $fechaVencimiento = (clone $fechaInicio)->addWeeks($i);
            }

            MiPlan::create([
                'empresa'           => $request->empresa,
                'nro_cuota'         => $i + 1,
                'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
                'fecha_pago'        => null,
                'monto_cuota'       => $montoCuota,
                'saldo_cuota'       => $montoCuota,
                'estado'            => 'Pendiente',
                'observacion'       => $request->observacion ?? '',
            ]);
        }

        Flash::success("Se generaron {$cantidadCuotas} cuotas correctamente.");

        return redirect(route('miPlans.index'));
    }

    /**
     * Remove the specified MiPlan from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $miPlan = $this->miPlanRepository->find($id);

        if (empty($miPlan)) {
            Flash::error('Mi Plan not found');

            return redirect(route('miPlans.index'));
        }

        $this->miPlanRepository->delete($id);

        Flash::success('Mi Plan deleted successfully.');

        return redirect(route('miPlans.index'));
    }
}
