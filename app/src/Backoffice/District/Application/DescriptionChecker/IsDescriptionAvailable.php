<?php

namespace App\Backoffice\District\Application\DescriptionChecker;

use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;

final class IsDescriptionAvailable
{
    private UniqueDistrictDescriptionSpecification $uniqueDescriptionSpecification;

    public function __construct(UniqueDistrictDescriptionSpecification $uniqueDescriptionSpecification)
    {
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
    }

    public function __invoke(string $description): bool
    {
        return $this->uniqueDescriptionSpecification->isSatisfiedBy(trim($description));
    }
}
