<?php
	
	
	namespace App\Shared\Infrastructure\Utils;
	
	
	final class ParentIdFilter
	{
		public static function isParentIdIsDefineAsFilter(array $filters):bool
		{
			$fieldsInFilters = array_column($filters, 'field');
			
			$valuesInFilters = array_column($filters, 'value');
			
			if (!in_array('parent.id', $fieldsInFilters)) {
				return false;
			}
			
			$keyWithParentId = array_search('parent.id', $fieldsInFilters);
			
			if ($keyWithParentId === false) {
				return false;
			}
			
			if (!isset($valuesInFilters[$keyWithParentId])) {
				return false;
			}
			
			return true;
		}
		
		public static function getParentIdIsDefineInFilters(array $filters): ?string
		{
			$fieldsInFilters = array_column($filters, 'field');
			
			$valuesInFilters = array_column($filters, 'value');
			
			if (!in_array('parent.id', $fieldsInFilters)) {
				return null;
			}
			
			$keyWithParentId = array_search('parent.id', $fieldsInFilters);
			
			if ($keyWithParentId === false) {
				return null;
			}
			
			if (!isset($valuesInFilters[$keyWithParentId])) {
				return null;
			}
			
			return $valuesInFilters[$keyWithParentId];
		}
		
		public static function removeParentIdFilter(array $filters): array
		{
			$fieldsInFilters = array_column($filters, 'field');
			
			if (!in_array('parent.id', $fieldsInFilters)) {
				return $filters;
			}
			
			$keyWithParentIdFilter = array_search('parent.id', $fieldsInFilters);
			
			if ($keyWithParentIdFilter === false) {
				return $filters;
			}
			
			if (!isset($filters[$keyWithParentIdFilter])) {
				return $filters;
			}
			
			unset($filters[$keyWithParentIdFilter]);
			
			return $filters;
		}
		
		public static function addFilterToDisplayParent(array $filters = []): array
		{
			array_push($filters,
				[
					'field' => 'parent',
					'operator' => '=',
					'value' => 'NULL'
				]);
			
			return $filters;
		}
		
		public static function appendFilterToDisplayChildrenCategories(array $filters = []): array
		{
			array_push($filters,
				[
					'field' => 'parent',
					'operator' => '<>',
					'value' => 'NULL'
				]);
			
			return $filters;
		}
	}