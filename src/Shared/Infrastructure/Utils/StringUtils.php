<?php

namespace App\Shared\Infrastructure\Utils;

final class StringUtils
{
    
    public static function equals(
        string $firstString,
        string $secondString
    )
    {
        /*Devuelve < 0 si str1 es menor que str2; > 0 si str1 es mayor que str2 y 0 si son iguales. */
        return strcmp( $firstString, $secondString ) === 0 ? true : false;
    }
    
}