<?php
	
	
	namespace App\Backoffice\VehicleMakerName\Infrastructure\Persistence;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	
	final class MySqlVehicleMakerNameRepository extends DoctrineRepository implements VehicleMakerNameRepository
	{
		public function save(VehicleMakerName $district): void
		{
			$this->persist($district);
		}
		
		public function search(Uuid $id): ?VehicleMakerName
		{
			return $this->repository(VehicleMakerName::class)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(VehicleMakerName::class)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(VehicleMakerName::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(VehicleMakerName::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(VehicleMakerName::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(VehicleMakerName $district): void
		{
			$this->remove($district);
		}
	}
	
	