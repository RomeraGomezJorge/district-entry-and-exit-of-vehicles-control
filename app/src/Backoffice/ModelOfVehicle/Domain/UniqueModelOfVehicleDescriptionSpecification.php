<?php

namespace App\Backoffice\ModelOfVehicle\Domain;

interface UniqueModelOfVehicleDescriptionSpecification
{
    public function isSatisfiedBy(
        string $description,
        ?string $vehicleMakerNameId
    ): bool;
}
