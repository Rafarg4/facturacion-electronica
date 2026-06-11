<?php

namespace App\Repositories;

use App\Models\Electrodomestico;
use App\Repositories\BaseRepository;

/**
 * Class ElectrodomesticoRepository
 * @package App\Repositories
 * @version September 23, 2024, 7:52 pm -04
*/

class ElectrodomesticoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'marca',
        'precio'
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
        return Electrodomestico::class;
    }
}
