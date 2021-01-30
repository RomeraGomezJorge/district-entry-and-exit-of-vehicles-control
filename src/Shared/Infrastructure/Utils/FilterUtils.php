<?php
	
	
	namespace App\Shared\Infrastructure\Utils;
	
	
	final class FilterUtils
	{
		
		public static function getAValidValueForFilter(?string $stringOfFilterArrayStruct): array
		{
			if ($stringOfFilterArrayStruct === null) {
				return array();
			}
			
			parse_str($stringOfFilterArrayStruct);
			
			if (!isset($filters)) {
				return array();
			}
			
			return $filters;
		}
	}