<?php
	
	
	namespace App\Backoffice\ReasonForTrip\Infrastructure\Persistence;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\ReasonForTrip\Domain\ReasonForTrip;
	use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	
	final class MySqlReasonForTripRepository extends DoctrineRepository implements ReasonForTripRepository
	{
		public function save(ReasonForTrip $reasonForTrip): void
		{
			$this->persist($reasonForTrip);
		}
		
		public function search(Uuid $id): ?ReasonForTrip
		{
			return $this->repository(ReasonForTrip::class)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(ReasonForTrip::class)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(ReasonForTrip::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(ReasonForTrip::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(ReasonForTrip::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(ReasonForTrip $reasonForTrip): void
		{
			$this->remove($reasonForTrip);
		}
	}