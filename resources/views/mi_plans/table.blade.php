<div class="table-responsive" style="padding:15px;font-size: 12px;">
    <table class="table table-bordered table-hover" id="table">
        <thead class="thead-light">
        <tr>
            <th>Empresa</th>
            <th>Nro Cuota</th>
            <th>Fecha Vencimiento</th>
            <th>Fecha Pago</th>
            <th class="text-right">Monto Cuota</th>
            <th class="text-right">Saldo</th>
            <th class="text-center">Estado</th>
            <th>Observacion</th>
            <th class="text-center" width="80">Pagar</th>
        </tr>
        </thead>
        <tbody>
        @foreach($miPlans as $miPlan)
            @php
                if ($miPlan->estado === 'Pagado') {
                    $rowClass = 'table-success';
                } elseif ($miPlan->estado === 'Parcial') {
                    $rowClass = 'table-warning';
                } else {
                    $rowClass = '';
                }
            @endphp
            <tr class="{{ $rowClass }}">
                <td>{{ $miPlan->empresa }}</td>
                <td class="text-center">{{ $miPlan->nro_cuota }}</td>
                <td>{{ $miPlan->fecha_vencimiento ? $miPlan->fecha_vencimiento->format('d/m/Y') : '-' }}</td>
                <td>{{ $miPlan->fecha_pago ? $miPlan->fecha_pago->format('d/m/Y') : '-' }}</td>
                <td class="text-right">{{ number_format($miPlan->monto_cuota, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($miPlan->saldo_cuota, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($miPlan->estado === 'Pagado')
                        <span class="badge badge-success" style="font-size:11px;">
                            <i class="fas fa-check-circle"></i> Pagado
                        </span>
                    @elseif($miPlan->estado === 'Parcial')
                        <span class="badge badge-warning text-dark" style="font-size:11px;">
                            <i class="fas fa-adjust"></i> Parcial
                        </span>
                    @else
                        <span class="badge badge-light border" style="font-size:11px;">
                            <i class="far fa-circle"></i> Pendiente
                        </span>
                    @endif
                </td>
                <td>{{ $miPlan->observacion }}</td>
                <td class="text-center">
                    @if($miPlan->estado === 'Pagado')
                        <i class="fas fa-check-square fa-lg text-success" title="Pagado"></i>
                    @else
                        <button type="button"
                                class="btn-pagar"
                                title="Click para registrar pago"
                                data-toggle="modal"
                                data-target="#modalPago"
                                data-action="{{ route('miPlans.pagar', $miPlan->id) }}"
                                data-empresa="{{ $miPlan->empresa }}"
                                data-cuota="{{ $miPlan->nro_cuota }}"
                                data-saldo="{{ $miPlan->saldo_cuota }}"
                                style="border:none; background:none; padding:2px 6px; cursor:pointer;">
                            <i class="far fa-square fa-lg text-secondary"></i>
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- Modal Registrar Pago --}}
<div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="modalPagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formPago" method="POST" action="">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title" id="modalPagoLabel">Registrar Pago</h6>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-2 text-muted" id="pago-info"></p>
                    <div class="form-group">
                        <label>Fecha de Pago <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" name="fecha_pago" id="pago_fecha" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label>Monto Pagado <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="monto_pagado" id="pago_monto" required min="0.01" step="0.01">
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

<script>
    $(document).ready(function () {
        $('#modalPago').on('show.bs.modal', function (e) {
            var btn     = $(e.relatedTarget);
            var empresa = btn.data('empresa');
            var cuota   = btn.data('cuota');
            var saldo   = parseFloat(btn.data('saldo'));

            $('#formPago').attr('action', btn.data('action'));
            $('#pago-info').text(empresa + ' — Cuota #' + cuota);
            $('#pago_monto').val(saldo).attr('max', saldo);
            $('#pago_saldo_label').text(new Intl.NumberFormat('es-PY').format(saldo));
        });
    });
</script>
