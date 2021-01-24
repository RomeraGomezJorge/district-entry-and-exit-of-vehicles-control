<?php
	
	namespace App\Backoffice\VehiclePassenger\Domain;
	
	use App\Backoffice\Role\Domain\Role;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use PhpParser\Node\Expr\Array_;
	
	interface VehiclePassengerRepository
	{
		public function saveMultiple(array $arrayOfVehiclePassengers): void;
		
		public function deleteMultiple(array $VehiclePassenger): void;
		
		public function findVehiclePassengersIn(string $districtEntryAndExitOfVehiclesControlId): array;
		
		public function findByName(string $nameToFind): array;
		
		public function matching(Criteria $criteria): array;
	}