<?php

namespace App\Backoffice\VehicleBodyType\Application\DescriptionChecker;

use App\Backoffice\VehicleBodyType\Domain\UniqueVehicleBodyTypeDescriptionSpecification;

final class CheckVehicleBodyTypeDescriptionAvailability
{
    private UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification;

    public function __construct(
        UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification
    )
    {
        $this->uniqueVehicleBodyTypeDescriptionSpecification = $uniqueVehicleBodyTypeDescriptionSpecification;
    }

    public function __invoke(string $description): bool
    {
        return $this->uniqueVehicleBodyTypeDescriptionSpecification->isSatisfiedBy(trim($description));
    }
}
