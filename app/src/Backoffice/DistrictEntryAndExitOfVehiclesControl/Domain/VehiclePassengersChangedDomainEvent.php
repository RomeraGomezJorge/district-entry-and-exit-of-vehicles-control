<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class VehiclePassengersChangedDomainEvent extends DomainEvent
{
    private string $vehiclePassengers;

    public function __construct(
        string $id,
        string $vehiclePassengers,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->vehiclePassengers = $vehiclePassengers;
    }

    public static function eventName(): string
    {
        return 'district_entry_and_exit_of_vehicles_control.vehicle_passenger_changed';
    }

    public function vehiclePassengers(): string
    {
        return $this->vehiclePassengers;
    }
}
