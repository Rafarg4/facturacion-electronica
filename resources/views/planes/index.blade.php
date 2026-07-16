@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1>Planes</h1>
            </div>
            @role('Desarrollador')
            <div class="col-sm-6 text-right">
                <a href="{{ route('planes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Plan
                </a>
            </div>
            @endrole
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message')
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-body p-0">
            @include('planes.table')
        </div>
    </div>
</div>
@endsection
