<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateListaPrecioRequest;
use App\Http\Requests\UpdateListaPrecioRequest;
use App\Repositories\ListaPrecioRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ListaPrecioController extends AppBaseController
{
    /** @var ListaPrecioRepository $listaPrecioRepository*/
    private $listaPrecioRepository;

    public function __construct(ListaPrecioRepository $listaPrecioRepo)
    {
        $this->listaPrecioRepository = $listaPrecioRepo;
    }

    /**
     * Display a listing of the ListaPrecio.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $listaPrecios = $this->listaPrecioRepository->all();

        return view('lista_precios.index')
            ->with('listaPrecios', $listaPrecios);
    }

    /**
     * Show the form for creating a new ListaPrecio.
     *
     * @return Response
     */
    public function create()
    {
        return view('lista_precios.create');
    }

    /**
     * Store a newly created ListaPrecio in storage.
     *
     * @param CreateListaPrecioRequest $request
     *
     * @return Response
     */
    public function store(CreateListaPrecioRequest $request)
    {
        $input = $request->all();

        $listaPrecio = $this->listaPrecioRepository->create($input);

        Flash::success('Lista Precio saved successfully.');

        return redirect(route('listaPrecios.index'));
    }

    /**
     * Display the specified ListaPrecio.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $listaPrecio = $this->listaPrecioRepository->find($id);

        if (empty($listaPrecio)) {
            Flash::error('Lista Precio not found');

            return redirect(route('listaPrecios.index'));
        }

        return view('lista_precios.show')->with('listaPrecio', $listaPrecio);
    }

    /**
     * Show the form for editing the specified ListaPrecio.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $listaPrecio = $this->listaPrecioRepository->find($id);

        if (empty($listaPrecio)) {
            Flash::error('Lista Precio not found');

            return redirect(route('listaPrecios.index'));
        }

        return view('lista_precios.edit')->with('listaPrecio', $listaPrecio);
    }

    /**
     * Update the specified ListaPrecio in storage.
     *
     * @param int $id
     * @param UpdateListaPrecioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateListaPrecioRequest $request)
    {
        $listaPrecio = $this->listaPrecioRepository->find($id);

        if (empty($listaPrecio)) {
            Flash::error('Lista Precio not found');

            return redirect(route('listaPrecios.index'));
        }

        $listaPrecio = $this->listaPrecioRepository->update($request->all(), $id);

        Flash::success('Lista Precio updated successfully.');

        return redirect(route('listaPrecios.index'));
    }

    /**
     * Remove the specified ListaPrecio from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $listaPrecio = $this->listaPrecioRepository->find($id);

        if (empty($listaPrecio)) {
            Flash::error('Lista Precio not found');

            return redirect(route('listaPrecios.index'));
        }

        $this->listaPrecioRepository->delete($id);

        Flash::success('Lista Precio deleted successfully.');

        return redirect(route('listaPrecios.index'));
    }
}
