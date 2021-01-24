<?php
	declare(strict_types=1);
	
	namespace App\Backoffice\VehicleMakerName\Domain\Exception;
	
	use App\Shared\Domain\DomainError;
	
	final class VehicleMakerNameNotExist extends DomainError
	{
		private string $id;
		
		public function __construct(string $id)
		{
			$this->id = $id;
			
			parent::__construct();
		}
		
		public function errorCode(): string
		{
			return 'vehicle_maker_name_not_exist';
		}
		
		protected function errorMessage(): string
		{
			return sprintf('La marca de vehiculo con el id "%s" no existe!', $this->id);
		}
	}