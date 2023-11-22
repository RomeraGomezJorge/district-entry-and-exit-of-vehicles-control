<?php

namespace App\Backoffice\VehicleMakerName\Domain;

interface UniqueVehicleMakerNameDescriptionSpecification
{
    public function isSatisfiedBy(string $description): bool;
}
