<?php

namespace App\Backoffice\ModelOfVehicle\Application\Update;

use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification;
use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;

final class ModelOfVehicleUpdater
{
    private ModelOfVehicleRepository                     $repository;
    
    private ModelOfVehicleFinder                         $finder;
    
    private VehicleBodyTypeFinder                        $finderVehicleBodyType;
    
    private VehicleMakerNameFinder                       $finderVehicleMakerName;
    
    private UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification;
    
    public function __construct(
        ModelOfVehicleRepository $repository,
        UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification,
        VehicleMakerNameRepository $vehicleMakerNameRepository,
        VehicleBodyTypeRepository $vehicleBodyTypeRepository
    )
    {
        $this->repository = $repository;
        $this->finder = new ModelOfVehicleFinder( $repository );
        $this->finderVehicleMakerName = new VehicleMakerNameFinder( $vehicleMakerNameRepository );
        $this->finderVehicleBodyType = new VehicleBodyTypeFinder( $vehicleBodyTypeRepository );
        $this->uniqueModelOfVehicleDescriptionSpecification = $uniqueModelOfVehicleDescriptionSpecification;
    }
    
    public function __invoke(
        string $id,
        string $newDescription,
        string $newVehicleMakerNameId,
        string $newVehicleBodyTypeId
    ): void
    {
        $modelOfVehicle = $this->finder->__invoke( $id );
        
        $newVehicleMakerName = $this->finderVehicleMakerName->__invoke( new Uuid( $newVehicleMakerNameId ) );
        
        $newVehicleBodyTypeId = $this->finderVehicleBodyType->__invoke( new Uuid( $newVehicleBodyTypeId ) );
        
        if ( $this->hasDescriptionChanged( $newDescription, $modelOfVehicle ) ) {
            $modelOfVehicle->setDescription( $newDescription, $this->uniqueModelOfVehicleDescriptionSpecification );
        }
        
        if ( $this->hasVehicleMakerNameChanged( $newVehicleMakerName, $modelOfVehicle ) ) {
            $modelOfVehicle->setVehicleMakeName( $newVehicleMakerName );
        }
        
        if ( $this->hasVehicleBodyTypeChanged( $newVehicleBodyTypeId, $modelOfVehicle ) ) {
            $modelOfVehicle->setVehicleBodyType( $newVehicleBodyTypeId );
        }
        
        $this->repository->save( $modelOfVehicle );
    }
    
    private function hasDescriptionChanged(
        string $newDescription,
        ModelOfVehicle $modelOfVehicle
    ): bool
    {
        return !StringUtils::equals( $newDescription, $modelOfVehicle->getDescription() );
    }
    
    private function hasVehicleMakerNameChanged(
        VehicleMakerName $newVehicleMakerName,
        ModelOfVehicle $modelOfVehicle
    ): bool
    {
        return !StringUtils::equals( $newVehicleMakerName->getId(), $modelOfVehicle->geTVehicleMakerName()->getId() );
    }
    
    private function hasVehicleBodyTypeChanged(
        VehicleBodyType $newVehicleBodyType,
        ModelOfVehicle $modelOfVehicle
    ): bool
    {
        return !StringUtils::equals( $newVehicleBodyType->getId(), $modelOfVehicle->geTVehicleMakerName()->getId() );
    }
    
}