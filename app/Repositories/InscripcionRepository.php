<?php

namespace App\Repositories;

use App\Models\Inscripcion;
use App\Repositories\BaseRepository;

/**
 * Class InscripcionRepository
 * @package App\Repositories
 * @version December 17, 2022, 11:55 am UTC
*/

class InscripcionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'primer_nombre',
        'segundo_nombre',
        'fechanac',
        'ci',
        'sexo',
        'grupo_sanguineo',
        'nacionalidad',
        'celular',
        'domiciolio',
        'ciudad',
        'id_categoria',
        'nombre_equipo',
        'contacto_emergencia',
        'nombre_apellido_contacto_emergencia',
        'foto'
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
        return Inscripcion::class;
    }
}
