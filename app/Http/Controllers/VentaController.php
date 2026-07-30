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
use App\Models\Empresa;
use App\Services\FacturacionElectronicaService;
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
        ->orderByRaw('CAST(ventas.numero_comprobante AS UNSIGNED) DESC')
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
        $clientes = DB::table('clientes')->select('id', 'nombre', 'apellido', 'ci')->whereNull('deleted_at')->get();
        $cotizaciones = DB::table('cotizacions')->whereNull('deleted_at')->get()->keyBy('tipo_moneda');
        $empresa = Empresa::first();
        //return $cotizaciones;
        return view('ventas.create', compact('clientes', 'cotizaciones', 'empresa'));
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

        // Laravel convierte los campos vacíos ('') en null antes de llegar aquí, y
        // moneda/tipo_cambio quedan vacíos cuando la venta es en Guaraníes.
        $input['moneda'] = $input['moneda'] ?? 'PYG';
        $input['tipo_cambio'] = $input['tipo_cambio'] ?? '0';

        // La columna 'observacion' es NOT NULL en la BD, pero el campo no es obligatorio en el formulario.
        $input['observacion'] = $input['observacion'] ?? 'Sin observación';

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
        $facturacionElectronicaHabilitada = (bool) optional(Empresa::first())->facturacion_electronica;

        if ($venta->enviar_factura && !$facturacionElectronicaHabilitada) {
            Flash::warning('Venta guardada. La facturación electrónica no está habilitada para esta empresa.');
        } elseif ($venta->enviar_factura && $venta->tipo_comprobante === 'Factura') {
            app(FacturacionElectronicaService::class)->emitir($venta);
            $venta->refresh();

            if (in_array($venta->estado_sifen, ['aprobado', 'aprobado_con_observacion'])) {
                Flash::success('Venta guardada y factura electrónica aprobada (CDC: '.$venta->cdc.').');
            } else {
                Flash::warning('Venta guardada, pero la factura electrónica no quedó aprobada. Estado: '.($venta->estado_sifen ?? 'desconocido').'. '.$venta->mensaje_sifen);
            }
        } elseif ($venta->enviar_factura) {
            Flash::warning('Venta guardada. No se envió a facturación electrónica porque el comprobante no es "Factura".');
        } else {
            Flash::success('Venta guardada correctamente.');
        }

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

    public function reenviarSifen($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            Flash::error('Venta no encontrada.');

            return redirect(route('ventas.index'));
        }

        if (!$venta->cdc || !in_array($venta->estado_sifen, ['rechazado', 'error'])) {
            Flash::error('Solo se puede reenviar una factura electrónica rechazada o con error.');

            return redirect(route('ventas.index'));
        }

        app(FacturacionElectronicaService::class)->reenviar($venta);
        $venta->refresh();

        if (in_array($venta->estado_sifen, ['aprobado', 'aprobado_con_observacion'])) {
            Flash::success('Factura electrónica reenviada y aprobada (CDC: '.$venta->cdc.').');
        } elseif ($venta->estado_sifen === 'pendiente') {
            Flash::success('Factura reenviada. Quedó pendiente de validación en SIFEN, consultá el estado en unos segundos.');
        } else {
            Flash::warning('Factura reenviada, pero no quedó aprobada. Estado: '.($venta->estado_sifen ?? 'desconocido').'. '.$venta->mensaje_sifen);
        }

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
        'productos.descripcion as nombre_producto',
        'productos.tipo_moneda'
    )
    ->get();
    $cotizaciones = DB::table('cotizacions')->whereNull('deleted_at')->get()->keyBy('tipo_moneda');
    // Cargar la vista y pasar los datos
    $html = view('ventas.recibo', compact('venta', 'cliente', 'detalles', 'cotizaciones'))->render();

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
    $empresa = Empresa::first();

    $detalles = DB::table('detalle_ventas')
        ->join('productos', 'detalle_ventas.id_producto', '=', 'productos.id')
        ->where('detalle_ventas.id_venta', $venta->id)
        ->select('detalle_ventas.*', 'productos.descripcion as nombre_producto', 'productos.codigo', 'productos.tipo_moneda')
        ->get();

    $cotizaciones = DB::table('cotizacions')->whereNull('deleted_at')->get()->keyBy('tipo_moneda');
    $koapeCredencial = \App\Models\KoapeCredencial::first();

    $html = view('ventas.factura', compact('venta', 'cliente', 'detalles', 'empresa', 'cotizaciones', 'koapeCredencial'))->render();

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

