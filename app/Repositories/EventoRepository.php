<?php

namespace App\Repositories;

use App\Models\Evento;
use App\Repositories\BaseRepository;

/**
 * Class EventoRepository
 * @package App\Repositories
 * @version January 23, 2024, 6:21 pm -03
*/

class EventoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'fecha',
        'lugar',
        'modalidad',
        'distancia',
        'organiza',
        'cupos',
        'estado'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Evento::class;
    }
}
