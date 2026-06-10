<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\Requests\CreateCajaRequest;
use App\Http\Requests\UpdateCajaRequest;
use App\Repositories\CajaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use App\Models\Caja;
use Response;
use DB;

class CajaController extends AppBaseController
{
    /** @var CajaRepository $cajaRepository*/
    private $cajaRepository;

    public function __construct(CajaRepository $cajaRepo)
    {
        $this->cajaRepository = $cajaRepo;
    }
     public function cambiarEstadoCaja(Request $request, $id)
    {
        DB::table('cajas')
            ->where('id', $id)
            ->update(['estado' => $request->estado]);

        return response()->json(['message' => 'Estado actualizado correctamente']);
    }

    /**
     * Display a listing of the Caja.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cajas = $this->cajaRepository->all();

        return view('cajas.index')
            ->with('cajas', $cajas);
    }

    /**
     * Show the form for creating a new Caja.
     *
     * @return Response
     */
    public function create()
    {
        return view('cajas.create');
    }

    /**
     * Store a newly created Caja in storage.
     *
     * @param CreateCajaRequest $request
     *
     * @return Response
     */
    public function store(CreateCajaRequest $request)
    {
        $input = $request->all();

        $caja = $this->cajaRepository->create($input);

        Flash::success('Caja saved successfully.');

        return redirect(route('cajas.index'));
    }

