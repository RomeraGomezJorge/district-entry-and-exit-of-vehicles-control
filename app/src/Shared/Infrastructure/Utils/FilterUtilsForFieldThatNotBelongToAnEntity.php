<?php

namespace App\Shared\Infrastructure\Utils;

final class FilterUtilsForFieldThatNotBelongToAnEntity
{
    public static function isDefineAsFilter(array $filters, string $fieldNameToFind): bool
    {
        /* obtiene un array con todos los campos por los que se puede buscar */
        $fieldsFoundInFilters = array_column($filters, 'field');

        /* obtiene un array con todos los valores que se  buscan */
//          $valuesFoundInFilters = array_column($filters, 'value');

        /* comprueba si el campo enviado se encuentra de los campo de busqueda encontrados */
        if (!in_array($fieldNameToFind, $fieldsFoundInFilters)) {
            return false;
        }

//          $keyWithParentId = array_search($fieldNameToFind, $fieldsFoundInFilters);
//
//          if ($keyWithParentId === false) {
//              return false;
//          }
//
//          if (!isset($valuesFoundInFilters[$keyWithParentId])) {
//              return false;
//          }

        return true;
    }

    public static function getValueFromFilters(array $filters, string $fieldName): ?string
    {
        $fieldsInFilters = array_column($filters, 'field');

        $valuesInFilters = array_column($filters, 'value');

        if (!in_array($fieldName, $fieldsInFilters)) {
            return null;
        }

        $keyWithParentId = array_search($fieldName, $fieldsInFilters);

        if ($keyWithParentId === false) {
            return null;
        }

        if (!isset($valuesInFilters[$keyWithParentId])) {
            return null;
        }

        return $valuesInFilters[$keyWithParentId];
    }

    public static function removeFilterEqualsTo(array $fieldsNamesToRemove, array $filters): array
    {
        /* obtiene un array con todos los campos por los que se puede buscar */
        $fieldsFoundInFilters = array_column($filters, 'field');

        foreach ($fieldsFoundInFilters as $fieldFound) { /* si el campo a eliminar no esta entre los campos encontrados retorna los filtros tal cual los recibio  */
            if (!in_array($fieldFound, $fieldsNamesToRemove)) {
                continue;
            }

            $fieldNameToRemove = $fieldFound;

            /* obtiene la posicion del campo a eliminar */
            $keyToRemove = array_search($fieldNameToRemove, $fieldsFoundInFilters);

            /* comprueba si pudo obtener la posicion del campo a eliminar  */
            if ($keyToRemove === false) {
                return $filters;
            }

            /* remueve de los filtros el campo que desea eliminar */
            unset($filters[$keyToRemove]);
        }

        return $filters;
    }

    public static function removeFilterNotEqualsTo(array $fieldsNameToPreserve, array $filters): array
    {
        /* obtiene un array con todos los campos por los que se puede buscar */
        $fieldsFoundInFilters = array_column($filters, 'field');

        foreach ($fieldsFoundInFilters as $fieldFound) {
            /* si el campo a preservar esta entre los campos encontrados pasa a comprobar el siguiente elemento  */
            if (in_array($fieldFound, $fieldsNameToPreserve)) {
                continue;
            }

            $fieldNameToRemove = $fieldFound;

            /* obtiene la posicion del campo a eliminar */
            $keyToRemove = array_search($fieldNameToRemove, $fieldsFoundInFilters);

            /* comprueba si pudo obtener la posicion del campo a eliminar  */
            if ($keyToRemove === false) {
                return $filters;
            }

            /* remueve de los filtros el campo que desea eliminar */
            unset($filters[$keyToRemove]);
        }

        return $filters;
    }
}
