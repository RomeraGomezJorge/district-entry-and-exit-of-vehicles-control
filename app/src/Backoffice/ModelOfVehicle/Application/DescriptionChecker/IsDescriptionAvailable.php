<?php

namespace App\Backoffice\ModelOfVehicle\Application\DescriptionChecker;

use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification as UniqueDescriptionSpecification;

final class IsDescriptionAvailable
{
    private UniqueDescriptionSpecification $uniqueDescriptionSpecification;

    public function __construct(
        UniqueDescriptionSpecification $uniqueDescriptionSpecification
    ) {
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
    }

    public function __invoke(
        string $description,
        string $vehicleMakerNameId
    ): bool {
        return $this->uniqueDescriptionSpecification->isSatisfiedBy(trim($description), $vehicleMakerNameId);
    }
}
