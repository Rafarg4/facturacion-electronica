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
        // Cuotas a vencer tanto de Ventas a crédito (deuda de clientes) como de
        // Compras a crédito (deuda nuestra con proveedores), distinguidas por tipo_saldo.
        $cuotasPorVencer = DB::table('saldo_ventas')
            ->leftJoin('clientes', function ($join) {
                $join->on('saldo_ventas.id_cliente', '=', 'clientes.id')->where('saldo_ventas.tipo_saldo', '=', 'Venta');
            })
            ->leftJoin('proveedors', function ($join) {
                $join->on('saldo_ventas.id_cliente', '=', 'proveedors.id')->where('saldo_ventas.tipo_saldo', '=', 'Compra');
            })
            ->select(
                'saldo_ventas.id',
                'saldo_ventas.id_venta',
                'saldo_ventas.tipo_saldo',
                'saldo_ventas.monto',
                'saldo_ventas.saldo',
                'saldo_ventas.numero_cuota',
                'saldo_ventas.fecha_vencimiento',
                DB::raw("COALESCE(CONCAT(clientes.nombre, ' ', clientes.apellido), CONCAT(proveedors.nombre, ' ', proveedors.apellido)) as cliente")
            )
            ->where('saldo_ventas.saldo', '>', 0)
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
