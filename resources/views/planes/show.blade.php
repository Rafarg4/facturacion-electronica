@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1>{{ $plan->empresa }}</h1>
                @if($plan->descripcion)
                    <small class="text-muted">{{ $plan->descripcion }}</small>
                @endif
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('planes.edit', $plan->id) }}" class="btn btn-warning mr-1">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('planes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message')
    <div class="clearfix"></div>

    {{-- Info del plan --}}
    <div class="card mb-3">
        <div class="card-body py-3" style="font-size:13px;">
            <div class="row">
                <div class="col-6 col-sm-2 mb-2">
                    <span class="text-muted d-block">Inicio</span>
                    <strong>{{ $plan->fecha_inicio ? $plan->fecha_inicio->format('d/m/Y') : '-' }}</strong>
                </div>
                <div class="col-6 col-sm-2 mb-2">
                    <span class="text-muted d-block">Periodicidad</span>
                    <strong class="text-capitalize">{{ $plan->periodicidad }}</strong>
                </div>
                <div class="col-6 col-sm-2 mb-2">
                    <span class="text-muted d-block">Cuotas del plan</span>
                    <strong>{{ $plan->cantidad_cuotas }}</strong>
                </div>
                <div class="col-6 col-sm-2 mb-2">
                    <span class="text-muted d-block">Monto / Cuota</span>
                    <strong>{{ number_format($plan->monto_cuota, 0, ',', '.') }}</strong>
                </div>
                <div class="col-6 col-sm-2 mb-2">
                    <span class="text-muted d-block">Total Plan</span>
                    <strong>{{ number_format($plan->monto_total, 0, ',', '.') }}</strong>
                </div>
                <div class="col-6 col-sm-2 mb-2">
                    <span class="text-muted d-block">Estado</span>
                    @if($plan->estado === 'Vigente')
                        <span class="badge badge-success">{{ $plan->estado }}</span>
                    @elseif($plan->estado === 'Finalizado')
                        <span class="badge badge-secondary">{{ $plan->estado }}</span>
                    @else
                        <span class="badge badge-danger">{{ $plan->estado }}</span>
                    @endif
                </div>
            </div>
            @if($plan->observacion)
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <span class="text-muted">Obs:</span> {{ $plan->observacion }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Resumen de cuotas --}}
    @php
        $totalCuotas      = $plan->cuotas->count();
        $cuotasPagadas    = $plan->cuotas->where('estado', 'Pagado')->count();
        $cuotasPendientes = $plan->cuotas->whereIn('estado', ['Pendiente', 'Parcial'])->count();
    @endphp
    @if($totalCuotas > 0)
    <div class="row mb-3">
        <div class="col-6 col-sm-3 mb-2">
            <div class="small-box bg-light border mb-0" style="min-height:0;">
                <div class="inner text-center py-2">
                    <h4 class="mb-0">{{ $totalCuotas }}</h4>
                    <p class="mb-0 text-muted" style="font-size:12px;">Total cuotas</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 mb-2">
            <div class="small-box bg-success mb-0" style="min-height:0;">
                <div class="inner text-center py-2">
                    <h4 class="mb-0 text-white">{{ $cuotasPagadas }}</h4>
                    <p class="mb-0 text-white" style="font-size:12px;">Pagadas</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 mb-2">
            <div class="small-box bg-warning mb-0" style="min-height:0;">
                <div class="inner text-center py-2">
                    <h4 class="mb-0">{{ $cuotasPendientes }}</h4>
                    <p class="mb-0" style="font-size:12px;">Pendientes</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 mb-2">
            <div class="small-box bg-light border mb-0" style="min-height:0;">
                <div class="inner text-center py-2">
                    <h4 class="mb-0 text-danger">{{ number_format($saldoPendiente, 0, ',', '.') }}</h4>
                    <p class="mb-0 text-muted" style="font-size:12px;">Saldo pendiente</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Tabla de cuotas --}}
    <div class="card">
        <div class="card-header py-2">
            <h5 class="mb-0">Cuotas</h5>
        </div>
        <div class="card-body p-0">
            @if($plan->cuotas->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                    No hay cuotas generadas para este plan.
                </div>
            @else
                <div class="table-responsive" style="padding:15px;font-size:12px;">
                    <table class="table" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">Nro</th>
                                <th>Vencimiento</th>
                                <th>Fecha Pago</th>
                                <th class="text-right">Monto</th>
                                <th class="text-right">Saldo</th>
                                <th class="text-center">Estado</th>
                                <th>Observación</th>
                                <th class="text-center" width="60">Pagar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $todasAnterioresPagadas = true; @endphp
                        @foreach($plan->cuotas as $cuota)
                            @php
                                $esPagable = $todasAnterioresPagadas && $cuota->estado !== 'Pagado';
                                if ($cuota->estado !== 'Pagado') {
                                    $todasAnterioresPagadas = false;
                                }
                                $rowClass = $cuota->estado === 'Pagado' ? 'table-success' : '';
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td class="text-center">{{ $cuota->nro_cuota }}</td>
                                <td>{{ $cuota->fecha_vencimiento ? $cuota->fecha_vencimiento->format('d/m/Y') : '-' }}</td>
                                <td>{{ $cuota->fecha_pago ? $cuota->fecha_pago->format('d/m/Y') : '-' }}</td>
                                <td class="text-right">{{ number_format($cuota->monto_cuota, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($cuota->saldo_cuota, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($cuota->estado === 'Pagado')
                                        <span class="badge badge-success" style="font-size:11px;">
                                            <i class="fas fa-check-circle"></i> Pagado
                                        </span>
                                    @else
                                        <span class="badge badge-light border" style="font-size:11px;">
                                            <i class="far fa-circle"></i> Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $cuota->observacion }}</td>
                                <td class="text-center">
                                    @if($cuota->estado === 'Pagado')
                                        <i class="fas fa-check-square fa-lg text-success" title="Pagado"></i>
                                    @elseif($esPagable)
                                        <button type="button"
                                                class="btn-pagar"
                                                title="Registrar pago"
                                                data-toggle="modal"
                                                data-target="#modalPago"
                                                data-action="{{ route('miPlans.pagar', $cuota->id) }}"
                                                data-cuota="{{ $cuota->nro_cuota }}"
                                                data-saldo="{{ $cuota->saldo_cuota }}"
                                                style="border:none;background:none;padding:2px 6px;cursor:pointer;">
                                            <i class="far fa-square fa-lg text-secondary"></i>
                                        </button>
                                    @else
                                        <i class="fas fa-lock fa-sm text-muted" title="Pague primero las cuotas anteriores"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Registrar Pago --}}
<div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formPago" method="POST" action="">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title">Registrar Pago</h6>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2 text-muted" id="pago-info"></p>
                    <div class="form-group">
                        <label>Fecha de Pago <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" name="fecha_pago"
                               id="pago_fecha" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label>Monto Pagado <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="monto_pagado"
                               id="pago_monto" required min="0.01" step="0.01">
                        <small class="text-muted">Saldo pendiente: <strong id="pago_saldo_label"></strong></small>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check"></i> Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('page_scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-pagar', function () {
            var btn   = $(this);
            var cuota = btn.data('cuota');
            var saldo = parseFloat(btn.data('saldo'));
            $('#formPago').attr('action', btn.data('action'));
            $('#pago-info').text('Cuota #' + cuota);
            $('#pago_monto').val(saldo).attr('max', saldo);
            $('#pago_saldo_label').text(new Intl.NumberFormat('es-PY').format(saldo));
        });
    });
</script>
@endpush
