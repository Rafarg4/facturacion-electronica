<?php

namespace App\Repositories;

use App\Models\PresupuestoCabecera;
use App\Repositories\BaseRepository;

/**
 * Class PresupuestoCabeceraRepository
 * @package App\Repositories
 * @version June 14, 2026, 12:32 pm -04
*/

class PresupuestoCabeceraRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'cliente',
        'estado',
        'responsable',
        'descripcion',
        'sub_total',
        'total',
        'tipo_presupuesto'
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
        return PresupuestoCabecera::class;
    }
}
