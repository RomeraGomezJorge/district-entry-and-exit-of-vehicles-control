<?php
	
	
	namespace App\Backoffice\District\Domain;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	
	interface DistrictRepository
	{
		public function save(District $district): void;
		
		public function search(Uuid $id): ?District;
		
		public function searchAll(): array;
		
		public function matching(Criteria $criteria): array;
		
		public function totalMatchingRows(Criteria $criteria): int;
		
		public function delete(District $district): void;
	}