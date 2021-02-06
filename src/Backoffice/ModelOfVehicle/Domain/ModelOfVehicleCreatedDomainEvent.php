<?php

declare( strict_types = 1 );

namespace App\Backoffice\ModelOfVehicle\Domain;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class ModelOfVehicleCreatedDomainEvent extends DomainEvent
{
    private string $description;
    
    private string $vehicleMakerNameId;
    
    private string $vehicleBodyType;
    
    public function __construct(
        string $id,
        string $description,
        string $vehicleMakerNameId,
        string $vehicleBodyType,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct( $id, $eventId, $occurredOn );
        
        $this->description = $description;
        $this->vehicleMakerNameId = $vehicleMakerNameId;
        $this->vehicleBodyType = $vehicleBodyType;
    }
    
    public static function eventName(): string
    {
        return 'model_of_vehicle.created';
    }
    
    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent
    {
        return new self( $aggregateId,
            $body['description'],
            $body['vehicleMakerNameId'],
            $body['$vehicleBodyType'],
            $eventId,
            $occurredOn );
    }
    
    public function toPrimitives(): array
    {
        return [ 'description'        => $this->description,
                 'vehicleMakerNameId' => $this->vehicleMakerNameId,
                 'vehicleBodyType'    => $this->vehicleBodyType ];
    }
    
    public function description(): string
    {
        return $this->description;
    }
    
    public function vehicleMakerNameId(): string
    {
        return $this->vehicleMakerNameId;
    }
    
    public function vehicleBodyType(): string
    {
        return $this->vehicleBodyType;
    }
    
}
