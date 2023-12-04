<?php

namespace App\Shared\Infrastructure\Utils;

final class FilterUtilsForFieldThatNotBelongToAnEntity
{
    public static function isDefineAsFilter(array $filters, string $fieldNameToFind): bool
    {
        /* obtiene un array con todos los campos por los que se puede buscar */
        $fieldsFoundInFilters = array_column($filters, 'field');

        /* comprueba si el campo enviado se encuentra de los campo de busqueda encontrados */
        return (in_array($fieldNameToFind, $fieldsFoundInFilters));

    }

    public static function getValueFromFilters(array $filters, string $fieldName): ?string
    {
        foreach ($filters as $filter) {
            if ($filter['field'] === $fieldName) {
                return $filter['value'];
            }
        }

        return null;
    }

    public static function removeFilterEqualsTo(array $fieldsNamesToRemove, array $filters): array
    {
        foreach ($filters as $key => $filter) {
            if (in_array($filter['field'], $fieldsNamesToRemove)) {
                unset($filters[$key]);
            }
        }

        return $filters;
    }

    public static function removeFilterNotEqualsTo(array $fieldsNameToPreserve, array $filters): array
    {
        foreach ($filters as $key => $filter) {
            if (!in_array($filter['field'], $fieldsNameToPreserve)) {
                unset($filters[$key]);
            }
        }

        return $filters;
    }
}
