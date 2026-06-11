<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Repositories\VentaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Dompdf\Dompdf;
use DB;
use App\Models\Venta;
use App\Models\Cliente;
use Dompdf\Options; // Asegúrate de que esta línea esté incluida

class VentaController extends AppBaseController
{
    /** @var VentaRepository $ventaRepository*/
    private $ventaRepository;

    public function __construct(VentaRepository $ventaRepo)
    {
        $this->ventaRepository = $ventaRepo;
    }

    /**
     * Display a listing of the Venta.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $ventas =DB::table('ventas')
        ->join('clientes', 'ventas.id_cliente', '=', 'clientes.id')
        ->whereNull('ventas.deleted_at')
        ->whereNull('clientes.deleted_at')
        ->select('ventas.*', 'clientes.nombre', 'clientes.apellido') // o '*'
        ->get();


        return view('ventas.index')
            ->with('ventas', $ventas); 
    }

    /** 
     * Show the form for creating a new Venta.
     *
     * @return Response
     */
    public function create()
    {
        $productos = DB::table('productos')->select('id', 'nombre','precio_venta','cantidad')->get();
        $clientes = DB::table('clientes')->select('id', 'nombre','apellido', 'ci')->get();
        //return $clientes;
        return view('ventas.create',compact('productos','clientes'));
    }
    public function obtenerSiguienteNumero(Request $request)
    {
        $tipo = $request->tipo_comprobante;

       $ultimo = \DB::table('ventas')
            ->where('tipo_comprobante', $tipo)
            ->max('numero_comprobante');

        $nuevo = $ultimo ? $ultimo + 1 : 1;

        return response()->json(['numero' => $nuevo]);
    }


