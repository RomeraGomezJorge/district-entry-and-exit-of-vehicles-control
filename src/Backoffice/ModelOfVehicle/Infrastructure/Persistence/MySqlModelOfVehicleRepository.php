<?php
	
	
	namespace App\Backoffice\ModelOfVehicle\Infrastructure\Persistence;
	
	
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
	
	final class MySqlModelOfVehicleRepository extends DoctrineRepository implements ModelOfVehicleRepository
	{
		public function save(ModelOfVehicle $district): void
		{
			$this->persist($district);
		}
		
		public function search(Uuid $id): ?ModelOfVehicle
		{
			return $this->repository(ModelOfVehicle::class)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(ModelOfVehicle::class)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(ModelOfVehicle::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria, ?VehicleMakerName $vehicleMakerName): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			$this->isNotNullAddAsFilter($vehicleMakerName, $doctrineCriteria);
			
			return $this->repository(ModelOfVehicle::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria, ?VehicleMakerName $vehicleMakerName): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			$this->isNotNullAddAsFilter($vehicleMakerName, $doctrineCriteria);
			
			return $this->repository(ModelOfVehicle::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(ModelOfVehicle $district): void
		{
			$this->remove($district);
		}
		
		private function isNotNullAddAsFilter(
			?VehicleMakerName $vehicleMakerName,
			DoctrineCriteria $doctrineCriteria
		): DoctrineCriteria {
			
			if (is_null($vehicleMakerName)) {
				return $doctrineCriteria;
			}
			
			return $doctrineCriteria->andWhere(
				DoctrineCriteria::expr()->eq(
					'vehicleMakerName',
					$vehicleMakerName
				)
			);
		}
	}
	
	