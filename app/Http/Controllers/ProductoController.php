<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Repositories\ProductoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\ProductoController;
use App\Models\Rubro;
use App\Models\Producto;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Response;
use DB;
class ProductoController extends AppBaseController
{
    /** @var ProductoRepository $productoRepository*/
    private $productoRepository;

    public function __construct(ProductoRepository $productoRepo)
    {
        $this->productoRepository = $productoRepo;
    }

    /**
     * Display a listing of the Producto.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index()
{
    return view('productos.index');
}

public function buscar(Request $request)
{
    $q = $request->input('q', '');

    $resultados = DB::table('productos')
        ->select('id', 'codigo', 'descripcion', 'precio1', 'precio2', 'precio3', 'cantidad', 'tipo_moneda')
        ->whereNull('deleted_at')
        ->where(function ($query) use ($q) {
            $query->where('descripcion', 'like', '%' . $q . '%')
                  ->orWhere('codigo', 'like', '%' . $q . '%');
        })
        ->orderBy('descripcion')
        ->limit(30)
        ->get()
        ->map(function ($p) {
            return [
                'id'      => $p->descripcion,
                'text'    => ($p->codigo ? '[' . $p->codigo . '] ' : '') . $p->descripcion,
                'codigo'      => $p->codigo,
                'precio1'     => $p->precio1 ?? 0,
                'precio2'     => $p->precio2 ?? 0,
                'precio3'     => $p->precio3 ?? 0,
                'stock'       => $p->cantidad ?? 0,
                'tipo_moneda' => $p->tipo_moneda ?? 0,
            ];
        });

    return response()->json(['results' => $resultados->values()]);
}

public function paraVenta(Request $request)
{
    $q = trim($request->input('q', ''));

    $query = DB::table('productos')
        ->select('id', 'codigo', 'descripcion', 'precio1', 'cantidad', 'tipo_moneda')
        ->whereNull('deleted_at');

    if ($q !== '') {
        $query->where(function ($sub) use ($q) {
            $sub->where('descripcion', 'like', '%' . $q . '%')
                ->orWhere('codigo', 'like', '%' . $q . '%');
        });
    }

    $productos = $query->orderBy('descripcion')->limit(10)->get();

    return response()->json(['data' => $productos]);
}

public function paraCompra(Request $request)
{
    $q = trim($request->input('q', ''));

    $query = DB::table('productos')
        ->select('id', 'codigo', 'descripcion', 'costo', 'cantidad')
        ->whereNull('deleted_at');

    if ($q !== '') {
        $query->where(function ($sub) use ($q) {
            $sub->where('descripcion', 'like', '%' . $q . '%')
                ->orWhere('codigo', 'like', '%' . $q . '%');
        });
    }

    $productos = $query->orderBy('descripcion')->limit(10)->get();

    return response()->json(['data' => $productos]);
}

public function data(Request $request)
{
    $query = DB::table('productos')
        ->leftJoin('rubros', 'productos.id_rubro', '=', 'rubros.descripcion')
        ->select(
            'productos.id',
            'productos.codigo',
            'productos.num_item',
            'productos.descripcion',
            'productos.cantidad',
            'productos.cantidad_minima',
            'productos.precio1',
            'productos.costo',
            'productos.estado',
            DB::raw('COALESCE(rubros.descripcion,"") as rubro_descripcion')
        );

    return DataTables::of($query)

        ->filterColumn('rubro_descripcion', function ($query, $keyword) {
            $query->where('rubros.descripcion', 'like', "%{$keyword}%");
        })

        ->editColumn('precio1', function ($producto) {
            return number_format($producto->precio1, 2, ',', '.');
        })

        ->editColumn('costo', function ($producto) {
            return number_format($producto->costo, 2, ',', '.');
        })

        ->addColumn('estado_switch', function ($producto) {

            $checked = $producto->estado === 'Activo' ? 'checked' : '';

            return '
                <div class="form-check form-switch">
                    <input class="form-check-input"
                        type="checkbox"
                        id="estadoSwitch'.$producto->id.'"
                        '.$checked.'
                        onchange="cambiarEstado('.$producto->id.', this.checked)">
                </div>
            ';
        })

        ->addColumn('acciones', function ($producto) {

            $show = route('productos.show', $producto->id);
            $edit = route('productos.edit', $producto->id);
            $delete = route('productos.destroy', $producto->id);

            return '
                <div class="d-flex">
                    <a href="'.$show.'" class="btn btn-success btn-sm mr-1" title="Ver Producto">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="'.$edit.'" class="btn btn-primary btn-sm mr-1" title="Editar Producto">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="'.$delete.'" method="POST" style="display:inline">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                title="Eliminar Producto"
                                onclick="return confirm(\'¿Estás seguro de eliminar este producto?\')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            ';
        })

        ->rawColumns(['estado_switch', 'acciones'])
        ->make(true);
}

    /**
     * Show the form for creating a new Producto.
     *
     * @return Response
     */
    public function create()
    {
     $categorias = DB::table('categorias')->select('id', 'nombre')->get();
     $lista_precios = DB::table('lista_precios')->select('id', 'descripcion', 'porcentaje', 'codigo_lista_precio')
    ->where('estado', 'Activo')
    ->whereIn('codigo_lista_precio', [1, 2, 3])
    ->orderBy('codigo_lista_precio')
    ->get();
    $proveedores = DB::table('proveedors')->select('id', 'nombre', 'apellido','ci')->get();
    $rubros = DB::table('rubros')->select('id', 'descripcion')
    ->where('estado', 'S')
    ->get();
    return view('productos.create', compact('proveedores','categorias', 'rubros', 'lista_precios')); // Pasar a la vista
    }
   public function cambiarEstado(Request $request, $id)
    {
        DB::table('productos')
            ->where('id', $id)
            ->update(['estado' => $request->estado]);

        return response()->json(['message' => 'Estado actualizado correctamente']);
    }
    /**
     * Store a newly created Producto in storage.
     *
     * @param CreateProductoRequest $request
     *
     * @return Response
     */
   public function store(CreateProductoRequest $request)
        {
            $input = $request->all();
            $input['estado'] = 'Activo';
            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');
                $nombreImagen = time() . '_' . $archivo->getClientOriginalName();
                $archivo->move(public_path('imagenes_productos'), $nombreImagen);
                $input['imagen'] = $nombreImagen;
            }
            $producto = $this->productoRepository->create($input);
            Flash::success('Producto guardado correctamente.');
            return redirect(route('productos.index'));
        }
    /**
     * Display the specified Producto.
     *
     * @param int $id
     *
     * @return Response
     */
   public function show($id)
    {
        $producto = DB::table('productos as p')
            ->leftJoin('rubros as r', 'p.id_rubro', '=', 'r.id')
            ->select(
                'p.id',
                'p.codigo',
                'p.num_item',
                
                'p.descripcion',
                'p.imagen',
                'p.id_rubro',
                'r.descripcion as rubro',
                'p.cantidad',
                'p.costo',
                'p.precio1',
                'p.precio2',
                'p.precio3',
                'p.cantidad_minima',
                'p.cantidad_caja',
                'p.estado',
                'p.created_at',
                'p.updated_at'
            )
            ->where('p.id', $id)
            ->first();
           //return $producto;

        if (!$producto) {
            Flash::error('Producto no encontrado');
            return redirect(route('productos.index'));
        }

        return view('productos.show', compact('producto'));
    }
    /**
     * Show the form for editing the specified Producto.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $producto = $this->productoRepository->find($id);

        if (empty($producto)) {
            Flash::error('Producto not found');

            return redirect(route('productos.index'));
        }

        $rubros = DB::table('rubros')->select('id', 'descripcion')->orderBy('descripcion')->get();

        $lista_precios = DB::table('lista_precios')->select('id', 'descripcion', 'porcentaje', 'codigo_lista_precio')
            ->where('estado', 'Activo')
            ->whereIn('codigo_lista_precio', [1, 2, 3])
            ->orderBy('codigo_lista_precio')
            ->get();

        return view('productos.edit')
            ->with('producto', $producto)
            ->with('rubros', $rubros)
            ->with('lista_precios', $lista_precios);
    }

    /**
     * Update the specified Producto in storage.
     *
     * @param int $id
     * @param UpdateProductoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductoRequest $request)
    {
        $producto = $this->productoRepository->find($id);

        if (empty($producto)) {
            Flash::error('Producto not found');

            return redirect(route('productos.index'));
        }

        $input = $request->all();

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreImagen = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('imagenes_productos'), $nombreImagen);
            $input['imagen'] = $nombreImagen;
        } else {
            unset($input['imagen']);
        }

        $producto = $this->productoRepository->update($input, $id);

        Flash::success('Producto updated successfully.');

        return redirect(route('productos.index'));
    }

    public function generarReporteStock(Request $request)
    {    ini_set('memory_limit', '1024M');
         set_time_limit(0);
        $date = date('Y-m-d');
        $productos = Producto::query();

        if (!empty($request->id_rubro)) {
            $productos->where('id_rubro', $request->id_rubro);
        }

        if ($request->tipo_reporte == 'stock_minimo') {

            $productos->whereColumn(
                'cantidad',
                '<=',
                'cantidad_minima'
            );

        } elseif ($request->tipo_reporte == 'solo_stock') {

            $productos->where('cantidad', '>', 0);

        }

        $productos = $productos
            ->orderBy('descripcion')
            ->get();
//dd($productos->count());
        $empresa = Empresa::first();

        $tipo_reporte = $request->tipo_reporte;

        $pdf = Pdf::loadView(
            'productos.pdf_stock',
            compact(
                'productos',
                'empresa',
                'tipo_reporte',
                'date'
            )
        );

return view(
    'productos.pdf_stock',
    compact(
        'productos',
        'empresa',
        'tipo_reporte',
        'date'
    )
);
    }
public function verReporteStock()
{
    $rubros = Rubro::orderBy('descripcion')->get();

    return view(
        'productos.ver_reporte_stock',
        compact('rubros')
    );
}

public function consultaPrecio()
{
    return view('productos.consulta_precio');
}

public function buscarPrecio(Request $request)
{
    $producto = DB::table('productos')
        ->where('codigo', $request->codigo)
        ->first();

    if (!$producto) {
        return response()->json([
            'encontrado' => false
        ]);
    }

    return response()->json([
        'encontrado'   => true,
        'descripcion'  => $producto->descripcion,
        'num_item'     => $producto->num_item,
        'id_rubro'     => $producto->id_rubro,
        'cantidad'     => $producto->cantidad,
        'precio1'      => $producto->precio1,
        'precio2'      => $producto->precio2,
        'precio3'      => $producto->precio3,
        'codigo'       => $producto->codigo,
        'imagen'       => $producto->imagen ? asset('imagenes_productos/' . $producto->imagen) : null,
    ]);
}

    public function buscarParaFiltro(Request $request)
    {
        $q = $request->input('q', '');

        $resultados = DB::table('productos')
            ->select('id', 'codigo', 'descripcion')
            ->whereNull('deleted_at')
            ->where(function ($query) use ($q) {
                $query->where('descripcion', 'like', '%' . $q . '%')
                      ->orWhere('codigo', 'like', '%' . $q . '%');
            })
            ->orderBy('descripcion')
            ->limit(30)
            ->get()
            ->map(fn($p) => [
                'id'   => $p->id,
                'text' => ($p->codigo ? '[' . $p->codigo . '] ' : '') . $p->descripcion,
            ]);

        return response()->json(['results' => $resultados->values()]);
    }

    public function movimientoPdf(Request $request)
    {
        $id_producto = $request->input('id_producto');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');

        $salidas = DB::table('detalle_ventas')
            ->join('ventas', 'detalle_ventas.id_venta', '=', 'ventas.id')
            ->join('productos', 'detalle_ventas.id_producto', '=', 'productos.id')
            ->join('clientes', 'ventas.id_cliente', '=', 'clientes.id')
            ->whereNull('ventas.deleted_at')
            ->where('ventas.estado', '!=', 'Anulado')
            ->when($id_producto, fn($q) => $q->where('detalle_ventas.id_producto', $id_producto))
            ->when($fecha_desde, fn($q) => $q->whereDate('ventas.fecha_venta', '>=', $fecha_desde))
            ->when($fecha_hasta, fn($q) => $q->whereDate('ventas.fecha_venta', '<=', $fecha_hasta))
            ->select(
                DB::raw("'Salida' as tipo"),
                'ventas.fecha_venta as fecha',
                'productos.descripcion as producto',
                'detalle_ventas.cantidad',
                'detalle_ventas.precio_unitario',
                'detalle_ventas.subtotal',
                DB::raw("CONCAT(ventas.tipo_comprobante, ' N°', ventas.numero_comprobante) as comprobante"),
                DB::raw("CONCAT(clientes.nombre, ' ', clientes.apellido) as referencia")
            )
            ->get();

        $entradas = DB::table('compra_detalles')
            ->join('compras', 'compra_detalles.id_compra', '=', 'compras.id')
            ->join('productos', 'compra_detalles.id_producto', '=', 'productos.id')
            ->whereNull('compras.deleted_at')
            ->where('compras.estado', '!=', 'Anulado')
            ->where('compra_detalles.estado', '!=', 'Anulado')
            ->when($id_producto, fn($q) => $q->where('compra_detalles.id_producto', $id_producto))
            ->when($fecha_desde, fn($q) => $q->whereDate('compras.fecha_compra', '>=', $fecha_desde))
            ->when($fecha_hasta, fn($q) => $q->whereDate('compras.fecha_compra', '<=', $fecha_hasta))
            ->select(
                DB::raw("'Entrada' as tipo"),
                'compras.fecha_compra as fecha',
                'productos.descripcion as producto',
                'compra_detalles.cantidad',
                'compra_detalles.precio_unitario',
                'compra_detalles.subtotal',
                DB::raw("CONCAT(compras.tipo_comprobante, ' N°', compras.numero_comprobante) as comprobante"),
                DB::raw("'' as referencia")
            )
            ->get();

        $movimientos = $salidas->concat($entradas)->sortByDesc('fecha')->values();

        $productoSeleccionado = null;
        if ($id_producto) {
            $productoSeleccionado = DB::table('productos')
                ->select('id', 'descripcion', 'codigo')
                ->where('id', $id_producto)
                ->first();
        }

        $empresa = Empresa::first();

        $html = view('productos.movimiento_pdf', compact(
            'movimientos', 'empresa', 'productoSeleccionado', 'fecha_desde', 'fecha_hasta'
        ))->render();

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="movimiento_productos.pdf"');
    }

    public function movimiento(Request $request)
    {
        $id_producto = $request->input('id_producto');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');

        $salidas = DB::table('detalle_ventas')
            ->join('ventas', 'detalle_ventas.id_venta', '=', 'ventas.id')
            ->join('productos', 'detalle_ventas.id_producto', '=', 'productos.id')
            ->join('clientes', 'ventas.id_cliente', '=', 'clientes.id')
            ->whereNull('ventas.deleted_at')
            ->where('ventas.estado', '!=', 'Anulado')
            ->when($id_producto, fn($q) => $q->where('detalle_ventas.id_producto', $id_producto))
            ->when($fecha_desde, fn($q) => $q->whereDate('ventas.fecha_venta', '>=', $fecha_desde))
            ->when($fecha_hasta, fn($q) => $q->whereDate('ventas.fecha_venta', '<=', $fecha_hasta))
            ->select(
                DB::raw("'Salida' as tipo"),
                'ventas.fecha_venta as fecha',
                'productos.descripcion as producto',
                'productos.id as id_producto',
                'detalle_ventas.cantidad',
                'detalle_ventas.precio_unitario',
                'detalle_ventas.subtotal',
                DB::raw("CONCAT(ventas.tipo_comprobante, ' N°', ventas.numero_comprobante) as comprobante"),
                DB::raw("CONCAT(clientes.nombre, ' ', clientes.apellido) as referencia")
            )
            ->get();

        $entradas = DB::table('compra_detalles')
            ->join('compras', 'compra_detalles.id_compra', '=', 'compras.id')
            ->join('productos', 'compra_detalles.id_producto', '=', 'productos.id')
            ->whereNull('compras.deleted_at')
            ->where('compras.estado', '!=', 'Anulado')
            ->where('compra_detalles.estado', '!=', 'Anulado')
            ->when($id_producto, fn($q) => $q->where('compra_detalles.id_producto', $id_producto))
            ->when($fecha_desde, fn($q) => $q->whereDate('compras.fecha_compra', '>=', $fecha_desde))
            ->when($fecha_hasta, fn($q) => $q->whereDate('compras.fecha_compra', '<=', $fecha_hasta))
            ->select(
                DB::raw("'Entrada' as tipo"),
                'compras.fecha_compra as fecha',
                'productos.descripcion as producto',
                'productos.id as id_producto',
                'compra_detalles.cantidad',
                'compra_detalles.precio_unitario',
                'compra_detalles.subtotal',
                DB::raw("CONCAT(compras.tipo_comprobante, ' N°', compras.numero_comprobante) as comprobante"),
                DB::raw("'' as referencia")
            )
            ->get();

        $movimientos = $salidas->concat($entradas)->sortByDesc('fecha')->values();

        $productoSeleccionado = null;
        if ($id_producto) {
            $productoSeleccionado = DB::table('productos')
                ->select('id', 'descripcion', 'codigo')
                ->where('id', $id_producto)
                ->first();
        }

        return view('productos.movimiento', compact('movimientos', 'productoSeleccionado', 'id_producto', 'fecha_desde', 'fecha_hasta'));
    }

    /**
     * Remove the specified Producto from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $producto = $this->productoRepository->find($id);

        if (empty($producto)) {
            Flash::error('Producto not found');

            return redirect(route('productos.index'));
        }

        $enCompras = DB::table('compra_detalles')->where('id_producto', $id)->exists();
        $enVentas = DB::table('detalle_ventas')->where('id_producto', $id)->exists();

        if ($enCompras || $enVentas) {
            Flash::error('No se puede eliminar el producto porque tiene compras o ventas asociadas.');

            return redirect(route('productos.index'));
        }

        $this->productoRepository->delete($id);

        Flash::success('Producto deleted successfully.');

        return redirect(route('productos.index'));
    }
}
