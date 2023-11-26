<?php

namespace App\Backoffice\VehiclePassenger\Application\Delete;

use App\Backoffice\VehiclePassenger\Application\FindByDistrictEntryAndExitOfVehiclesControl\FindVehiclePassengersByDistrictEntryAndExitOfVehiclesControl;
use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;

final class DeleteVehiclePassengerByDistrictEntryAndExitOfVehiclesControl
{
    private VehiclePassengerRepository $repository;
    private FindVehiclePassengersByDistrictEntryAndExitOfVehiclesControl $finder;

    public function __construct(
        VehiclePassengerRepository $repository,
        FindVehiclePassengersByDistrictEntryAndExitOfVehiclesControl $finder
    ) {
        $this->repository = $repository;

        $this->finder = $finder;
    }

    public function __invoke(string $districtEntryAndExitOfVehiclesControlId)
    {
        $vehiclePassengers = $this->finder->__invoke($districtEntryAndExitOfVehiclesControlId);

        $this->repository->deleteMultiple($vehiclePassengers);
    }
}
