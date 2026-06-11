<?php

namespace App\Repositories;

use App\Models\Compra;
use App\Repositories\BaseRepository;

/**
 * Class CompraRepository
 * @package App\Repositories
 * @version May 11, 2025, 7:42 pm -04
*/

class CompraRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_proveedor',
        'fecha_compra',
        'tipo_comprobante',
        'numero_comprobante',
        'total',
        'iva',
        'forma_pago',
        'condicion_compra',
        'estado',
        'id_caja',
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
        return Compra::class;
    }
}
