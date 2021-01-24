<?php
	
	namespace App\Backoffice\VehicleBodyType\Domain;
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	
	interface VehicleBodyTypeRepository
	{
		public function save(VehicleBodyType $vehicleBodyType): void;
		
		public function search(Uuid $id): ?VehicleBodyType;
		
		public function searchAll(): array;
		
		public function matching(Criteria $criteria): array;
		
		public function totalMatchingRows(Criteria $criteria): int;
		
		public function delete(VehicleBodyType $vehicleBodyType): void;
	}