    /**
     * Display the specified Caja.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $caja = $this->cajaRepository->find($id);

        if (empty($caja)) {
            Flash::error('Caja not found');

            return redirect(route('cajas.index'));
        }

        return view('cajas.show')->with('caja', $caja);
    }

    /**
     * Show the form for editing the specified Caja.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $caja = $this->cajaRepository->find($id);

        if (empty($caja)) {
            Flash::error('Caja not found');

            return redirect(route('cajas.index'));
        }

        return view('cajas.edit')->with('caja', $caja);
    }

    /**
     * Update the specified Caja in storage.
     *
     * @param int $id
     * @param UpdateCajaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCajaRequest $request)
    {
        $caja = $this->cajaRepository->find($id);

        if (empty($caja)) {
            Flash::error('Caja not found');

            return redirect(route('cajas.index'));
        }

        $caja = $this->cajaRepository->update($request->all(), $id);

        Flash::success('Caja updated successfully.');

        return redirect(route('cajas.index'));
    }

    /**
     * Remove the specified Caja from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $caja = $this->cajaRepository->find($id);

        if (empty($caja)) {
            Flash::error('Caja not found');

            return redirect(route('cajas.index'));
        }

        $this->cajaRepository->delete($id);

        Flash::success('Caja deleted successfully.');

        return redirect(route('cajas.index'));
    }
    public function cierre_caja(){
        return view('cajas.cierre_caja');
    }
    public function generar_cierre(Request $request){
       $fecha_cierre = $request->input('fecha_cierre');
       $id_usuario = $request->input('id_usuario');
       $observacion = $request->input('observacion');
       $id_caja = $request->input('id_caja');
       //return $request->all();
       //Consulta de lo que hay que cobrar
       $ventas = DB::table('ventas')
        ->where('fecha_venta', $fecha_cierre)
        ->where('id_usuario', $id_usuario)
        ->where('id_caja', $id_caja) 
        ->sum('total');
        //Consulta de cobros
        $cobros = DB::table('cobros')
        ->where('fecha_cobro', $fecha_cierre)
        ->where('cajero', $id_usuario)
        ->where('id_caja', $id_caja) 
        ->sum('total');
        //Total para saber el cierre
        $total_general = $ventas + $cobros;
        //return $cobros; 

        //Obtener ultimo cierre
        $ultimoCierre = DB::table('cierres')->latest('id')->first();
        $montoInicial = $ultimoCierre ? $ultimoCierre->monto_final : 0;

         //return $montoInicial;
        //Para obtener la apertura 
        $monto_apertura_caja = DB::table('cajas')
        ->where('id','=',$id_caja)
        ->sum('apertura');

       //Inserta los datos en cierres
        DB::table('cierres')->insert([
            'id_caja'       => $id_caja,
            'id_usuario'    => $id_usuario,
            'fecha_cierre'  => $fecha_cierre,
            'fecha_apertura'  => $fecha_cierre,
            'monto_inicial' => $monto_apertura_caja,
            'monto_final'   => $total_general,
            'observaciones'   => $observacion,
        ]);
       //Actualiza el estado de la caja
       $cajas = DB::table('cajas')
        ->where('id', $id_caja)
        ->update([
            'estado'=>'Inactivo',
            'apertura' => $monto_apertura_caja,
            'cierre'   => $total_general,
            'fecha'  => $fecha_cierre,
        ]);


        return redirect()->back()->with('success', 'Cierre generado correctamente.');
        }
        public function ver_cierres(){
        $cierres = DB::table('cierres')
        ->join('cajas', 'cierres.id_caja', '=', 'cajas.id')
        ->join('users', 'cierres.id_usuario', '=', 'users.id')

        ->select(
            'cierres.*',
            'users.name',
            'cajas.nombre',
        )
        ->get();
        //return $cierres;
        return view('cajas.ver_cierres',compact('cierres'));
        }
        public function ver_rendicion_caja()
        {    
             $cajeros = DB::table('users')
                    ->where('role', '1')
                    ->get();
                        //return $cajeros;

            return view('cajas.ver_rendicion_caja', compact('cajeros'));
        }
        public function generar_rendicion_caja(Request $request){
            $fecha_inicio = $request->input('fecha_inicio') . ' 00:00:00';
            $fecha_fin = $request->input('fecha_fin') . ' 23:59:59';
            $cajeros = $request->input('cajeros');
            //return $request->all();
            $datos = DB::select("
                SELECT 
                    cobros.numero_comprobante as comprobante_cobro,
                    ventas.numero_comprobante as comprobante_venta,
                    ventas.total as total_venta,
                    nro_cuota,
                    monto,
                    saldo,
                    cobro_detalles.estado,
                    fecha_vencimiento,
                    clientes.nombre,
                    clientes.apellido,
                    clientes.ci,
                    cobros.fecha_cobro,
                    cobros.cajero,
                    users.name
                FROM cobro_detalles, cobros, ventas, clientes, users
                WHERE cobro_detalles.id_cobro = cobros.id
                AND cobro_detalles.id_venta = ventas.id
                AND ventas.id_cliente = clientes.id 
                AND cobros.cajero = users.id
                  AND cobros.fecha_cobro BETWEEN ? AND ?
                AND cobros.cajero= ?
            ", [$fecha_inicio,$fecha_fin,$cajeros]);
                $ventas = DB::select("
                SELECT 
                        ventas.numero_comprobante,
                        ventas.tipo_comprobante,
                        ventas.total,
                        ventas.estado,
                        clientes.ci,
                        clientes.nombre,
                        clientes.apellido,
                        ventas.fecha_venta,
                        GROUP_CONCAT(productos.nombre SEPARATOR ', ') AS productos
                    FROM 
                        ventas
                    JOIN 
                        detalle_ventas ON detalle_ventas.id_venta = ventas.id
                    JOIN 
                        clientes ON ventas.id_cliente = clientes.id
                    JOIN 
                        productos ON detalle_ventas.id_producto = productos.id
                    WHERE ventas.fecha_venta BETWEEN ? AND ?
                    AND ventas.id_usuario = ?
                    GROUP BY 
                        ventas.numero_comprobante,
                        ventas.tipo_comprobante,
                        ventas.total,
                        ventas.estado,
                        clientes.ci,
                        clientes.nombre,
                        clientes.apellido,
                        ventas.fecha_venta
                ", [$fecha_inicio, $fecha_fin, $cajeros]);


                $html = view('cajas.reporte_rendicion', compact('datos','ventas','fecha_inicio','fecha_fin'))->render();

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isPhpEnabled', true);

                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'landscape'); // horizontal

                $dompdf->render();

                $pdfOutput = $dompdf->output();
                // Enviar el PDF al navegador
              return Response::make($pdfOutput, 200, [
                    'Content-Type'        => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="reporte_rendicion.pdf"',
                    'Cache-Control'       => 'public, must-revalidate, max-age=0',
                    'Pragma'              => 'public',
                    'Expires'             => '0',
                ]);
                }
        public function apertura_caja(Request $request, $id)
        {
        
            $caja = Caja::findOrFail($id);
            $caja->apertura = $request->monto_apertura;
            $caja->fecha = now();
            $caja->estado = 'Activo';
            $caja->save();

            return redirect()->back()->with('success', 'Caja abierta correctamente.');
        }


}
