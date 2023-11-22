<?php

namespace App\Backoffice\VehiclePassenger\Domain;

use App\Shared\Domain\Criteria\Criteria;

interface VehiclePassengerRepository
{
    public function saveMultiple(array $arrayOfVehiclePassengers): void;

    public function deleteMultiple(array $VehiclePassenger): void;

    public function findVehiclePassengersIn(string $districtEntryAndExitOfVehiclesControlId): array;

    public function findByName(string $nameToFind): array;

    public function matching(Criteria $criteria): array;
}
