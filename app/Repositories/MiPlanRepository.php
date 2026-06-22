<?php

namespace App\Repositories;

use App\Models\MiPlan;
use App\Repositories\BaseRepository;

/**
 * Class MiPlanRepository
 * @package App\Repositories
 * @version June 21, 2026, 3:32 pm -04
*/

class MiPlanRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'empresa',
        'nro_cuota',
        'fecha_vencimiento',
        'fecha_pago',
        'monto_cuota',
        'saldo_cuota',
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
        return MiPlan::class;
    }
}
