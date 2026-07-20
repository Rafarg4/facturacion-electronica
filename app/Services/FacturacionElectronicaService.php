<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\KoapeCredencial;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacturacionElectronicaService
{
    private const IVA_TIPO = [
        '10' => '1',
        '5' => '2',
        'Exenta' => '3',
    ];

    private const PAGO_TIPO = [
        'Efectivo' => '1',
        'Tarjeta' => '3',
        'Transferencia' => '5',
    ];

    public function emitir(Venta $venta): void
    {
        $credencial = KoapeCredencial::first();

        if (!$credencial) {
            $venta->update([
                'estado_sifen' => 'error',
                'mensaje_sifen' => 'No hay credenciales de Koape configuradas (tabla koape_credenciales vacia).',
                'fecha_envio_sifen' => now(),
            ]);

            return;
        }

        $cliente = Cliente::find($venta->id_cliente);
        $empresa = Empresa::first();
        $payload = $this->buildPayload($venta, $cliente, $empresa);

        try {
            $response = Http::withHeaders([
                'X-Auth-User' => $credencial->usuario,
                'X-Auth-Password' => $credencial->password,
                'X-Auth-Codigo' => $credencial->codigo_acceso,
            ])->timeout(15)->post(
                rtrim(config('services.koape.base_url'), '/').'/api/v1/documentos/emitir/',
                $payload
            );

            $this->actualizarCodigoSiRoto($credencial, $response);

            $body = $response->json() ?? [];

            if (!$response->successful() || ($body['estado'] ?? null) === 'error') {
                Log::warning('Respuesta no exitosa de Koape al emitir factura electronica', [
                    'venta_id' => $venta->id,
                    'http_status' => $response->status(),
                    'headers' => $response->headers(),
                    'raw_body' => $response->body(),
                ]);
            }

            $venta->update([
                'cdc' => $body['cdc'] ?? null,
                'estado_sifen' => $body['estado'] ?? 'error',
                'codigo_sifen' => $body['codigo_sifen'] ?? null,
                'mensaje_sifen' => $body['mensaje_sifen'] ?? ($body['detail'] ?? $response->body()),
                'qr_base64' => $body['qr_base64'] ?? null,
                'kude_base64' => $body['kude_base64'] ?? null,
                'fecha_envio_sifen' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al emitir factura electronica en Koape: '.$e->getMessage(), ['venta_id' => $venta->id]);

            $venta->update([
                'estado_sifen' => 'error',
                'mensaje_sifen' => $e->getMessage(),
                'fecha_envio_sifen' => now(),
            ]);
        }
    }

    public function consultarEstado(Venta $venta): void
    {
        if (!$venta->cdc) {
            return;
        }

        $credencial = KoapeCredencial::first();

        if (!$credencial) {
            return;
        }

        try {
            $response = Http::withHeaders([
                'X-Auth-User' => $credencial->usuario,
                'X-Auth-Password' => $credencial->password,
                'X-Auth-Codigo' => $credencial->codigo_acceso,
            ])->timeout(15)->get(
                rtrim(config('services.koape.base_url'), '/')."/api/v1/documentos/{$venta->cdc}/estado/"
            );

            $this->actualizarCodigoSiRoto($credencial, $response);

            $body = $response->json() ?? [];

            $venta->update([
                'estado_sifen' => $body['estado'] ?? $venta->estado_sifen,
                'codigo_sifen' => $body['codigo_sifen'] ?? $venta->codigo_sifen,
                'mensaje_sifen' => $body['mensaje_sifen'] ?? $venta->mensaje_sifen,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al consultar estado SIFEN en Koape: '.$e->getMessage(), ['venta_id' => $venta->id]);
        }
    }

    public function obtenerKudePdf(Venta $venta): ?string
    {
        if (!$venta->cdc) {
            return null;
        }

        $credencial = KoapeCredencial::first();

        if (!$credencial) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'X-Auth-User' => $credencial->usuario,
                'X-Auth-Password' => $credencial->password,
                'X-Auth-Codigo' => $credencial->codigo_acceso,
            ])->timeout(20)->get(
                rtrim(config('services.koape.base_url'), '/')."/api/v1/documentos/{$venta->cdc}/kude/"
            );

            $this->actualizarCodigoSiRoto($credencial, $response);

            return $response->successful() ? $response->body() : null;
        } catch (\Throwable $e) {
            Log::error('Error al obtener KuDE de Koape: '.$e->getMessage(), ['venta_id' => $venta->id]);

            return null;
        }
    }

    private function actualizarCodigoSiRoto(KoapeCredencial $credencial, $response): void
    {
        $nuevo = $response->header('X-Auth-Codigo-Nuevo') ?: $response->json('nuevo_codigo');

        if ($nuevo) {
            $credencial->update(['codigo_acceso' => $nuevo]);
        }
    }

    private function buildPayload(Venta $venta, ?Cliente $cliente, ?Empresa $empresa): array
    {
        [$empresaRuc, $empresaDv] = $this->splitRucDv($empresa ? $empresa->ruc : '');

        $detalles = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.id_producto', '=', 'productos.id')
            ->where('detalle_ventas.id_venta', $venta->id)
            ->select('detalle_ventas.*', 'productos.descripcion as nombre_producto', 'productos.codigo')
            ->get();

        $ivaTipo = self::IVA_TIPO[$venta->iva] ?? '1';

        $items = $detalles->map(fn ($d) => [
            'descripcion' => $d->nombre_producto,
            'codigo' => $d->codigo,
            'cantidad' => (string) $d->cantidad,
            'precio_unitario' => (string) $d->precio_unitario,
            'iva_tipo' => $ivaTipo,
        ])->values()->all();

        $documento = [
            'cabecera' => [
                'establecimiento' => config('services.koape.establecimiento'),
                'punto_expedicion' => config('services.koape.punto_expedicion'),
                // numero_documento se omite a propósito: Koape lo asigna atómico y lo
                // devuelve en la respuesta, evitando choques con la numeración interna.
                'fecha_emision' => date('Y-m-d\TH:i:s', strtotime($venta->fecha_venta)),
                'moneda' => $venta->moneda ?: 'PYG',
                'condicion_venta' => $venta->condicion_venta,
            ] + (($venta->moneda ?: 'PYG') !== 'PYG' ? ['tipo_cambio' => (string) $venta->tipo_cambio] : []),
            'cliente' => $this->buildCliente($cliente),
            'items' => $items,
            'incluir_kude_base64' => true,
            'incluir_solo_qr' => true,
        ];

        if ($venta->condicion_venta === 'credito') {
            $documento['credito'] = $this->buildCredito($venta);
        } else {
            $documento['pagos'] = [[
                'tipo' => self::PAGO_TIPO[$venta->forma_pago] ?? '99',
                'monto' => (string) $venta->total_gs,
            ]];
        }

        return [
            'header' => [
                'empresa_ruc' => $empresaRuc,
                'empresa_dv' => $empresaDv,
            ],
            'body' => [
                'tipo_documento' => 'FE',
                'documento' => $documento,
            ],
        ];
    }

    private function buildCredito(Venta $venta): array
    {
        $cuotas = DB::table('saldo_ventas')
            ->where('id_venta', $venta->id)
            ->orderBy('numero_cuota')
            ->get();

        return [
            'cuotas' => $cuotas->count(),
            'detalle' => $cuotas->map(fn ($c) => [
                'numero' => $c->numero_cuota,
                'monto' => (string) $c->monto,
                'vencimiento' => date('Y-m-d', strtotime($c->fecha_vencimiento)),
            ])->values()->all(),
        ];
    }

    private function buildCliente(?Cliente $cliente): array
    {
        if (!$cliente) {
            return ['nombre' => 'Sin Nombre'];
        }

        $nombre = trim($cliente->nombre.' '.$cliente->apellido) ?: 'Sin Nombre';
        $ci = trim((string) $cliente->ci);

        if ($ci === '') {
            return ['nombre' => $nombre];
        }

        if (strpos($ci, '-') !== false) {
            [$ruc, $dv] = $this->splitRucDv($ci);

            return [
                'ruc' => $ruc,
                'dv' => $dv,
                'nombre' => $nombre,
                'direccion' => $cliente->direccion,
                'telefono' => $cliente->telefono,
                'email' => $cliente->correo,
            ];
        }

        return [
            'tipo_documento_identidad' => '1',
            'numero_documento_identidad' => $ci,
            'nombre' => $nombre,
            'direccion' => $cliente->direccion,
            'telefono' => $cliente->telefono,
            'pais' => 'PRY',
        ];
    }

    private function splitRucDv(string $value): array
    {
        $parts = explode('-', $value, 2);

        return [trim($parts[0]), trim($parts[1] ?? '')];
    }
}
