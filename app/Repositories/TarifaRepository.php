<?php

namespace App\Repositories;

use App\Models\Tarifa;
use App\Repositories\BaseRepository;

/**
 * Class TarifaRepository
 * @package App\Repositories
 * @version July 25, 2023, 7:27 pm -04
*/

class TarifaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tipo_plan',
        'tarifa',
        'descripcion'
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
        return Tarifa::class;
    }
}
