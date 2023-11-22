<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain;

use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;

interface DistrictEntryAndExitOfVehiclesControlRepository
{
    public function save(DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl): void;

    public function search(Uuid $id): ?DistrictEntryAndExitOfVehiclesControl;

    public function searchAll(): array;

    public function matching(Criteria $criteria, ?array $vehiclePassengersFound): ?array;

    public function totalMatchingRows(Criteria $criteria, ?array $vehiclePassengers): int;

    public function delete(DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl): void;
}
