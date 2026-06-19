<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('auditoria');

        if ($request->filled('tabla')) {
            $query->where('tabla', $request->tabla);
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('usuario_sistema')) {
            $query->where(
                'usuario_sistema',
                'like',
                '%' . $request->usuario_sistema . '%'
            );
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate(
                'fecha_hora',
                '>=',
                $request->fecha_desde
            );
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha_hora',
                '<=',
                $request->fecha_hasta
            );
        }

        $auditorias = $query
            ->orderBy('id', 'desc')
            ->paginate(50)
            ->appends($request->all());

        $tablas = DB::table('auditoria')
            ->select('tabla')
            ->distinct()
            ->orderBy('tabla')
            ->get();

        return view(
            'auditoria.index',
            compact(
                'auditorias',
                'tablas'
            )
        );
    }
}