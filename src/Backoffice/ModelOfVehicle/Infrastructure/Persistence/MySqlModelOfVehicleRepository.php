<?php
	
	
	namespace App\Backoffice\ModelOfVehicle\Infrastructure\Persistence;
	
	
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
    use App\Shared\Infrastructure\Utils\StringUtils;
    use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
	
	final class MySqlModelOfVehicleRepository extends DoctrineRepository implements ModelOfVehicleRepository
	{
        const   DESCRIPTION_IS_NOT_IN_USE = false;
        
        const   DESCRIPTION_HAS_ALREADY_BEEN_CREATED_FOR_THIS_VEHICLE_MAKER_NAME = true;
	    
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
        
        public function isDescriptionExits(
            array $descriptionToFind,
            ?string $vehicleMakerNameId
        ): bool
        {
            $modelsOfVehicleFound = $this->repository( ModelOfVehicle::class )->findBy( $descriptionToFind );
            
            if ( $this->isDescriptionWasNotFound( $modelsOfVehicleFound ) ) {
                return self::DESCRIPTION_IS_NOT_IN_USE;
            }
            
            return $this->isDescriptionOfVehicleModelAlreadyCreatedInAVehicleMakerName( $vehicleMakerNameId,
                $modelsOfVehicleFound );
        }
        
        private function isDescriptionWasNotFound( array $modelsOfVehicleFound ): bool
        {
            return empty( $modelsOfVehicleFound );
        }
        
        private function isDescriptionOfVehicleModelAlreadyCreatedInAVehicleMakerName(
            ?string $vehicleMakerNameId,
            array $modelsOfVehicleFound
        ): bool
        {
            foreach ( $modelsOfVehicleFound as $modelOfVehicleFound ) {
                if ( !StringUtils::equals( $vehicleMakerNameId,
                    $modelOfVehicleFound->getVehicleMakerName()->getId() ) ) {
                    continue;
                }
                
                return self::DESCRIPTION_HAS_ALREADY_BEEN_CREATED_FOR_THIS_VEHICLE_MAKER_NAME;
            }
            
            return self::DESCRIPTION_IS_NOT_IN_USE;
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
	
	