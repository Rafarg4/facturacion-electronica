<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompraRequest;
use App\Http\Requests\UpdateCompraRequest;
use App\Repositories\CompraRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Dompdf\Dompdf;
use App\Models\Compra;
use App\Models\Empresa;
use DB;
use Dompdf\Options;
class CompraController extends AppBaseController
{
    /** @var CompraRepository $compraRepository*/
    private $compraRepository;

    public function __construct(CompraRepository $compraRepo)
    {
        $this->compraRepository = $compraRepo;
    }

    /**
     * Display a listing of the Compra.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $compras = $this->compraRepository->all();

        return view('compras.index')
            ->with('compras', $compras);
    }

    /**
     * Show the form for creating a new Compra.
     *
     * @return Response
     */
    public function create()
    {
        $proveedores = DB::table('proveedors')
            ->select('id', 'nombre', 'apellido', 'compania')
            ->whereNull('deleted_at')
            ->get();

        return view('compras.create', compact('proveedores'));
    }

    /**
     * Store a newly created Compra in storage.
     *
     * @param CreateCompraRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraRequest $request)
    {
        $compraId = DB::table('compras')->insertGetId([
            'id_proveedor'      => $request->id_proveedor,
            'fecha_compra'      => $request->fecha_compra,
            'tipo_comprobante'  => $request->tipo_comprobante,
            'numero_comprobante'=> $request->numero_comprobante,
            'total'             => $request->total,
            'iva'               => $request->iva,
            'condicion_compra'  => $request->condicion_compra,
            'observacion'       => $request->observacion,
            'estado'            => 'Activo',
            'id_caja'           => $request->id_caja,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $id_productos = $request->input('id_producto', []);
        $cantidades   = $request->input('cantidad', []);
        $precios      = $request->input('precio_unitario', []);
        $subtotales   = $request->input('subtotal', []);

        foreach ($id_productos as $index => $id_producto) {
            $cantidad = $cantidades[$index];
            $precio   = $precios[$index];

            DB::table('compra_detalles')->insert([
                'id_producto'     => $id_producto,
                'cantidad'        => $cantidad,
                'precio_unitario' => $precio,
                'subtotal'        => $subtotales[$index],
                'estado'          => 'Activo',
                'id_compra'       => $compraId,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            DB::table('productos')
                ->where('id', $id_producto)
                ->update([
                    'cantidad'      => DB::raw("cantidad + {$cantidad}"),
                    'costo' => $precio,
                ]);
        }

        // Generar cuotas si la condición es crédito
        if ($request->condicion_compra === 'credito') {
            $plazo     = (int) $request->plazo; // 30, 60, 90 o 120
            $cuotas    = $plazo / 30;
            $total     = floatval($request->total);
            $montoCuota = round($total / $cuotas, 2);

            for ($i = 1; $i <= $cuotas; $i++) {
                DB::table('saldo_ventas')->insert([
                    'id_venta'          => $compraId,
                    'id_cliente'        => $request->id_proveedor,
                    'monto'             => $montoCuota,
                    'saldo'             => $montoCuota,
                    'numero_cuota'      => $i,
                    'fecha_vencimiento' => now()->addDays(30 * $i),
                    'pagado'            => false,
                    'estado'            => 'Pendiente',
                    'tipo_saldo'        => 'Compra',
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
        }

        Flash::success('Compra registrada correctamente.');

        return redirect(route('compras.index'));
    }


    /**
     * Display the specified Compra.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $compra = $this->compraRepository->find($id);

        if (empty($compra)) {
            Flash::error('Compra not found');

            return redirect(route('compras.index'));
        }

        return view('compras.show')->with('compra', $compra);
    }

    /**
     * Show the form for editing the specified Compra.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $compra = $this->compraRepository->find($id);

        if (empty($compra)) {
            Flash::error('Compra not found');

            return redirect(route('compras.index'));
        }

        return view('compras.edit')->with('compra', $compra);
    }

    /**
     * Update the specified Compra in storage.
     *
     * @param int $id
     * @param UpdateCompraRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraRequest $request)
    {
        $compra = $this->compraRepository->find($id);

        if (empty($compra)) {
            Flash::error('Compra not found');

            return redirect(route('compras.index'));
        }

        $compra = $this->compraRepository->update($request->all(), $id);

        Flash::success('Compra updated successfully.');

        return redirect(route('compras.index'));
    }

    /**
     * Remove the specified Compra from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $compra = $this->compraRepository->find($id);

        if (empty($compra)) {
            Flash::error('Compra not found');

            return redirect(route('compras.index'));
        }

        $this->compraRepository->delete($id);

        Flash::success('Compra deleted successfully.');

        return redirect(route('compras.index'));
    }
    public function ficha_compra($id)
   {
    $compra = DB::table('compras')->where('id', $id)->first();

    abort_if(!$compra, 404);

    $proveedor = DB::table('proveedors')->where('id', $compra->id_proveedor)->first();

    $detalles = DB::table('compra_detalles')
        ->join('productos', 'compra_detalles.id_producto', '=', 'productos.id')
        ->where('compra_detalles.id_compra', $compra->id)
        ->select(
            'productos.descripcion as producto_nombre',
            'compra_detalles.cantidad',
            'compra_detalles.precio_unitario',
            'compra_detalles.subtotal'
        )
        ->get();
        //return $detalles;

    $empresa = Empresa::first();

    $html = view('compras.ficha_compra', compact('compra', 'proveedor', 'detalles', 'empresa'))->render();

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    $customPaper = [0, 0, 226.77, 850];
    $dompdf->setPaper($customPaper);

    $dompdf->loadHtml($html);
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="ficha_compra.pdf"');
    }
    public function anular_compra($id)
{
    // Verificar que la compra esté activa
    $compra = DB::table('compras')->where('id', $id)->first();

    if (!$compra || $compra->estado === 'Anulado') {
        return redirect()->back()->with('error', 'Compra ya anulada o no encontrada.');
    }

    // 1. Cambiar estado de la compra
    DB::table('compras')->where('id', $id)->update([
        'estado' => 'Anulado',
        'updated_at' => now()
    ]);

    // 2. Obtener los detalles de la compra
    $detalles = DB::table('compra_detalles')
        ->where('id_compra', $id)
        ->where('estado', 'Activo') // Solo los activos
        ->get();

    foreach ($detalles as $detalle) {
        // 3. Restar la cantidad del stock
        DB::table('productos')
            ->where('id', $detalle->id_producto)
            ->update([
                'cantidad' => DB::raw("cantidad - $detalle->cantidad")
            ]);

        // 4. Marcar detalle como anulado
        DB::table('compra_detalles')
            ->where('id', $detalle->id)
            ->update([
                'estado' => 'Anulado',
                'updated_at' => now()
            ]);
    }
        Flash::success('Compra anulada correctamente.');
        return redirect(route('compras.index'));
   }
}
