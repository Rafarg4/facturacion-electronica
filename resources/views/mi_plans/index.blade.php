@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mi Plan</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#modalGenerarCuotas">
                        <i class="fas fa-list-ol"></i> Generar Cuotas
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('mi_plans.table')

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Generar Cuotas --}}
    <div class="modal fade" id="modalGenerarCuotas" tabindex="-1" role="dialog" aria-labelledby="modalGenerarCuotasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('miPlans.generarCuotas') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalGenerarCuotasLabel">Generar Cuotas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="gen_empresa">Empresa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="gen_empresa" name="empresa" required placeholder="Nombre de empresa">
                        </div>
                        <div class="form-group">
                            <label for="gen_fecha_inicio">Fecha de Inicio <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="gen_fecha_inicio" name="fecha_inicio" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gen_cantidad">Cantidad de Cuotas <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="gen_cantidad" name="cantidad_cuotas" required min="1" max="360" placeholder="Ej: 12">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gen_periodicidad">Periodicidad <span class="text-danger">*</span></label>
                                    <select class="form-control" id="gen_periodicidad" name="periodicidad" required>
                                        <option value="mensual">Mensual</option>
                                        <option value="quincenal">Quincenal</option>
                                        <option value="semanal">Semanal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gen_monto">Monto por Cuota <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="gen_monto" name="monto_total" required min="0.01" step="0.01" placeholder="Ej: 50000">
                        </div>
                        <div class="form-group" id="preview-cuota" style="display:none;">
                            <div class="alert alert-info mb-0">
                                Total a generar: <strong id="preview-monto">0</strong>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gen_observacion">Observación</label>
                            <input type="text" class="form-control" id="gen_observacion" name="observacion" placeholder="Opcional">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-cogs"></i> Generar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
<script>
    function actualizarPreview() {
        var cantidad = parseFloat($('#gen_cantidad').val());
        var monto    = parseFloat($('#gen_monto').val());
        if (cantidad > 0 && monto > 0) {
            var total = (monto * cantidad).toFixed(2);
            $('#preview-monto').text(new Intl.NumberFormat('es-PY').format(total));
            $('#preview-cuota').show();
        } else {
            $('#preview-cuota').hide();
        }
    }
    $('#gen_cantidad, #gen_monto').on('input', actualizarPreview);
</script>
@endpush

