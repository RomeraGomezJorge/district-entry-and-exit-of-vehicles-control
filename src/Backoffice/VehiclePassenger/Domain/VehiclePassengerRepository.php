<?php
	
	namespace App\Backoffice\VehiclePassenger\Domain;
	
	use App\Backoffice\Role\Domain\Role;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	
	interface VehiclePassengerRepository
	{
		public function saveMultiple(array $arrayOfVehiclePassengers): void;
		
		public function deleteMultiple(array $VehiclePassenger): void;
		
		public function findVehiclePassengersIn(string $districtEntryAndExitOfVehiclesControlId): array;
	}