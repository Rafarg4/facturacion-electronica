<?php

namespace App\Repositories;

use App\Models\ListaPrecio;
use App\Repositories\BaseRepository;

/**
 * Class ListaPrecioRepository
 * @package App\Repositories
 * @version June 16, 2026, 9:35 am -04
*/

class ListaPrecioRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'porcentaje',
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
        return ListaPrecio::class;
    }
}
