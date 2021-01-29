<?php
	
	namespace App\Backoffice\ReasonForTrip\Domain;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	
	interface ReasonForTripRepository
	{
		public function save(ReasonForTrip $reasonForTrip): void;
		
		public function search(Uuid $id): ?ReasonForTrip;
		
		public function searchAll(): array;
		
		public function matching(Criteria $criteria): array;
		
		public function totalMatchingRows(Criteria $criteria): int;
		
		public function delete(ReasonForTrip $reasonForTrip): void;
	}