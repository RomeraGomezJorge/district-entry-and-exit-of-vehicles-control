<?php

namespace App\Backoffice\VehicleBodyType\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Backoffice\VehicleBodyType\Domain\Exception\NonUniqueVehicleBodyTypeDescription;
use App\Shared\Domain\ValueObject\Uuid;
use DateTime;

class VehicleBodyType extends AggregateRoot
{
    private $id;
    
    private $description;
    
    private $image;
    
    private $createAt;
    
    public static function create(
        Uuid $id,
        string $description,
        ?string $image,
        DateTime $createAt,
        UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification
    ): self
    {
        if ( !$uniqueVehicleBodyTypeDescriptionSpecification->isSatisfiedBy( $description ) ) {
            throw new NonUniqueVehicleBodyTypeDescription( $description );
        }
        
        $vehicleBodyType = new self();
        
        $vehicleBodyType->id = $id;
        
        $vehicleBodyType->description = $description;
        
        $vehicleBodyType->image = $image;
        
        $vehicleBodyType->createAt = $createAt;
        
        $vehicleBodyType->record( new VehicleBodyTypeCreatedDomainEvent( $id->value(), $description ) );
        
        return $vehicleBodyType;
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
        UniqueVehicleBodyTypeDescriptionSpecification $uniqueTagDescriptionSpecification
    ): void
    {
        if ( !$uniqueTagDescriptionSpecification->isSatisfiedBy( $description ) ) {
            throw new NonUniqueVehicleBodyTypeDescription( $description );
        }
        
        $this->description = $description;
    }
    
    public function getCreateAt()
    {
        return $this->createAt;
    }
    
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    public function setImage( ?string $image ): void
    {
        $this->image = $image;
    }
    
}
