<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\Persistence;

use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControl;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MySqlDistrictEntryAndExitOfVehiclesControlRepository extends DoctrineRepository implements DistrictEntryAndExitOfVehiclesControlRepository
{
    public function save( DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl ): void
    {
        $this->persist( $districtEntryAndExitOfVehiclesControl );
    }
    
    public function search( Uuid $id ): ?DistrictEntryAndExitOfVehiclesControl
    {
        return $this->repository( DistrictEntryAndExitOfVehiclesControl::class )->find( $id );
    }
    
    public function searchAll(): array
    {
        return $this->repository( DistrictEntryAndExitOfVehiclesControl::class )->findAll();
    }
    
    public function isDescriptionExits( array $criteria ): bool
    {
        $isUnique = (bool)$this->repository( DistrictEntryAndExitOfVehiclesControl::class )->findOneBy( $criteria );
        
        return $isUnique;
    }
    
    public function matching( Criteria $criteria ): array
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert( $criteria );
        
        return $this->repository( DistrictEntryAndExitOfVehiclesControl::class )->matching( $doctrineCriteria )->toArray();
    }
    
    public function totalMatchingRows( Criteria $criteria ): int
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert( $criteria );
        
        return $this->repository( DistrictEntryAndExitOfVehiclesControl::class )->matching( $doctrineCriteria )->count();
    }
    
    public function delete( DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl ): void
    {
        $this->remove( $districtEntryAndExitOfVehiclesControl );
    }
    
}