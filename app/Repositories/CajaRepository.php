<?php

namespace App\Repositories;

use App\Models\Caja;
use App\Repositories\BaseRepository;

/**
 * Class CajaRepository
 * @package App\Repositories
 * @version May 7, 2025, 9:36 pm -04
*/

class CajaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
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
        return Caja::class;
    }
}
