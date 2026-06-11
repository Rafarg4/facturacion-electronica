<?php

namespace App\Repositories;

use App\Models\Prestamos;
use App\Repositories\BaseRepository;

/**
 * Class PrestamosRepository
 * @package App\Repositories
 * @version September 23, 2024, 7:54 pm -04
*/

class PrestamosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_cliente',
        'monto',
        'fecha_inicio',
        'fecha_pago',
        'fecha_vencimineto',
        'cantidad_cuota',
        'tipo_prestamo',
        'dias_mora',
        'id_electrodomestico'
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
        return Prestamos::class;
    }
}
