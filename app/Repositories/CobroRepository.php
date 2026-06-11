<?php

namespace App\Repositories;

use App\Models\Cobro;
use App\Repositories\BaseRepository;

/**
 * Class CobroRepository
 * @package App\Repositories
 * @version May 2, 2025, 7:52 pm -04
*/

class CobroRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_cliente',
        'id_venta',
        'fecha_cobro',
        'cajero',
        'observacion'
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
        return Cobro::class;
    }
}
