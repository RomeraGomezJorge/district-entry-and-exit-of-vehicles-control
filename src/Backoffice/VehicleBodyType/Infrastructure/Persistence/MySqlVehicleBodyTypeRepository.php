<?php
	
	
	namespace App\Backoffice\VehicleBodyType\Infrastructure\Persistence;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	
	final class MySqlVehicleBodyTypeRepository extends DoctrineRepository implements VehicleBodyTypeRepository
	{
		public function save(VehicleBodyType $district): void
		{
			$this->persist($district);
		}
		
		public function search(Uuid $id): ?VehicleBodyType
		{
			return $this->repository(VehicleBodyType::class)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(VehicleBodyType::class)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(VehicleBodyType::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(VehicleBodyType::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(VehicleBodyType::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(VehicleBodyType $district): void
		{
			$this->remove($district);
		}
	}