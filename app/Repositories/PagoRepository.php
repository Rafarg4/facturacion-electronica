<?php

namespace App\Repositories;

use App\Models\Pago;
use App\Repositories\BaseRepository;

/**
 * Class PagoRepository
 * @package App\Repositories
 * @version January 20, 2024, 10:56 pm -03
*/

class PagoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tipo_pago',
        'comprobante',
        'fecha_pago',
        'estado',
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
        return Pago::class;
    }
}
