<?php

namespace App\Backoffice\VehicleMakerName\Infrastructure\Persistence;

use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Collection;

final class MySqlVehicleMakerNameRepository extends DoctrineRepository implements VehicleMakerNameRepository
{
	const NOT_SETTING_VALUE = null;
	const ENTITY_CLASS = VehicleMakerName::class;
	private ?int $totalMatchingRows = null;
    public function save( VehicleMakerName $district ): void
    {
        $this->persist( $district );
    }
    
    public function search( Uuid $id ): ?VehicleMakerName
    {
        return $this->repository( VehicleMakerName::class )->find( $id );
    }
    
    public function searchAll(): array
    {
        return $this->repository( VehicleMakerName::class )->findAll();
    }
    
    public function isDescriptionExits( array $criteria ): bool
    {
        $isUnique = (bool)$this->repository( VehicleMakerName::class )->findOneBy( $criteria );
        
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
    
    public function delete( VehicleMakerName $district ): void
    {
        $this->remove( $district );
    }
    
    public function getAllVehicleMakerNameWithBodyType()
    {
        $conn = $this->entityManager()->getConnection();
        
        $sql = '
            SELECT
                maker.id,
                maker.description,
                body.id AS vehicleBodyTypeId,
                body.description AS vehicleBodyTypeDescription
            FROM
                vehicle_maker_name AS maker
            INNER JOIN model_of_vehicle AS model
            ON
                maker.id = model.vehicle_make_name_id
            INNER JOIN vehicle_body_type AS body
            ON
                body.id = model.vehicleBodyTypeId
            GROUP BY
                maker.description,
                body.description
            ORDER BY maker.description ASC
                        ';
        
        $stmt = $conn->prepare( $sql );
        
        $stmt->execute();
        
        return $stmt->fetchAllAssociative();
    }
	
	private function getMatchingFrom(Criteria $criteria): Collection
	{
		$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
		
		return $this->repository(self::ENTITY_CLASS)->matching($doctrineCriteria);
	}
    
}
	
	