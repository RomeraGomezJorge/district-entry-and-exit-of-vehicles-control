<?php

declare(strict_types=1);

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
        parent::__construct($id, $eventId, $occurredOn);

        $this->description        = $description;
        $this->vehicleMakerNameId = $vehicleMakerNameId;
        $this->vehicleBodyType    = $vehicleBodyType;
    }

    public static function eventName(): string
    {
        return 'model_of_vehicle.created';
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
