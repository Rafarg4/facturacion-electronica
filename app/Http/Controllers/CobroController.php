<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use Dompdf\Options; // Asegúrate de que esta línea esté incluida
use App\Http\Requests\CreateCobroRequest;
use App\Http\Requests\UpdateCobroRequest;
use App\Repositories\CobroRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Cobro;
class CobroController extends AppBaseController
{
    /** @var CobroRepository $cobroRepository*/
    private $cobroRepository;

    public function __construct(CobroRepository $cobroRepo)
    {
        $this->cobroRepository = $cobroRepo;
    }

    /**
     * Display a listing of the Cobro.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
       $cobros = DB::table('cobros')
        ->join('clientes', 'cobros.id_cliente', '=', 'clientes.id')
        ->join('ventas', 'cobros.id_venta', '=', 'ventas.id')
        ->join('users', 'cobros.cajero', '=', 'users.id')

        ->select(
            'clientes.nombre',
            'users.name',
            'cobros.id',
            'clientes.apellido',
            'clientes.ci',
            'cobros.fecha_cobro',
            'cobros.cajero',
            'cobros.observacion',
            'ventas.numero_comprobante',
            'ventas.total as total_venta',
            'cobros.total as total_cobro',
            'cobros.estado',
        )
        ->get();
        return view('cobros.index')
            ->with('cobros', $cobros);
    } 
     public function numero_comprobante_cobro(Request $request)
        {

           $ultimo = \DB::table('cobros')
                ->max('numero_comprobante');

            $nuevo = $ultimo ? $ultimo + 1 : 1;

            return response()->json(['numero' => $nuevo]);
        }

    /**
     * Show the form for creating a new Cobro.
     *
     * @return Response
     */
    public function create()
    {
        $clientes = DB::table('clientes')->select('id', 'nombre','apellido', 'ci')->get();
        return view('cobros.create',compact('clientes'));
    }
    public function ventasCreditoPorCliente($id)
    {
        $ventas = Venta::where('id_cliente', $id)
                       ->where('condicion_venta', 'credito')
                       ->get(['id', 'numero_comprobante', 'total']);

        return response()->json($ventas);
    }
    public function saldosPorVenta($id_venta)
    {
       $saldos = DB::table('saldo_ventas')
        ->where('id_venta', $id_venta)
        ->where('saldo','>', 0)
        ->get();

    return response()->json($saldos);
    }

