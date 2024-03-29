<?php

declare(strict_types=1);

namespace App\Backoffice\VehicleMakerName\Domain;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class VehicleMakerNameCreatedDomainEvent extends DomainEvent
{
    private string $description;

    public function __construct(
        string $id,
        string $description,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);

        $this->description = $description;
    }

    public static function eventName(): string
    {
        return 'vehicle_maker_name.created';
    }

    public function description(): string
    {
        return $this->description;
    }
}
