<?php

declare(strict_types=1);

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent extends DomainEvent
{
    private string $id;
    private string $licensePlate;
    private string $modelOfVehicle;
    private string $tripOrigin;
    private string $tripDestination;
    private string $reasonForTrip;
    private string $trafficPoliceBooth;
    private string $vehiclePassengers;

    public function __construct(
        string $id,
        string $licensePlate,
        string $modelOfVehicle,
        string $tripOrigin,
        string $tripDestination,
        string $reasonForTrip,
        string $trafficPoliceBooth,
        string $vehiclePassengers,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($id, $eventId, $occurredOn);
        $this->licensePlate       = $licensePlate;
        $this->modelOfVehicle     = $modelOfVehicle;
        $this->tripOrigin         = $tripOrigin;
        $this->tripDestination    = $tripDestination;
        $this->reasonForTrip      = $reasonForTrip;
        $this->trafficPoliceBooth = $trafficPoliceBooth;
        $this->vehiclePassengers  = $vehiclePassengers;
    }

    public static function eventName(): string
    {
        return 'district_entry_and_exit_of_vehicles_control.created';
    }

    public function licensePlate(): string
    {
        return $this->licensePlate;
    }

    public function modelOfVehicle(): string
    {
        return $this->modelOfVehicle;
    }

    public function tripOrigin(): string
    {
        return $this->tripOrigin;
    }

    public function tripDestination(): string
    {
        return $this->tripDestination;
    }

    public function reasonForTrip(): string
    {
        return $this->reasonForTrip;
    }

    public function trafficPoliceBooth(): string
    {
        return $this->trafficPoliceBooth;
    }

    public function vehiclePassengers(): string
    {
        return $this->vehiclePassengers;
    }
}