    /**
     * Store a newly created Cobro in storage.
     *
     * @param CreateCobroRequest $request
     *
     * @return Response
     */
    public function store(CreateCobroRequest $request)
    {
        DB::beginTransaction();

        try {
            // Guardar cabecera
            $input = $request->all();
            //return $input;
             $input['estado'] = $input['estado'] ?? 'Activo';
            $cobro = $this->cobroRepository->create($input);

            // Procesar detalles seleccionados
            $cuotas = $request->input('cuotas'); // array con los datos

            if ($cuotas && is_array($cuotas)) {
                foreach ($cuotas as $saldoId => $detalle) {
                    // Obtener el saldo actual
                    $saldo = DB::table('saldo_ventas')->where('id', $saldoId)->first();
                    if (!$saldo) continue;

                    $montoPagado = floatval($detalle['pagado']);
                    $nuevoSaldo = $saldo->saldo - $montoPagado;
                    $estado = $nuevoSaldo <= 0 ? 'Pagado' : 'Parcial';

                    // Insertar en detalle de cobros
                    DB::table('cobro_detalles')->insert([
                        'id_cobro' => $cobro->id,
                        'id_venta' => $saldo->id_venta,
                        'nro_cuota' => $saldo->numero_cuota,
                        'monto' => $saldo->monto,
                        'saldo' => $montoPagado,
                        'estado' => $estado,
                        'fecha_vencimiento' => $saldo->fecha_vencimiento,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Actualizar la tabla de saldo_ventas
                    DB::table('saldo_ventas')
                        ->where('id', $saldoId)
                        ->update([
                            'saldo' => $nuevoSaldo,
                            'estado' => $estado,
                            'pagado' => DB::raw('pagado + ' . $montoPagado),
                            'updated_at' => now(),
                        ]);
                }
            }
             DB::commit(); 
            Flash::success('Cobro guardado correctamente.');
            return redirect(route('cobros.index'));

        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error al guardar el cobro: ' . $e->getMessage());
        
        }
    }
  public function anular($id)
{
    DB::beginTransaction();


        // Verificar si el cobro existe
        $cobro = DB::table('cobros')->where('id', $id)->first();
        if (!$cobro) {
            return redirect()->back()->with('error', 'Cobro no encontrado.');
        }

        // Cambiar el estado del cobro a 'Anulado'
        DB::table('cobros')->where('id', $id)->update([
            'estado' => 'Anulado'
        ]);

        // Obtener los detalles del cobro
        $detalles = DB::table('cobro_detalles')->where('id_cobro', $id)->get();
        //return $detalles;
        foreach ($detalles as $detalle) {
            // Cambiar el estado del detalle a 'Anulado'
            DB::table('cobro_detalles')->where('id', $detalle->id)->update([
                'estado' => 'Anulado'
            ]);

            // Calcular el monto pagado
            $montoPagado = $detalle->saldo;

            // Devolver el monto pagado al saldo_ventas usando id_venta y nro_cuota
           $prueba= DB::table('saldo_ventas')
                ->where('id_venta', $detalle->id_venta)
                ->where('numero_cuota', $detalle->nro_cuota)
                ->increment('saldo', $montoPagado);
            
        }


        DB::commit();
        return redirect()->back()->with('success', 'Cobro anulado correctamente.');

    
}


    /**
     * Display the specified Cobro.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cobro = $this->cobroRepository->find($id);

        if (empty($cobro)) {
            Flash::error('Cobro not found');

            return redirect(route('cobros.index'));
        }

        return view('cobros.show')->with('cobro', $cobro);
    }

    /**
     * Show the form for editing the specified Cobro.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cobro = $this->cobroRepository->find($id);

        if (empty($cobro)) {
            Flash::error('Cobro not found');

            return redirect(route('cobros.index'));
        }

        return view('cobros.edit')->with('cobro', $cobro);
    }

    /**
     * Update the specified Cobro in storage.
     *
     * @param int $id
     * @param UpdateCobroRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCobroRequest $request)
    {
        $cobro = $this->cobroRepository->find($id);

        if (empty($cobro)) {
            Flash::error('Cobro not found');

            return redirect(route('cobros.index'));
        }

        $cobro = $this->cobroRepository->update($request->all(), $id);

        Flash::success('Cobro updated successfully.');

        return redirect(route('cobros.index'));
    }

    /**
     * Remove the specified Cobro from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cobro = $this->cobroRepository->find($id);

        if (empty($cobro)) {
            Flash::error('Cobro not found');

            return redirect(route('cobros.index'));
        }

        $this->cobroRepository->delete($id);

        Flash::success('Cobro deleted successfully.');

        return redirect(route('cobros.index'));
    }
        public function cobro_recibo($id)
        {
            $cobros = DB::table('cobros')
            ->join('users', 'cobros.cajero', '=', 'users.id')
            ->join('ventas', 'cobros.id_venta', '=', 'ventas.id')
            ->where('cobros.id', $id)
            ->select('cobros.*',
             'users.name',
             'ventas.numero_comprobante as comprobante_venta',
             'cobros.numero_comprobante as comprobante_cobro',
             'cobros.total as total_cobro',
                'ventas.total as total_venta')
            ->first(); // ← devuelve un solo objeto   
            //return $cobros;
            $cliente = Cliente::find($cobros->id_cliente);
            $detalles = DB::table('cobro_detalles')
            ->join('cobros', 'cobro_detalles.id_cobro', '=', 'cobros.id')
            ->where('cobro_detalles.id_cobro', $cobros->id)
            ->select(
                'cobros.*',
                'cobro_detalles.*'
            )
            ->get();
            //return $detalles;
            // Cargar la vista y pasar los datos
            $html = view('cobros.recibos', compact('cobros', 'cliente', 'detalles'))->render();

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
        ->header('Content-Disposition', 'inline; filename="recibo_'.$cobros->numero_comprobante.'.pdf"');

        }

        public function ver_cobros_pendientes(){
            return view('cobros.ver_cobros_pendientes');
        }

        public function reporte_cobros_pendientes(Request $request){
             $fecha_inicio = $request->input('fecha_inicio') . ' 00:00:00';
            $fecha_fin = $request->input('fecha_fin') . ' 23:59:59';
            //return $request->all();
            $datos = DB::select("
               SELECT clientes.ci, clientes.nombre,clientes.apellido, saldo_ventas.monto, saldo_ventas.saldo, saldo_ventas.numero_cuota, saldo_ventas.estado, saldo_ventas.fecha_vencimiento 
                FROM clientes, saldo_ventas 
                WHERE clientes.id = saldo_ventas.id_cliente 
                AND saldo_ventas.fecha_vencimiento BETWEEN ? AND ?
                AND saldo_ventas.saldo >0
            ",[$fecha_inicio,$fecha_fin]);
                //return $datos;
                $html = view('cobros.reporte_cobros_pendientes', compact('datos'))->render();

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isPhpEnabled', true);

                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'landscape'); // horizontal

                $dompdf->render();

                return response($dompdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="reporte_cobro_pendiente.pdf"');
        }

}
 