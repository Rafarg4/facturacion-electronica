<?php

namespace App\Repositories;

use App\Models\Cotizacion;
use App\Repositories\BaseRepository;

/**
 * Class CotizacionRepository
 * @package App\Repositories
 * @version May 29, 2026, 8:14 pm -04
*/

class CotizacionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tipo_moneda',
        'compra',
        'venta'
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
        return Cotizacion::class;
    }
}
