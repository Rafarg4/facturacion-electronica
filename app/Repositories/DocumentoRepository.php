<?php

namespace App\Repositories;

use App\Models\Documento;
use App\Repositories\BaseRepository;

/**
 * Class DocumentoRepository
 * @package App\Repositories
 * @version January 2, 2023, 11:01 pm UTC
*/

class DocumentoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'archivo_pago',
        'archivo_inscripcion'
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
        return Documento::class;
    }
}
