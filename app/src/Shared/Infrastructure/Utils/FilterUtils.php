<?php
	
	
	namespace App\Shared\Infrastructure\Utils;
	
	
	final class FilterUtils
	{
		public static function createAnArrayToUseAsAFilter(?string $stringOfFilterArrayStruct): array
		{
			if ($stringOfFilterArrayStruct === null) {
				return array();
			}
            
            $filters = self::convertStringToArray( $stringOfFilterArrayStruct );
			
			if (!isset($filters)) {
				return array();
			}
			
			return $filters;
		}
        
        private static function convertStringToArray( string $stringWithArrayStruct )
        {
            /* Analiza str como si fuera un string de consulta pasado por medio de un URL y establece variables
            en el ámbito actual. En el caso de los filtros en la url saldria algo similar a esto "filters%5B0%5D%5Bfield%5D=vehicl"
            por lo tanto se crea un variable de ambito local $filters
            */
            parse_str( $stringWithArrayStruct );
            
            return $filters;
        }
        
    }