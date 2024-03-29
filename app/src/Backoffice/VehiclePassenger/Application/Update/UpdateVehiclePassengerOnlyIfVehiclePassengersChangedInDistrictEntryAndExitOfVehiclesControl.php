<?php

namespace App\Backoffice\VehiclePassenger\Application\Update;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\VehiclePassengersChangedDomainEvent;
use App\Backoffice\VehiclePassenger\Application\Create\AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl;
use App\Backoffice\VehiclePassenger\Application\Delete\DeleteVehiclePassengerByDistrictEntryAndExitOfVehiclesControl;
use App\Shared\Domain\Bus\Event\DomainEventSubscriber;

class UpdateVehiclePassengerOnlyIfVehiclePassengersChangedInDistrictEntryAndExitOfVehiclesControl implements DomainEventSubscriber
{
    private AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl $creator;
    private DeleteVehiclePassengerByDistrictEntryAndExitOfVehiclesControl $deleter;

    public static function subscribedTo(): array
    {
        return [VehiclePassengersChangedDomainEvent::class];
    }

    public function __construct(
        AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl $creator,
        DeleteVehiclePassengerByDistrictEntryAndExitOfVehiclesControl $deleter
    ) {
        $this->creator = $creator;
        $this->deleter = $deleter;
    }

    public function __invoke(VehiclePassengersChangedDomainEvent $event): void
    {
        $districtEntryAndExitOfVehiclesControlId = $event->aggregateId();

        $vehiclePassengers = json_decode($event->vehiclePassengers());

        $this->removePreviousVehiclePassengersIn($districtEntryAndExitOfVehiclesControlId);

        $this->addNewVehiclePassengersIn($districtEntryAndExitOfVehiclesControlId, $vehiclePassengers);
    }

    private function removePreviousVehiclePassengersIn(string $districtEntryAndExitOfVehiclesControlId): void
    {
        $this->deleter->__invoke($districtEntryAndExitOfVehiclesControlId);
    }

    private function addNewVehiclePassengersIn(
        string $districtEntryAndExitOfVehiclesControlId,
        $vehiclePassengers
    ): void {
        $this->creator->__invoke($districtEntryAndExitOfVehiclesControlId, $vehiclePassengers);
    }
}