public function facturasElectronicas()
{
    $estadosFinales = ['aprobado', 'aprobado_con_observacion', 'rechazado'];

    $pendientes = Venta::whereNotNull('cdc')
        ->whereNull('deleted_at')
        ->where(function ($q) use ($estadosFinales) {
            $q->whereNotIn('estado_sifen', $estadosFinales)
              ->orWhereNull('estado_sifen');
        })
        ->get();

    $service = app(FacturacionElectronicaService::class);
    foreach ($pendientes as $venta) {
        $service->consultarEstado($venta);
    }

    $facturas = DB::table('ventas')
        ->join('clientes', 'ventas.id_cliente', '=', 'clientes.id')
        ->whereNotNull('ventas.cdc')
        ->whereNull('ventas.deleted_at')
        ->select('ventas.*', 'clientes.nombre', 'clientes.apellido')
        ->orderByDesc('ventas.id')
        ->get();

    return view('ventas.facturas_electronicas', compact('facturas'));
}

public function verKude($id)
{
    $venta = Venta::findOrFail($id);

    $pdf = $venta->kude_base64 ? base64_decode($venta->kude_base64) : null;

    if (!$pdf) {
        $pdf = app(FacturacionElectronicaService::class)->obtenerKudePdf($venta);
    }

    if (!$pdf) {
        Flash::error('No se pudo obtener el KuDE desde Koape (todavía no está aprobado, o no hay CDC).');

        return redirect(route('facturas_electronicas.index'));
    }

    return response($pdf, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="kude_'.$venta->cdc.'.pdf"');
}

public function verReporteFacturas()
{
    $clientes = Cliente::whereNull('deleted_at')
        ->orderBy('nombre')
        ->get(['id', 'nombre', 'apellido', 'ci']);

    return view('ventas.ver_reporte_facturas', compact('clientes'));
}

public function reporteFacturasPdf(Request $request)
{
    $fecha_desde = $request->input('fecha_desde');
    $fecha_hasta = $request->input('fecha_hasta');
    $id_cliente  = $request->input('id_cliente');

    $query = DB::table('ventas')
        ->join('clientes', 'ventas.id_cliente', '=', 'clientes.id')
        ->whereNull('ventas.deleted_at')
        ->whereNull('clientes.deleted_at')
        ->whereDate('ventas.fecha_venta', '>=', $fecha_desde)
        ->whereDate('ventas.fecha_venta', '<=', $fecha_hasta)
        ->select(
            'ventas.*',
            'clientes.nombre',
            'clientes.apellido',
            'clientes.ci',
            'clientes.tipo_documento',
            'clientes.direccion',
            'clientes.telefono'
        )
        ->orderBy('ventas.fecha_venta', 'asc');

    if (!empty($id_cliente)) {
        $query->where('ventas.id_cliente', $id_cliente);
    }

    $ventas = $query->get();

    $cliente_nombre = null;
    if (!empty($id_cliente)) {
        $cliente = Cliente::find($id_cliente);
        $cliente_nombre = $cliente ? trim($cliente->nombre.' '.$cliente->apellido) : null;
    }

    $html = view('ventas.reporte_facturas_pdf', compact('ventas', 'fecha_desde', 'fecha_hasta', 'cliente_nombre'))->render();

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    return Response::make($dompdf->output(), 200, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => 'inline; filename="reporte_facturas.pdf"',
    ]);
}

}
