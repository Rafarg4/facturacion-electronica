<?php

namespace App\Repositories;

use App\Models\Venta;
use App\Repositories\BaseRepository;

/**
 * Class VentaRepository
 * @package App\Repositories
 * @version May 1, 2025, 6:11 pm -04
*/

class VentaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_cliente',
        'fecha_venta',
        'id_usuario',
        'tipo_comprobante',
        'numero_comprobante',
        'total',
        'iva',
        'forma_pago',
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
        return Venta::class;
    }
}
