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
use App\Models\Proveedor;
use App\Models\Compra;
use App\Models\Pedido;
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

        $pedidos = DB::table('pedidos')->select('id')
        ->where('estado','=','Pendiente')
        ->get();

         $productos = DB::table('productos')->select('id', 'nombre','precio_venta','cantidad')->get();
        return view('compras.create',compact('pedidos','productos'));
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
    $input = $request->all();

    $input['estado'] = $input['estado'] ?? 'Activo';

    // 1. Crear la compra principal y obtener su id
    $compra = $this->compraRepository->create($input);

    // 2. Obtener detalles del pedido original
    $detalles = DB::table('pedido_detalles')
        ->where('id_pedido', $request->id_pedido)
        ->get();

    // 3. Insertar detalles en compra_detalles vinculados a la compra creada
    foreach ($detalles as $detalle) {
        DB::table('compra_detalles')->insert([
            'id_pedido'       => $detalle->id_pedido,
            'id_producto'     => $detalle->id_producto,
            'cantidad'        => $detalle->cantidad,
            'precio_unitario' => $detalle->precio_unitario,
            'subtotal'        => $detalle->subtotal,
            'estado'        => 'Activo',
            'created_at'      => now(),
            'updated_at'      => now(),
            'id_compra'       => $compra->id,
        ]);
        
        // 4. Actualizar stock y precio del producto
        DB::table('productos')
            ->where('id', $detalle->id_producto)
            ->update([
                'cantidad' => DB::raw("cantidad + $detalle->cantidad"),
                'precio_compra' => $detalle->precio_unitario,
            ]);
    }

    // 5. Marcar el pedido original como aplicado
    DB::table('pedidos')
        ->where('id', $request->id_pedido)
        ->update(['estado' => 'Aplicado']);

    Flash::success('Compra saved successfully.');

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
    // Cargar la compra y su pedido
    $compra = Compra::with('pedido')->findOrFail($id);

    // Cargar los detalles de la compra desde la tabla compra_detalles
    $detalles = DB::table('compra_detalles')
        ->join('productos', 'compra_detalles.id_producto', '=', 'productos.id')
        ->where('compra_detalles.id_compra', $compra->id)
        ->select(
            'productos.nombre as producto_nombre',
            'compra_detalles.cantidad',
            'compra_detalles.precio_unitario',
            'compra_detalles.subtotal'
        )
        ->get();

    $html = view('compras.ficha_compra', compact('compra', 'detalles'))->render();

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
