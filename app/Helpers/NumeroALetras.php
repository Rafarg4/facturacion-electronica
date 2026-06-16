<?php

namespace App\Helpers;

class NumeroALetras
{
    public static function convertir($numero)
    {
        $fmt = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);

        return mb_strtoupper($fmt->format($numero), 'UTF-8');
    }
}