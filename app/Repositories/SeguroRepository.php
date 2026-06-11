<?php

namespace App\Repositories;

use App\Models\Seguro;
use App\Repositories\BaseRepository;

/**
 * Class SeguroRepository
 * @package App\Repositories
 * @version January 20, 2023, 6:58 pm -03
*/

class SeguroRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'estado_civil',
        'edad',
        'usted_es',
        'padece_enfermedad',
        'especificar_enfermedad',
        'presenta_defecto_fisico',
        'especifique_defecto_fisico',
        'estatura',
        'peso',
        'plan',
        'nombre_apellido_fallecimiento_titular',
        'parentesco_titular_beneficiario',
        'ci_beneficiario',
        'porcentaje_cesion',
        'fechanac_beneficiario'
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
        return Seguro::class;
    }
}
