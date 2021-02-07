<?php

namespace App\Backoffice\ModelOfVehicle\Domain;

use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Backoffice\ModelOfVehicle\Domain\Exception\NonUniqueModelOfVehicleDescription;
use App\Shared\Domain\ValueObject\Uuid;
use DateTime;

class ModelOfVehicle extends AggregateRoot
{
    private $id;
    
    private $description;
    
    private $createAt;
    
    private $vehicleMakerName;
    
    private $vehicleBodyType;
    
    public static function create(
        Uuid $id,
        string $description,
        VehicleMakerName $vehicleMakerName,
        VehicleBodyType $vehicleBodyType,
        DateTime $createAt,
        UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification
    ): self
    {
        if ( !$uniqueModelOfVehicleDescriptionSpecification->isSatisfiedBy( $description,
            $vehicleMakerName->getId() ) ) {
            throw new NonUniqueModelOfVehicleDescription( $description );
        }
        
        $modelOfVehicle = new self();
        
        $modelOfVehicle->id = $id;
        
        $modelOfVehicle->description = $description;
        
        $modelOfVehicle->vehicleMakerName = $vehicleMakerName;
        
        $modelOfVehicle->vehicleBodyType = $vehicleBodyType;
        
        $modelOfVehicle->createAt = $createAt;
        
        $modelOfVehicle->record( new ModelOfVehicleCreatedDomainEvent( $id->value(),
            $description,
            $vehicleMakerName->getId(),
            $vehicleBodyType->getId() ) );
        
        return $modelOfVehicle;
    }
    
    public function getId(): ?String
    {
        return $this->id;
    }
    
    public function setId( Uuid $id ): void
    {
        $this->id = $id;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(
        string $description,
        UniqueModelOfVehicleDescriptionSpecification $uniqueTagDescriptionSpecification
    ): void
    {
        if ( !$uniqueTagDescriptionSpecification->isSatisfiedBy( $description,
            $this->geTVehicleMakerName()->getId() ) ) {
            throw new NonUniqueModelOfVehicleDescription( $description );
        }
        
        $this->description = $description;
    }
    
    public function geTVehicleMakerName(): VehicleMakerName
    {
        return $this->vehicleMakerName;
    }
    
    public function getCreateAt()
    {
        return $this->createAt;
    }
    
    public function setVehicleMakeName( VehicleMakerName $vehicleMakeName )
    {
        $this->vehicleMakerName = $vehicleMakeName;
    }
    
    public function getVehicleBodyType(): VehicleBodyType
    {
        return $this->vehicleBodyType;
    }
    
    public function setVehicleBodyType( VehicleBodyType $vehicleBodyType ): void
    {
        $this->vehicleBodyType = $vehicleBodyType;
    }
    
}