    /**
     * Store a newly created Venta in storage.
     *
     * @param CreateVentaRequest $request
     *
     * @return Response
     */
    public function store(CreateVentaRequest $request)
    {
        // Recibir todos los datos del formulario
        $input = $request->all();
        //return $request->all();
        // Establecer el estado por defecto
        $input['estado'] = $input['estado'] ?? 'Activo';

        // Crear la venta principal
        $venta = $this->ventaRepository->create($input);

       // Obtener los detalles de la venta desde el request
        $id_productos = $request->input('id_producto');  // Array de productos
        $cantidades = $request->input('cantidad');      // Array de cantidades
        $precios = $request->input('precio_unitario');  // Array de precios unitarios
        $subtotales = $request->input('subtotal');     // Array de subtotales

        // Verificar que los arrays tienen la misma longitud
        if (count($id_productos) == count($cantidades) && count($cantidades) == count($precios) && count($precios) == count($subtotales)) {
            // Guardar los detalles de la venta usando DB::table
            foreach ($id_productos as $index => $id_producto) {
                // Insertar cada detalle de la venta en la tabla 'detalle_ventas'
                DB::table('detalle_ventas')->insert([
                    'id_venta' => $venta->id,  // Asociamos el detalle a la venta principal
                    'id_producto' => $id_producto,
                    'cantidad' => $cantidades[$index],
                    'precio_unitario' => $precios[$index],
                    'subtotal' => $subtotales[$index],
                ]);
                    // Descontar del stock
                DB::table('productos')
                    ->where('id', $id_producto)
                    ->decrement('cantidad', $cantidades[$index]);
                }
        } else {
            // Si los arrays no coinciden en tamaño, lanzar un error
            Flash::error('Error en los detalles de la venta. Los datos no coinciden.');
          //  return redirect(route('ventas.index'));
        }
       // 👉 Agregar cuotas si la condición es "credito"
        if ($request->condicion_venta === 'credito') {
            $plazo = (int) $request->plazo; // 30, 60 o 90
            $cuotas = $plazo / 30; // Para obtener 1, 2 o 3
            $total = floatval($request->total); // Total de la venta
            $montoCuota = round($total / $cuotas, 2); // Monto por cuota

            // Insertar las cuotas en saldo_ventas
            for ($i = 1; $i <= $cuotas; $i++) {
                DB::table('saldo_ventas')->insert([
                    'id_venta' => $venta->id,  // Referencia a la venta principal
                    'id_cliente' => $venta->id_cliente,
                    'monto' => $montoCuota,
                    'saldo' => $montoCuota,     // Monto de la cuota
                    'numero_cuota' => $i,       // Número de cuota (1, 2, 3)
                    'fecha_vencimiento' => now()->addDays(30 * $i),  // Fecha de vencimiento (30, 60, 90 días)
                    'pagado' => false,          // Estado "no pagado"
                    'estado' => 'Pendiente',    // Estado "Pendiente"
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        // Mensaje de éxito
        Flash::success('Venta guardada correctamente.');
        // Redirigir a la vista de ventas
        return redirect(route('ventas.index'));
    }
    public function anular($id)
{
    // Buscar la venta
    $venta = Venta::find($id);

    // Verificar si existe y no está ya anulada
    if (!$venta || $venta->estado === 'Anulado') {
        Flash::error('Venta no encontrada o ya está anulada.');
        return redirect(route('ventas.index'));
    }

    // Cambiar el estado de la venta
    $venta->estado = 'Anulado';
    $venta->save();

    // Obtener los detalles de la venta
    $detalles = DB::table('detalle_ventas')->where('id_venta', $venta->id)->get();

    // Devolver stock
    foreach ($detalles as $detalle) {
        DB::table('productos')->where('id', $detalle->id_producto)
            ->increment('cantidad', $detalle->cantidad);
    }

    Flash::success('Venta anulada y stock restablecido.');
    return redirect(route('ventas.index'));
}


    /**
     * Display the specified Venta.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $venta = $this->ventaRepository->find($id);

        if (empty($venta)) {
            Flash::error('Venta not found');

            return redirect(route('ventas.index'));
        }

        return view('ventas.show')->with('venta', $venta);
    }

    /**
     * Show the form for editing the specified Venta.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $venta = $this->ventaRepository->find($id);

        if (empty($venta)) {
            Flash::error('Venta not found');

            return redirect(route('ventas.index'));
        }

        return view('ventas.edit')->with('venta', $venta);
    }

    /**
     * Update the specified Venta in storage.
     *
     * @param int $id
     * @param UpdateVentaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVentaRequest $request)
    {
        $venta = $this->ventaRepository->find($id);

        if (empty($venta)) {
            Flash::error('Venta not found');

            return redirect(route('ventas.index'));
        }

        $venta = $this->ventaRepository->update($request->all(), $id);

        Flash::success('Venta updated successfully.');

        return redirect(route('ventas.index'));
    }

    /**
     * Remove the specified Venta from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $venta = $this->ventaRepository->find($id);

        if (empty($venta)) {
            Flash::error('Venta not found');

            return redirect(route('ventas.index'));
        }

        $this->ventaRepository->delete($id);

        Flash::success('Venta deleted successfully.');

        return redirect(route('ventas.index'));
    }
    public function generarComprobante($id)
{
    $venta = Venta::find($id);
    $cliente = Cliente::find($venta->id_cliente);
   $detalles = DB::table('detalle_ventas')
    ->join('productos', 'detalle_ventas.id_producto', '=', 'productos.id')
    ->where('detalle_ventas.id_venta', $venta->id)
    ->select(
        'detalle_ventas.*',
        'productos.nombre as nombre_producto'
    )
    ->get();
    // Cargar la vista y pasar los datos
    $html = view('ventas.recibo', compact('venta', 'cliente', 'detalles'))->render();

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
    ->header('Content-Disposition', 'inline; filename="recibo_' . $venta->numero_comprobante . '.pdf"');

}
public function generar_factura($id)
{
    $venta = Venta::find($id);
    $cliente = Cliente::find($venta->id_cliente);

    $detalles = DB::table('detalle_ventas')
        ->join('productos', 'detalle_ventas.id_producto', '=', 'productos.id')
        ->where('detalle_ventas.id_venta', $venta->id)
        ->select('detalle_ventas.*', 'productos.nombre as nombre_producto')
        ->get();

    $html = view('ventas.factura', compact('venta', 'cliente', 'detalles'))->render();

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($html);

    // ✅ Formato A4 vertical
    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    return response($dompdf->output(), 200)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'inline; filename="factura_' . $venta->numero_comprobante . '.pdf"');
}

}
