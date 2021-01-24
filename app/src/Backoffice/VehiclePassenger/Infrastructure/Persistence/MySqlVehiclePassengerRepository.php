<?php
	
	namespace App\Backoffice\VehiclePassenger\Infrastructure\Persistence;
	
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassenger;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	
	
	final class MySqlVehiclePassengerRepository extends DoctrineRepository implements VehiclePassengerRepository
	{
		public function saveMultiple(array $arrayOfVehiclePassenger): void
		{
			$this->persistMultipleEntities($arrayOfVehiclePassenger);
		}
		
		public function matching(Criteria $criteria): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(VehiclePassenger::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function findByName(string $nameToFind): Array
		{
			return $this->repository(VehiclePassenger::class)->find(['name' => $nameToFind])->toArray();
		}
		
		public function deleteMultiple(array $arrayOfVehiclePassenger): void
		{
			$this->removeMultipleEntities($arrayOfVehiclePassenger);
		}
		
		public function findVehiclePassengersIn(string $districtEntryAndExitOfVehiclesControlId): array
		{
			$qb = $this->entityManager()->createQueryBuilder();
			
			return $qb->select('VehiclePassenger')
				->from(VehiclePassenger::class, 'VehiclePassenger')
				->join('VehiclePassenger.districtEntryAndExitOfVehiclesControl', 'control')
				->where('control.id = :districtEntryAndExitOfVehiclesControlId')
				->setParameter('districtEntryAndExitOfVehiclesControlId', $districtEntryAndExitOfVehiclesControlId)
				->getQuery()
				->execute();
		}
	}