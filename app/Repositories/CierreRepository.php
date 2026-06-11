<?php

namespace App\Repositories;

use App\Models\Cierre;
use App\Repositories\BaseRepository;

/**
 * Class CierreRepository
 * @package App\Repositories
 * @version September 23, 2024, 7:48 pm -04
*/

class CierreRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_cobrador',
        'monto_cierre',
        'fecha_cierre'
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
        return Cierre::class;
    }
}
