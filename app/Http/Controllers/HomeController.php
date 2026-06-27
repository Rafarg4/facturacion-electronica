<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cuotasPorVencer = DB::table('saldo_ventas')
            ->join('clientes', 'saldo_ventas.id_cliente', '=', 'clientes.id')
            ->select(
                'saldo_ventas.id',
                'saldo_ventas.id_venta',
                'saldo_ventas.monto',
                'saldo_ventas.saldo',
                'saldo_ventas.numero_cuota',
                'saldo_ventas.fecha_vencimiento',
                DB::raw("CONCAT(clientes.nombre, ' ', clientes.apellido) as cliente")
            )
            ->where('saldo_ventas.pagado', false)
            ->whereDate('saldo_ventas.fecha_vencimiento', '>=', now()->toDateString())
            ->orderBy('saldo_ventas.fecha_vencimiento', 'asc')
            ->limit(5)
            ->get();

        $productosStockBajo = Producto::whereRaw('CAST(cantidad AS DECIMAL) <= CAST(cantidad_minima AS DECIMAL)')
            ->whereNotNull('cantidad_minima')
            ->where('cantidad_minima', '!=', '')
            ->orderByRaw('CAST(cantidad AS DECIMAL) ASC')
            ->limit(10)
            ->get(['id', 'descripcion', 'cantidad', 'cantidad_minima', 'codigo']);

        return view('home', compact('cuotasPorVencer', 'productosStockBajo'));
    }
}
