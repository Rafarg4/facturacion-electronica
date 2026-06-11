<?php

namespace App\Repositories;

use App\Models\Ranking;
use App\Repositories\BaseRepository;

/**
 * Class RankingRepository
 * @package App\Repositories
 * @version January 2, 2023, 11:49 pm UTC
*/

class RankingRepository extends BaseRepository
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
        '1_fecha',
        '2_fecha',
        '3_fecha',
        '4_fecha',
        'total'
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
        return Ranking::class;
    }
}
