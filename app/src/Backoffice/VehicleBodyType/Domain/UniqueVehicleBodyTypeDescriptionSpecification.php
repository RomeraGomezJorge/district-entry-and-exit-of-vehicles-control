<?php

namespace App\Backoffice\VehicleBodyType\Domain;

interface UniqueVehicleBodyTypeDescriptionSpecification
{
    public function isSatisfiedBy(string $description): bool;
}
