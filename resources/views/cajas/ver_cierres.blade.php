@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cierres de Cajas</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                 <div class="table-responsive" style="padding:15px;font-size: 12px;">
                    <table class="table" id="table">
                        <thead>
                        <tr>
                        <th>Cajero</th>
                        <th>Caja</th>
                        <th>Monto apertura</th>
                        <th>Monto cierre</th>
                        <th>Fecha cierre</th>
                        <th>Observaciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cierres as $cierre)
                            <tr>
                            <td>{{ $cierre->name }}</td>
                            <td>{{ $cierre->nombre }}</td>
                            <td>{{ number_format($cierre->monto_inicial) }}</td>
                            <td>{{ number_format($cierre->monto_final) }}</td>
                            <td>{{ $cierre->fecha_cierre }}</td>
                            <td>{{ $cierre->observaciones }}</td>
                               
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

