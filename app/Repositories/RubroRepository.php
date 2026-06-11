<?php

namespace App\Repositories;

use App\Models\Rubro;
use App\Repositories\BaseRepository;

/**
 * Class RubroRepository
 * @package App\Repositories
 * @version June 8, 2026, 10:16 am -04
*/

class RubroRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'estado'
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
        return Rubro::class;
    }
}
