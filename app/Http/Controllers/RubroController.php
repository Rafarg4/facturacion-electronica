<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRubroRequest;
use App\Http\Requests\UpdateRubroRequest;
use App\Repositories\RubroRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class RubroController extends AppBaseController
{
    /** @var RubroRepository $rubroRepository*/
    private $rubroRepository;

    public function __construct(RubroRepository $rubroRepo)
    {
        $this->rubroRepository = $rubroRepo;
    }

    /**
     * Display a listing of the Rubro.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $rubros = $this->rubroRepository->all();

        return view('rubros.index')
            ->with('rubros', $rubros);
    }

    /**
     * Show the form for creating a new Rubro.
     *
     * @return Response
     */
    public function create()
    {
        return view('rubros.create');
    }

    /**
     * Store a newly created Rubro in storage.
     *
     * @param CreateRubroRequest $request
     *
     * @return Response
     */
    public function store(CreateRubroRequest $request)
    {
        $input = $request->all();

        $rubro = $this->rubroRepository->create($input);

        Flash::success('Rubro saved successfully.');

        return redirect(route('rubros.index'));
    }

    /**
     * Display the specified Rubro.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rubro = $this->rubroRepository->find($id);

        if (empty($rubro)) {
            Flash::error('Rubro not found');

            return redirect(route('rubros.index'));
        }

        return view('rubros.show')->with('rubro', $rubro);
    }

    /**
     * Show the form for editing the specified Rubro.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rubro = $this->rubroRepository->find($id);

        if (empty($rubro)) {
            Flash::error('Rubro not found');

            return redirect(route('rubros.index'));
        }

        return view('rubros.edit')->with('rubro', $rubro);
    }

    /**
     * Update the specified Rubro in storage.
     *
     * @param int $id
     * @param UpdateRubroRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRubroRequest $request)
    {
        $rubro = $this->rubroRepository->find($id);

        if (empty($rubro)) {
            Flash::error('Rubro not found');

            return redirect(route('rubros.index'));
        }

        $rubro = $this->rubroRepository->update($request->all(), $id);

        Flash::success('Rubro updated successfully.');

        return redirect(route('rubros.index'));
    }

    /**
     * Remove the specified Rubro from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rubro = $this->rubroRepository->find($id);

        if (empty($rubro)) {
            Flash::error('Rubro not found');

            return redirect(route('rubros.index'));
        }

        $this->rubroRepository->delete($id);

        Flash::success('Rubro deleted successfully.');

        return redirect(route('rubros.index'));
    }
}
