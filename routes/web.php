
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CobroController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\AuditoriaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
   });
}); 
Route::get('/symlink', function () {
   $target =$_SERVER['DOCUMENT_ROOT'].'/storage/app/public';
   $link = $_SERVER['DOCUMENT_ROOT'].'/public/storage';
   symlink($target, $link);
   echo "Done";
});

Auth::routes();
Route::get('', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::group(['middleware' => ['permission:create_inscripcion|edit_inscripcion|delete_inscripcion|admin_inscripcion']], function () {


Route::resource('categorias', App\Http\Controllers\CategoriaController::class)->middleware('auth');

Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth');


Route::get('index', [App\Http\Controllers\Prueba::class, 'index'])->name('index');

Route::resource('clientes', App\Http\Controllers\ClienteController::class);


Route::resource('proveedors', App\Http\Controllers\ProveedorController::class);


Route::get('/productos-buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
Route::get('/productos-para-venta', [ProductoController::class, 'paraVenta'])->name('productos.paraVenta');
Route::resource('productos', App\Http\Controllers\ProductoController::class);
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos-data', [ProductoController::class, 'data'])->name('productos.data');
Route::post('/productos/{id}/cambiarEstado', [ProductoController::class, 'cambiarEstado'])->name('productos.cambiarEstado');

Route::post('/productos/{id}/cambiarEstado', [ProductoController::class, 'cambiarEstado'])->name('cambiarEstado');

Route::post('/ventas/{id}/anular', [VentaController::class, 'anular'])->name('ventas.anular');

Route::resource('ventas', App\Http\Controllers\VentaController::class);

Route::get('/comprobante/{id}', [VentaController::class, 'generarComprobante'])->name('comprobante.generar');

Route::get('/generar_factura/{id}', [VentaController::class, 'generar_factura'])->name('generar_factura');

Route::get('/obtenerSiguienteNumero', [VentaController::class, 'obtenerSiguienteNumero']);

Route::get('/facturas-electronicas', [VentaController::class, 'facturasElectronicas'])->name('facturas_electronicas.index');

Route::post('/facturas-electronicas/{id}/consultar-estado', [VentaController::class, 'consultarEstadoFactura'])->name('facturas_electronicas.consultar_estado');

Route::get('/facturas-electronicas/{id}/kude', [VentaController::class, 'verKude'])->name('facturas_electronicas.kude');




Route::resource('cobros', App\Http\Controllers\CobroController::class);
Route::get('/ventasCreditoPorCliente/{id}', [App\Http\Controllers\CobroController::class, 'ventasCreditoPorCliente'])->name('ventasCreditoPorCliente');
Route::get('/saldosPorVenta/{id_venta}', [App\Http\Controllers\CobroController::class, 'saldosPorVenta']);


Route::resource('cajas', App\Http\Controllers\CajaController::class);
Route::post('/cajas/{caja}/apertura', [CajaController::class, 'apertura_caja'])->name('apertura_caja');
Route::post('/cajas/{id}/asignar-usuario', [CajaController::class, 'asignarUsuario'])->name('cajas.asignarUsuario');
Route::delete('/cajas/{cajaId}/desasignar/{userId}', [CajaController::class, 'desasignarUsuario'])->name('cajas.desasignarUsuario');

Route::resource('empresas', App\Http\Controllers\EmpresaController::class);

Route::get('/empresa/logo', [App\Http\Controllers\EmpresaController::class, 'ver_logo_empresa'])->name('empresa.logo');

Route::get('/cobro_recibo/{id}', [CobroController::class, 'cobro_recibo'])->name('cobro_recibo');
Route::get('/numero_comprobante_cobro/', [CobroController::class, 'numero_comprobante_cobro'])->name('numero_comprobante_cobro');


Route::post('/caja/{id}/cambiarEstadoCaja', [CajaController::class, 'cambiarEstadoCaja'])->name('cambiarEstadoCaja');

Route::get('/cierre_caja', [CajaController::class, 'cierre_caja'])->name('cierre_caja');
Route::get('/ver_cierres', [CajaController::class, 'ver_cierres'])->name('ver_cierres');
Route::post('/generar_cierre', [CajaController::class, 'generar_cierre'])->name('generar_cierre');

Route::get('/ver_rendicion_caja', [CajaController::class, 'ver_rendicion_caja'])->name('ver_rendicion_caja');
Route::post('/generar_rendicion_caja', [CajaController::class, 'generar_rendicion_caja'])->name('generar_rendicion_caja');

Route::get('/ver_cobros_pendientes', [CobroController::class, 'ver_cobros_pendientes'])->name('ver_cobros_pendientes');
Route::post('/reporte_cobros_pendientes', [CobroController::class, 'reporte_cobros_pendientes'])->name('reporte_cobros_pendientes');
Route::post('/cobros/{id}/anular', [CobroController::class, 'anular'])->name('anular_cobro');


//Compras
Route::resource('compras', App\Http\Controllers\CompraController::class);
Route::get('/ficha_compra/{id}', [CompraController::class, 'ficha_compra'])->name('ficha_compra');
Route::post('/anular_compra/{id}', [CompraController::class, 'anular_compra'])->name('anular_compra');

//Pedidos
Route::resource('pedidos', App\Http\Controllers\PedidoController::class);
Route::get('/pedido_detalles/{id}', [PedidoController::class, 'pedido_detalles']);
Route::get('/ficha_pedido/{id}', [PedidoController::class, 'ficha_pedido'])->name('ficha_pedido');
Route::post('/anular_pedido/{id}', [PedidoController::class, 'anular_pedido'])->name('anular_pedido');

// Reporte de Cierres
Route::match(['get','post'], '/reporte-cierres', [CajaController::class, 'reporte_cierres'])->name('reporte_cierres');
Route::post('/reporte-cierres/pdf', [CajaController::class, 'reporte_cierres_pdf'])->name('reporte_cierres_pdf');


Route::resource('cotizacions', App\Http\Controllers\CotizacionController::class);
Route::get('/cotizacion-por-moneda/{tipo_moneda}', [App\Http\Controllers\CotizacionController::class, 'porMoneda'])->name('cotizacion.porMoneda');


Route::resource('rubros', App\Http\Controllers\RubroController::class);


Route::resource('presupuestoCabeceras', App\Http\Controllers\PresupuestoCabeceraController::class);
Route::get(
    'presupuestoCabeceras/{id}/pdf',
    [App\Http\Controllers\PresupuestoCabeceraController::class, 'pdf']
)->name('presupuestoCabeceras.pdf');

Route::resource('listaPrecios', App\Http\Controllers\ListaPrecioController::class);


Route::post('/reporte-stock/generar',[ProductoController::class, 'generarReporteStock'])->name('generar_reporte_stock');
Route::get('/ver-reporte-stock',[ProductoController::class, 'verReporteStock'])->name('ver_reporte_stock');

Route::get('/movimiento-productos', [ProductoController::class, 'movimiento'])->name('movimiento_productos');
Route::get('/movimiento-productos/pdf', [ProductoController::class, 'movimientoPdf'])->name('movimiento_productos.pdf');
Route::get('/productos-buscar-filtro', [ProductoController::class, 'buscarParaFiltro'])->name('productos.buscarParaFiltro');



Route::get('/consulta-precio', [ProductoController::class, 'consultaPrecio'])
    ->name('consulta_precio');

Route::post('/buscar-precio', [ProductoController::class, 'buscarPrecio'])
    ->name('buscar_precio');

Route::get('/auditoria', [AuditoriaController::class, 'index'])
    ->name('auditoria');

Route::post('/buscar-auditoria', [AuditoriaController::class, 'buscar'])
    ->name('buscar_auditoria');

Route::match(['get','post'], '/auditoria', [AuditoriaController::class, 'index'])
    ->name('auditoria');

Route::post('miPlans/generar-cuotas', [App\Http\Controllers\MiPlanController::class, 'generarCuotas'])->name('miPlans.generarCuotas');
Route::post('miPlans/{id}/pagar', [App\Http\Controllers\MiPlanController::class, 'registrarPago'])->name('miPlans.pagar');
Route::resource('miPlans', App\Http\Controllers\MiPlanController::class);

// Planes (cabecera) y sus cuotas (mi_plans)
Route::resource('planes', App\Http\Controllers\PlanController::class);

// Página de bloqueo por falta de pago
Route::get('/sistema-bloqueado', function () {
    $cuota = \App\Models\MiPlan::whereNotNull('plan_id')
        ->whereHas('plan', fn($q) => $q->where('estado', 'Vigente'))
        ->where('fecha_vencimiento', '<', \Carbon\Carbon::today())
        ->where('estado', '!=', 'Pagado')
        ->with('plan')
        ->first();
    return view('bloqueado', compact('cuota'));
})->middleware('auth')->name('sistema.bloqueado');
