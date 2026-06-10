<?php

namespace App\Repositories;

use App\Models\Atleta;
use App\Repositories\BaseRepository;

/**
 * Class AtletaRepository
 * @package App\Repositories
 * @version January 23, 2024, 9:17 pm -03
*/

class AtletaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombres',
        'apellidos',
        'ci',
        'sexo',
        'celular',
        'ciudad',
        'departamento',
        'categoria',
        'tipo_categoria',
        'nombre_equipo',
        'federacion_id',
        'uci_id',
        'modo',
        'id_user'
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
        return Atleta::class;
    }
}
