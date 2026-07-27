<?php

namespace App\Http\Controllers;

use App\Models\KoapeCredencial;
use Illuminate\Http\Request;
use Flash;

class KoapeCredencialController extends AppBaseController
{
    /**
     * Show the form to view/edit the Koape credentials for this environment.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $credencial = KoapeCredencial::first();

        $defaults = [
            'base_url' => config('services.koape.base_url'),
            'establecimiento' => config('services.koape.establecimiento'),
            'punto_expedicion' => config('services.koape.punto_expedicion'),
        ];

        return view('koape_credenciales.edit', compact('credencial', 'defaults'));
    }

    /**
     * Update (or create) the Koape credentials for this environment.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'codigo_acceso' => 'nullable|string|max:255',
            'base_url' => 'required|url|max:255',
            'establecimiento' => 'required|string|max:10',
            'punto_expedicion' => 'required|string|max:10',
        ]);

        $credencial = KoapeCredencial::first() ?: new KoapeCredencial();
        $credencial->usuario = trim($request->usuario);
        $credencial->base_url = trim($request->base_url);
        $credencial->establecimiento = trim($request->establecimiento);
        $credencial->punto_expedicion = trim($request->punto_expedicion);

        if ($request->filled('password')) {
            $credencial->password = trim($request->password);
        }

        if ($request->filled('codigo_acceso')) {
            $credencial->codigo_acceso = trim($request->codigo_acceso);
        }

        $credencial->save();

        Flash::success('Credenciales de facturación electrónica actualizadas.');

        return redirect(route('koapeCredenciales.edit'));
    }
}
