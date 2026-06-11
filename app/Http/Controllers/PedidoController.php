<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Repositories\PedidoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Dompdf\Dompdf;
use Response;
use DB;
use Dompdf\Options;
use App\Models\Pedido;
class PedidoController extends AppBaseController
{
    /** @var PedidoRepository $pedidoRepository*/
    private $pedidoRepository;

    public function __construct(PedidoRepository $pedidoRepo)
    {
        $this->pedidoRepository = $pedidoRepo;
    }

    /**
     * Display a listing of the Pedido.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $pedidos = DB::table('pedidos')
        ->join('proveedors', 'pedidos.id_proveedor', '=', 'proveedors.id')
        ->select(
            'pedidos.id',
            'proveedors.ci',
            'proveedors.nombre',
            'proveedors.apellido',
            'pedidos.fecha',
            'pedidos.total',
            'pedidos.estado'
        )
        ->get();
        return view('pedidos.index')
            ->with('pedidos', $pedidos);
    }
    
    public function pedido_detalles($id)
    {
        $detalles = DB::table('pedido_detalles')
            ->join('productos', 'pedido_detalles.id_producto', '=', 'productos.id')
            ->where('pedido_detalles.id_pedido', $id)
            ->select('productos.nombre as nombre_producto', 'pedido_detalles.cantidad', 'pedido_detalles.precio_unitario')
            ->get();

        return response()->json($detalles);
    }


    /**
     * Show the form for creating a new Pedido.
     *
     * @return Response
     */
    public function create()
    {
        $productos = DB::table('productos')->select('id', 'nombre','precio_venta','cantidad')->get();
        $proveedores = DB::table('proveedors')->select('id', 'nombre','apellido', 'ci')->get();
        return view('pedidos.create',compact('proveedores','productos'));
    }

    /**
     * Store a newly created Pedido in storage.
     *
     * @param CreatePedidoRequest $request
     *
     * @return Response
     */
    public function store(CreatePedidoRequest $request)
    {
        $input = $request->all();
        $input['estado'] = $input['estado'] ?? 'Pendiente';

        $pedido = $this->pedidoRepository->create($input);

         // Guardar los detalles
       foreach ($request->productos as $producto) {
            DB::table('pedido_detalles')->insert([
                'id_pedido' => $pedido->id,
                'id_producto' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $producto['cantidad'] * $producto['precio_unitario'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        Flash::success('Pedido guardado.');

        return redirect(route('pedidos.index'));
    }

    /**
     * Display the specified Pedido.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pedido = $this->pedidoRepository->find($id);

        if (empty($pedido)) {
            Flash::error('Pedido not found');

            return redirect(route('pedidos.index'));
        }

        return view('pedidos.show')->with('pedido', $pedido);
    }

    /**
     * Show the form for editing the specified Pedido.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pedido = $this->pedidoRepository->find($id);

        if (empty($pedido)) {
            Flash::error('Pedido not found');

            return redirect(route('pedidos.index'));
        }

        return view('pedidos.edit')->with('pedido', $pedido);
    }

    /**
     * Update the specified Pedido in storage.
     *
     * @param int $id
     * @param UpdatePedidoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePedidoRequest $request)
    {
        $pedido = $this->pedidoRepository->find($id);

        if (empty($pedido)) {
            Flash::error('Pedido not found');

            return redirect(route('pedidos.index'));
        }

        $pedido = $this->pedidoRepository->update($request->all(), $id);

        Flash::success('Pedido updated successfully.');

        return redirect(route('pedidos.index'));
    }

    /**
     * Remove the specified Pedido from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pedido = $this->pedidoRepository->find($id);

        if (empty($pedido)) {
            Flash::error('Pedido not found');

            return redirect(route('pedidos.index'));
        }

        $this->pedidoRepository->delete($id);

        Flash::success('Pedido deleted successfully.');

        return redirect(route('pedidos.index'));
    }
    public function ficha_pedido($id)
{
    $pedido = Pedido::with('proveedor')->findOrFail($id);
    //return $pedido;
    $detalles = DB::table('pedido_detalles')
    ->join('productos', 'pedido_detalles.id_producto', '=', 'productos.id')
    ->where('pedido_detalles.id_pedido', $pedido->id)
    ->select(
        'pedido_detalles.*',
        'productos.nombre as nombre_producto'
    )
    ->get();

    // Cargar la vista y pasar los datos
    $html = view('pedidos.ficha', compact('pedido','detalles'))->render();

    // Crear una instancia de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    // Cargar el HTML
    $dompdf->loadHtml($html);

    // (Opcional) Definir tamaño de página
     // Dimensiones para ticket: 80mm x 300mm
    $customPaper = [0, 0, 226.77, 850]; // 80mm x 300mm en puntos (1 mm = 2.83465 puntos)
    $dompdf->setPaper($customPaper);

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador
  return response($dompdf->output(), 200)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'inline; filename="recibo_' . $pedido->id_pedido . '.pdf"');

}
public function anular_pedido($id)
{
    $pedido = Pedido::findOrFail($id);
    $pedido->estado = 'Anulado';
    $pedido->save();
    Flash::success('El pedido ha sido anulado correctamente.');
    return redirect()->back()->with('success', 'El pedido ha sido anulado correctamente.');
}
}
