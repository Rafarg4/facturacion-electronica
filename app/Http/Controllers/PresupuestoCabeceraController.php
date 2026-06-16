<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePresupuestoCabeceraRequest;
use App\Http\Requests\UpdatePresupuestoCabeceraRequest;
use App\Repositories\PresupuestoCabeceraRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Response;
use App\Helpers\NumeroALetras;
class PresupuestoCabeceraController extends AppBaseController
{
    /** @var PresupuestoCabeceraRepository $presupuestoCabeceraRepository*/
    private $presupuestoCabeceraRepository;

    public function __construct(PresupuestoCabeceraRepository $presupuestoCabeceraRepo)
    {
        $this->presupuestoCabeceraRepository = $presupuestoCabeceraRepo;
    }

    /**
     * Display a listing of the PresupuestoCabecera.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $presupuestoCabeceras = $this->presupuestoCabeceraRepository->all();

        return view('presupuesto_cabeceras.index')
            ->with('presupuestoCabeceras', $presupuestoCabeceras);
    }

    /**
     * Show the form for creating a new PresupuestoCabecera.
     *
     * @return Response
     */
    public function create()
    {
        $clientes = DB::table('clientes')
            ->select('id', 'nombre', 'apellido', 'ci')
            ->get()
            ->mapWithKeys(function ($cliente) {
                return [
                    $cliente->id => $cliente->nombre . ' ' .
                                    $cliente->apellido . ' - CI: ' .
                                    $cliente->ci
                ];
            });

        return view('presupuesto_cabeceras.create')
            ->with('clientes', $clientes);
    }

    /**
     * Store a newly created PresupuestoCabecera in storage.
     *
     * @param CreatePresupuestoCabeceraRequest $request
     *
     * @return Response
     */
  public function store(CreatePresupuestoCabeceraRequest $request)
{
    //return $request->all();
    DB::beginTransaction();

    try {

        $input = $request->all();

        // Guarda la cabecera
       $presupuestoCabecera = $this->presupuestoCabeceraRepository->create(
            array_merge(
                $request->all(),
                ['estado' => 'Pendiente']
            )
        );

        // Guarda los detalles
        if ($request->has('concepto')) {

            foreach ($request->concepto as $i => $concepto) {

                DB::table('presupuesto_detalles')->insert([

                    'id_presupuesto_cabecera' => $presupuestoCabecera->id,

                    'cantidad' => $request->cantidad[$i] ?? 1,

                    'concepto' => $concepto,

                    'total' => (
                        ($request->cantidad[$i] ?? 1) *
                        ($request->precio_unitario[$i] ?? 0)
                    ),

                    'created_at' => now(),
                    'updated_at' => now()

                ]);
            }
        }

        DB::commit();

        Flash::success('Presupuesto guardado correctamente.');

        return redirect(route('presupuestoCabeceras.index'));

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => true,
                'mensaje' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'linea' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);

        }
    }

    /**
     * Display the specified PresupuestoCabecera.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $presupuestoCabecera = $this->presupuestoCabeceraRepository->find($id);

        if (empty($presupuestoCabecera)) {
            Flash::error('Presupuesto Cabecera not found');

            return redirect(route('presupuestoCabeceras.index'));
        }

        return view('presupuesto_cabeceras.show')->with('presupuestoCabecera', $presupuestoCabecera);
    }

    /**
     * Show the form for editing the specified PresupuestoCabecera.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $presupuestoCabecera = $this->presupuestoCabeceraRepository->find($id);

        if (empty($presupuestoCabecera)) {
            Flash::error('Presupuesto Cabecera not found');

            return redirect(route('presupuestoCabeceras.index'));
        }

        return view('presupuesto_cabeceras.edit')->with('presupuestoCabecera', $presupuestoCabecera);
    }

    /**
     * Update the specified PresupuestoCabecera in storage.
     *
     * @param int $id
     * @param UpdatePresupuestoCabeceraRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePresupuestoCabeceraRequest $request)
    {
        $presupuestoCabecera = $this->presupuestoCabeceraRepository->find($id);

        if (empty($presupuestoCabecera)) {
            Flash::error('Presupuesto Cabecera not found');

            return redirect(route('presupuestoCabeceras.index'));
        }

        $presupuestoCabecera = $this->presupuestoCabeceraRepository->update($request->all(), $id);

        Flash::success('Presupuesto Cabecera updated successfully.');

        return redirect(route('presupuestoCabeceras.index'));
    }

    /**
     * Remove the specified PresupuestoCabecera from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $presupuestoCabecera = $this->presupuestoCabeceraRepository->find($id);

        if (empty($presupuestoCabecera)) {
            Flash::error('Presupuesto Cabecera not found');

            return redirect(route('presupuestoCabeceras.index'));
        }

        $this->presupuestoCabeceraRepository->delete($id);

        Flash::success('Presupuesto Cabecera deleted successfully.');

        return redirect(route('presupuestoCabeceras.index'));
    }
   public function pdf($id)
    {
        $cabecera = DB::table('presupuesto_cabeceras as p')
            ->leftJoin('clientes as c', 'c.id', '=', 'p.id_cliente')
            ->select(
                'p.*',
                'c.nombre',
                'c.apellido',
                'c.ci'
            )
            ->where('p.id', $id)
            ->first();

        $detalles = DB::table('presupuesto_detalles')
            ->where('id_presupuesto_cabecera', $id)
            ->get();

        $monto_letras = NumeroALetras::convertir($cabecera->total);

        $pdf = Pdf::loadView(
            'presupuesto_cabeceras.pdf',
            compact(
                'cabecera',
                'detalles',
                'monto_letras'
            )
        );

        return $pdf->stream(
            'Presupuesto_'.$cabecera->id.'.pdf'
        );
    }
}
