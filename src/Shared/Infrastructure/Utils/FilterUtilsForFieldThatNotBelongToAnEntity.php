<?php
	
	
	namespace App\Shared\Infrastructure\Utils;
	
	final class FilterUtilsForFieldThatNotBelongToAnEntity
	{
		
		public static function isDefineAsFilter(array $filters,string  $fieldName):bool
		{
			$fieldsInFilters = array_column($filters, 'field');
			
			$valuesInFilters = array_column($filters, 'value');
			
			if (!in_array($fieldName, $fieldsInFilters)) {
				return false;
			}
			
			$keyWithParentId = array_search($fieldName, $fieldsInFilters);
			
			if ($keyWithParentId === false) {
				return false;
			}
			
			if (!isset($valuesInFilters[$keyWithParentId])) {
				return false;
			}
			
			return true;
		}
		
		public static function getFromFilters(array $filters,$fieldName): ?string
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
		
		public static function removeFilter(array $filters,$fieldName): array
		{
			$fieldsInFilters = array_column($filters, 'field');
			
			if (!in_array($fieldName, $fieldsInFilters)) {
				return $filters;
			}
			
			$keyWithParentIdFilter = array_search($fieldName, $fieldsInFilters);
			
			if ($keyWithParentIdFilter === false) {
				return $filters;
			}
			
			if (!isset($filters[$keyWithParentIdFilter])) {
				return $filters;
			}
			
			unset($filters[$keyWithParentIdFilter]);
			
			return $filters;
		}
	
	}