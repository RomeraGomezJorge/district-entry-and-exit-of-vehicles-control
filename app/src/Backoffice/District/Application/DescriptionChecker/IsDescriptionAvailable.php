<?php

namespace App\Backoffice\District\Application\DescriptionChecker;

use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification as UniqueDescriptionSpecification;

final class IsDescriptionAvailable
{
    private UniqueDescriptionSpecification $uniqueDescriptionSpecification;

    public function __construct(UniqueDescriptionSpecification $uniqueDescriptionSpecification)
    {
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
    }

    public function __invoke(string $description): bool
    {
        return $this->uniqueDescriptionSpecification->isSatisfiedBy(trim($description));
    }
}
