<?php
	declare(strict_types=1);
	
	namespace App\Backoffice\VehiclePassenger\Domain\Exception;
	
	use App\Shared\Domain\DomainError;
	
	final class VehiclePassengerNotFound extends DomainError
	{
		private string $id;
		
		public function __construct(string $id)
		{
			$this->id = $id;
			
			parent::__construct();
		}
		
		public function errorCode(): string
		{
			return 'vehicle_passenger_not_exist';
		}
		
		protected function errorMessage(): string
		{
			return sprintf('En el control de ingreso con el id "%s" , no se han encontrado pasajeros registrados', $this->id);
		}
	}