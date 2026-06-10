<?php

namespace App\Repositories;

use App\Models\Banco;
use App\Repositories\BaseRepository;

/**
 * Class BancoRepository
 * @package App\Repositories
 * @version March 18, 2024, 6:51 pm -03
*/

class BancoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre_cuenta',
        'ci_ruc',
        'banco'
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
        return Banco::class;
    }
}
