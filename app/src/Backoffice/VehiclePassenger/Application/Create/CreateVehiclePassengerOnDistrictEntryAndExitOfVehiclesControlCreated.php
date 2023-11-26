<?php

namespace App\Backoffice\VehiclePassenger\Application\Create;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent;
use App\Shared\Domain\Bus\Event\DomainEventSubscriber;

class CreateVehiclePassengerOnDistrictEntryAndExitOfVehiclesControlCreated implements DomainEventSubscriber
{
    private AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl $addPassenger;

    public static function subscribedTo(): array
    {
        return [DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent::class];
    }

    public function __construct(
        AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl $addPassenger
    ) {
        $this->addPassenger = $addPassenger;
    }

    public function __invoke(DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent $event): void
    {
        $districtEntryAndExitOfVehiclesControlId = $event->aggregateId();

        $vehiclePassengers = json_decode($event->vehiclePassengers());

        $this->addPassenger->__invoke(
            $districtEntryAndExitOfVehiclesControlId,
            $vehiclePassengers
        );
    }
}
