<?php
	
	
	namespace App\Backoffice\VehicleBodyType\Infrastructure\Persistence;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	use Doctrine\Common\Collections\Collection;
	
	final class MySqlVehicleBodyTypeRepository extends DoctrineRepository implements VehicleBodyTypeRepository
	{
		const NOT_SETTING_VALUE = null;
		const ENTITY_CLASS = VehicleBodyType::class;
		private ?int $totalMatchingRows = null;
		
		public function save(VehicleBodyType $district): void
		{
			$this->persist($district);
		}
		
		public function search(Uuid $id): ?VehicleBodyType
		{
			return $this->repository(self::ENTITY_CLASS)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(self::ENTITY_CLASS)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(self::ENTITY_CLASS)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria): array
		{
			$matching = $this->getMatchingFrom($criteria);
			
			$this->totalMatchingRows = $matching->count();
			
			return $matching->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			if ($this->totalMatchingRows === self::NOT_SETTING_VALUE) {
				return $this->getMatchingFrom($criteria)->count();
			}
			
			return $this->totalMatchingRows;
		}
		
		public function delete(VehicleBodyType $district): void
		{
			$this->remove($district);
		}
		
		private function getMatchingFrom(Criteria $criteria): Collection
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(self::ENTITY_CLASS)->matching($doctrineCriteria);
		}
	}