<?php
	
	namespace App\Backoffice\VehiclePassenger\Domain;
	
	use App\Backoffice\Role\Domain\Role;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	
	interface VehiclePassengerRepository
	{
		public function save(VehiclePassenger $VehiclePassenger): void;
		
		public function search(Uuid $id): ?VehiclePassenger;
		
		public function searchAll(): array;
		
		public function matching(Criteria $criteria): array;
		
		public function totalMatchingRows(Criteria $criteria): int;
		
		public function delete(VehiclePassenger $VehiclePassenger): void;
		
		public function findVehiclePassengersIn(string $districtEntryAndExitOfVehiclesControlId):array ;
	}