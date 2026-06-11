<?php

namespace App\Repositories;

use App\Models\RankingMTB;
use App\Repositories\BaseRepository;

/**
 * Class RankingMTBRepository
 * @package App\Repositories
 * @version August 20, 2023, 4:18 pm -04
*/

class RankingMTBRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'posicion',
        'nombre_apellido',
        'categoria',
        'club',
        'sexo',
        'primer_fecha',
        'total',
        'ci'
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
        return RankingMTB::class;
    }
}
