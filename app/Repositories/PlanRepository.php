<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Repositories\BaseRepository;

class PlanRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'empresa',
        'descripcion',
        'estado',
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return Plan::class;
    }
}
