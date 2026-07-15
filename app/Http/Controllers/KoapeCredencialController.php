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

        return view('koape_credenciales.edit', compact('credencial'));
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
        ]);

        $credencial = KoapeCredencial::first() ?: new KoapeCredencial();
        $credencial->usuario = trim($request->usuario);

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
