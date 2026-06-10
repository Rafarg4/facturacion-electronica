<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use App\Repositories\CotizacionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CotizacionController extends AppBaseController
{
    /** @var CotizacionRepository $cotizacionRepository*/
    private $cotizacionRepository;

    public function __construct(CotizacionRepository $cotizacionRepo)
    {
        $this->cotizacionRepository = $cotizacionRepo;
    }

    /**
     * Display a listing of the Cotizacion.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cotizacions = $this->cotizacionRepository->all();

        return view('cotizacions.index')
            ->with('cotizacions', $cotizacions);
    }

    /**
     * Show the form for creating a new Cotizacion.
     *
     * @return Response
     */
    public function create()
    {
        return view('cotizacions.create');
    }

    /**
     * Store a newly created Cotizacion in storage.
     *
     * @param CreateCotizacionRequest $request
     *
     * @return Response
     */
    public function store(CreateCotizacionRequest $request)
    {
        $input = $request->all();

        $cotizacion = $this->cotizacionRepository->create($input);

        Flash::success('Cotizacion creada exitosamente.');

        return redirect(route('cotizacions.index'));
    }

    /**
     * Display the specified Cotizacion.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotizacion not found');

            return redirect(route('cotizacions.index'));
        }

        return view('cotizacions.show')->with('cotizacion', $cotizacion);
    }

    /**
     * Show the form for editing the specified Cotizacion.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotizacion not found');

            return redirect(route('cotizacions.index'));
        }

        return view('cotizacions.edit')->with('cotizacion', $cotizacion);
    }

    /**
     * Update the specified Cotizacion in storage.
     *
     * @param int $id
     * @param UpdateCotizacionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCotizacionRequest $request)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotizacion not found');

            return redirect(route('cotizacions.index'));
        }

        $cotizacion = $this->cotizacionRepository->update($request->all(), $id);

        Flash::success('Cotizacion actualizada exitosamente.');

        return redirect(route('cotizacions.index'));
    }

    /**
     * Remove the specified Cotizacion from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotizacion not found');

            return redirect(route('cotizacions.index'));
        }

        $this->cotizacionRepository->delete($id);

        Flash::success('Cotizacion eliminada exitosamente.');

        return redirect(route('cotizacions.index'));
    }
}
