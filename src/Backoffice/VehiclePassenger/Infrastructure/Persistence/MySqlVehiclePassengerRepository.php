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
		public function save(VehiclePassenger $VehiclePassenger): void
		{
			$this->persist($VehiclePassenger);
		}
		
		public function search(Uuid $id): ?VehiclePassenger
		{
			return $this->repository(VehiclePassenger::class)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(VehiclePassenger::class)->findAll();
		}
		
		public function matching(Criteria $criteria): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(VehiclePassenger::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(VehiclePassenger::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(VehiclePassenger $VehiclePassenger): void
		{
			$this->remove($VehiclePassenger);
		}
		
		
		public function findVehiclePassengersIn( string $districtEntryAndExitOfVehiclesControlId):array
		{
			$qb = $this->entityManager()->createQueryBuilder();
			
			return $qb->select('VehiclePassenger')
				->from(VehiclePassenger::class,'VehiclePassenger')
				->join('VehiclePassenger.districtEntryAndExitOfVehiclesControl','control')
				->where('control.id = :districtEntryAndExitOfVehiclesControlId')
				->setParameter('districtEntryAndExitOfVehiclesControlId',$districtEntryAndExitOfVehiclesControlId)
				->getQuery()
				->execute();
				
				
		}
	}