<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Repositories\ProductoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use App\Http\Controllers\ProductoController;
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
    public function index(Request $request)
    {
        $productos = DB::table('productos')
        ->join('rubros', 'productos.id_rubro', '=', 'rubros.id')
        ->select(
            'productos.id',
            'productos.nombre',
            'productos.descripcion',
            'productos.cantidad',
            'productos.cantidad_minima',
            'productos.precio1',
            'productos.precio2',
            'productos.precio3',
            'productos.costo',
             'productos.codigo',
            'productos.estado',
            'productos.imagen',
            'productos.cantidad_caja',
            'rubros.descripcion as rubro_descripcion'
        )
        ->get();
       // return $productos;

        return view('productos.index')
            ->with('productos', $productos);
    }

    /**
     * Show the form for creating a new Producto.
     *
     * @return Response
     */
    public function create()
    {
     $categorias = DB::table('categorias')->select('id', 'nombre')->get();
    $proveedores = DB::table('proveedors')->select('id', 'nombre', 'apellido','ci')->get();
    $rubros = DB::table('rubros')->select('id', 'descripcion')
    ->where('estado', 'S')
    ->get();
    return view('productos.create', compact('proveedores','categorias', 'rubros')); // Pasar a la vista
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
                'p.nombre',
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

        return view('productos.edit')->with('producto', $producto);
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

        $producto = $this->productoRepository->update($request->all(), $id);

        Flash::success('Producto updated successfully.');

        return redirect(route('productos.index'));
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

        $this->productoRepository->delete($id);

        Flash::success('Producto deleted successfully.');

        return redirect(route('productos.index'));
    }
}
