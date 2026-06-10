<?php

namespace App\Repositories;

use App\Models\Modalidad;
use App\Repositories\BaseRepository;

/**
 * Class ModalidadRepository
 * @package App\Repositories
 * @version June 4, 2024, 6:32 pm -04
*/

class ModalidadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre'
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
        return Modalidad::class;
    }
}
