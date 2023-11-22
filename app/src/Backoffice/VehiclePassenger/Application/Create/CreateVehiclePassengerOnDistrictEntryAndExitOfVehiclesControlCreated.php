<?php

namespace App\Backoffice\VehiclePassenger\Application\Create;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent;
use App\Shared\Domain\Bus\Event\DomainEventSubscriber;
use App\Shared\Domain\UuidGenerator;

class CreateVehiclePassengerOnDistrictEntryAndExitOfVehiclesControlCreated implements DomainEventSubscriber
{
    private AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl $addPassenger;
    private UuidGenerator $uuidGenerator;

    public static function subscribedTo(): array
    {
        return [DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent::class];
    }

    public function __construct(
        AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl $addPassenger,
        UuidGenerator                                              $uuidGenerator
    )
    {
        $this->addPassenger  = $addPassenger;
        $this->uuidGenerator = $uuidGenerator;
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
