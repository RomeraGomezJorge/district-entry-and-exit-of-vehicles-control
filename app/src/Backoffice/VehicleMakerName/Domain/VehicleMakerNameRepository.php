<?php
	
	namespace App\Backoffice\VehicleMakerName\Domain;
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	
	interface VehicleMakerNameRepository
	{
		public function save(VehicleMakerName $vehicleMakerName): void;
		
		public function search(Uuid $id): ?VehicleMakerName;
		
		public function searchAll(): array;
		
		public function matching(Criteria $criteria): array;
		
		public function totalMatchingRows(Criteria $criteria): int;
		
		public function delete(VehicleMakerName $vehicleMakerName): void;
        
        public function getAllVehicleMakerNameWithBodyType();
	}