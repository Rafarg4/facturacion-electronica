<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuración personalizada para proc_open
    |--------------------------------------------------------------------------
    |
    | Puedes configurar valores específicos para proc_open aquí.
    |
    */
    'proc_open' => [
        'descriptor_spec' => [
            0 => ['pipe', 'r'], // STDIN
            1 => ['pipe', 'w'], // STDOUT
            2 => ['pipe', 'w'], // STDERR
        ],
        'pipes' => null,
        'cwd' => null,
        'env' => null,
    ],

];