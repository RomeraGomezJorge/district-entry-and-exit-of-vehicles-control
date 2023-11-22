<?php

namespace App\Backoffice\VehiclePassenger\Application\Create;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Backoffice\IdentityCardType\Application\Find\IdentityCardTypeFinder;
use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
use App\Backoffice\VehiclePassenger\Domain\VehiclePassenger;
use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl
{
    private VehiclePassengerRepository $repository;
    private EventBus $bus;
    private DistrictEntryAndExitOfVehiclesControlFinder $finderDistrictEntryAndExitOfVehiclesControl;
    private IdentityCardTypeFinder $finderIdentityCardType;

    public function __construct(
        VehiclePassengerRepository                      $repository,
        DistrictEntryAndExitOfVehiclesControlRepository $districtEntryAndExitOfVehiclesControlRepository,
        IdentityCardTypeRepository                      $identityCardTypeRepository,
        EventBus                                        $bus
    )
    {
        $this->repository                                  = $repository;
        $this->finderDistrictEntryAndExitOfVehiclesControl = new DistrictEntryAndExitOfVehiclesControlFinder($districtEntryAndExitOfVehiclesControlRepository);
        $this->finderIdentityCardType                      = new IdentityCardTypeFinder($identityCardTypeRepository);
        $this->bus                                         = $bus;
    }

    public function __invoke(
        string $districtEntryAndExitOfVehiclesControlId,
               $passengers
    )
    {
        $districtEntryAndExitOfVehiclesControl = $this->finderDistrictEntryAndExitOfVehiclesControl
            ->__invoke($districtEntryAndExitOfVehiclesControlId);

        $vehiclePassengers = [];

        foreach ($passengers as $passenger) {
            $id = Uuid::random();

            $createAt = new \DateTime();

            $identityCardType = $this->finderIdentityCardType->__invoke($passenger->identityCardTypeId);

            $vehiclePassengers[] = VehiclePassenger::create(
                $id,
                trim($passenger->name),
                trim($passenger->surname),
                trim($passenger->identityCard),
                trim($passenger->phone),
                trim($passenger->address),
                $districtEntryAndExitOfVehiclesControl,
                $identityCardType,
                trim($passenger->temperatureControl),
                $createAt
            );
        }

        $this->repository->saveMultiple($vehiclePassengers);

        foreach ($vehiclePassengers as $vehiclePassenger) {
            $this->bus->publish(...$vehiclePassenger->pullDomainEvents());
        }
    }
}
