<?php
	
	
	namespace App\Backoffice\TrafficPoliceBooth\Infrastructure\Persistence;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	
	final class MySqlTrafficPoliceBoothRepository extends DoctrineRepository implements TrafficPoliceBoothRepository
	{
		public function save(TrafficPoliceBooth $trafficPoliceBooth): void
		{
			$this->persist($trafficPoliceBooth);
		}
		
		public function search(Uuid $id): ?TrafficPoliceBooth
		{
			return $this->repository(TrafficPoliceBooth::class)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(TrafficPoliceBooth::class)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(TrafficPoliceBooth::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(TrafficPoliceBooth::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(TrafficPoliceBooth::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(TrafficPoliceBooth $trafficPoliceBooth): void
		{
			$this->remove($trafficPoliceBooth);
		}
	}