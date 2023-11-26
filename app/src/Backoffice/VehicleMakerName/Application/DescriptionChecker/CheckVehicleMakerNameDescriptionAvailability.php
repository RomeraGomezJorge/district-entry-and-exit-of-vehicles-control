<?php

namespace App\Backoffice\VehicleMakerName\Application\DescriptionChecker;

use App\Backoffice\VehicleMakerName\Domain\UniqueVehicleMakerNameDescriptionSpecification;

final class CheckVehicleMakerNameDescriptionAvailability
{
    private UniqueVehicleMakerNameDescriptionSpecification $uniqueVehicleMakerNameDescriptionSpecification;

    public function __construct(
        UniqueVehicleMakerNameDescriptionSpecification $uniqueVehicleMakerNameDescriptionSpecification
    ) {
        $this->uniqueVehicleMakerNameDescriptionSpecification = $uniqueVehicleMakerNameDescriptionSpecification;
    }

    public function __invoke(string $description): bool
    {
        return $this->uniqueVehicleMakerNameDescriptionSpecification->isSatisfiedBy(trim($description));
    }
}
