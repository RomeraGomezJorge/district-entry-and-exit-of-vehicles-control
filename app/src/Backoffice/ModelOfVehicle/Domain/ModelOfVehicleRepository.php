<?php

namespace App\Backoffice\ModelOfVehicle\Domain;

use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;

interface ModelOfVehicleRepository
{
    public function save(ModelOfVehicle $modelOfVehicle): void;

    public function search(Uuid $id): ?ModelOfVehicle;

    public function searchAll(): array;

    public function matching(Criteria $criteria, ?VehicleMakerName $vehicleMakerName): array;

    public function totalMatchingRows(Criteria $criteria, ?VehicleMakerName $vehicleMakerName): int;

    public function delete(ModelOfVehicle $modelOfVehicle): void;
}
